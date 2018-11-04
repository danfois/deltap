<?php

namespace AppBundle\Controller\Invoice;

use AppBundle\Entity\Invoice\InvoiceDetail;
use AppBundle\Entity\Invoice\IssuedInvoice;
use AppBundle\Entity\Invoice\ReceivedInvoice;
use AppBundle\Form\Invoice\IssuedInvoiceType;
use AppBundle\Form\Invoice\ReceivedInvoiceType;
use AppBundle\Helper\Invoice\IssuedInvoiceHelper;
use AppBundle\Helper\Invoice\ReceivedInvoiceHelper;
use AppBundle\Service\Invoice\InvoiceNumberManager;
use AppBundle\Service\Invoice\InvoiceRequestManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    /**
     * @Route("/issue-invoice", name="issue_invoice")
     */
    public function issueInvoice(InvoiceNumberManager $ivm)
    {
        $invoice = new IssuedInvoice();
        $detail = new InvoiceDetail();

        $invoice
            ->setInvoiceNumber($ivm->getCurrentInvoiceNumber())
            ->setInvoiceDate(new \DateTime())
            ->addInvoiceDetail($detail);

        $form = $this->createForm(IssuedInvoiceType::class, $invoice);

        $actionUrl = $this->generateUrl('ajax_issue_invoice');

        return $this->render('invoices/invoice_form.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Emetti Fattura',
            'action_url' => $actionUrl,
            'type' => 'issued',
            'pa_invoice_number' => $ivm->getCurrentPaInvoiceNumber(),
            'proforma_number' => $ivm->getCurrentProformaNumber()
        ));
    }

    /**
     * @Route("ajax/issue-invoice", name="ajax_issue_invoice")
     */
    public function ajaxIssueInvoiceAction(Request $request)
    {
        $invoice = new IssuedInvoice();
        $form = $this->createForm(IssuedInvoiceType::class, $invoice);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoice = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $IH = new IssuedInvoiceHelper($invoice, $em, false);
            $IH->execute();
            $errors = $IH->getErrors();

            if ($errors == null) {
                $em->persist($invoice);
                $em->flush();

                return new Response('Fattura emessa con successo!', 200);
            }
            return new Response($errors, 500);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach ($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Accesso Negato');
    }

    /**
     * @Route("receive-invoice", name="receive_invoice")
     */
    public function receiveInvoiceAction()
    {
        $invoice = new ReceivedInvoice();
        $detail = new InvoiceDetail();

        $invoice
            ->setInvoiceDate(new \DateTime())
            ->addInvoiceDetail($detail);

        $form = $this->createForm(ReceivedInvoiceType::class, $invoice);

        $actionUrl = $this->generateUrl('ajax_receive_invoice');

        return $this->render('invoices/invoice_form.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Ricevi Fattura',
            'action_url' => $actionUrl,
            'type' => 'received',
            'pa_invoice_number' => ''
        ));
    }

    /**
     * @Route("ajax/receive-invoice", name="ajax_receive_invoice")
     */
    public function ajaxReceiveInvoiceAction(Request $request)
    {
        $invoice = new ReceivedInvoice();

        $form = $this->createForm(ReceivedInvoiceType::class, $invoice);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoice = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $IH = new ReceivedInvoiceHelper($invoice, $em, false);
            $IH->execute();
            $errors = $IH->getErrors();

            if ($errors == null) {
                $em->persist($invoice);
                $em->flush();

                return new Response('Fattura registrata con successo!', 200);
            }
            return new Response($errors, 500);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach ($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Accesso Negato');
    }

    /**
     * @Route("generate-invoice", name="generate-invoice")
     */
    public function generateInvoiceAction(Request $request, InvoiceNumberManager $ivm)
    {
        $em = $this->getDoctrine()->getManager();
        $irm = new InvoiceRequestManager($em, $request);
        $ifm = $irm->generateInvoiceFormManager()->getInvoiceFormManager();

        $invoice = $ifm->manageInvoiceData()->getInvoice();
        $invoice->setInvoiceDate(new \DateTime());

        if ($invoice instanceof IssuedInvoice) {
            $invoice->setInvoiceNumber($ivm->getCurrentInvoiceNumber());
            $pa = $ivm->getCurrentPaInvoiceNumber();
            $form = $this->createForm(IssuedInvoiceType::class, $invoice);
            $type = 'issued';
            $title = 'Emetti Fattura';
            $actionUrl = $this->generateUrl('ajax_issue_invoice');

        } else if ($invoice instanceof ReceivedInvoice) {
            $form = $this->createForm(ReceivedInvoiceType::class, $invoice);
            $type = 'received';
            $title = 'Ricevi Fattura';
            $pa = '';
            $actionUrl = $this->generateUrl('ajax_receive_invoice');

        } else {
            throw new \Exception('Errore durante la creazione del form');
        }

        return $this->render('invoices/invoice_form.html.twig', array(
            'form' => $form->createView(),
            'title' => $title,
            'action_url' => $actionUrl,
            'type' => $type,
            'pa_invoice_number' => $pa
        ));
    }

    /**
     * @Route("edit-issued-invoice-{n}", name="edit-invoice")
     */
    public function editInvoiceAction(int $n)
    {
        $invoice = $this->getDoctrine()->getRepository(IssuedInvoice::class)->findOneBy(array('invoiceId' => $n));
        if($invoice == null) return new Response('Fattura non trovata', 404);

        if($invoice->getPaInvoice() == 1) $invoice->setPaInvoice(true);
        if($invoice->getPaInvoice() == 0) $invoice->setPaInvoice(false);

        if($invoice->getIsProforma() == 1) $invoice->setIsProforma(true);
        if($invoice->getIsProforma() == 0) $invoice->setIsProforma(false);

        $form = $this->createForm(IssuedInvoiceType::class, $invoice);

        $actionUrl = $this->generateUrl('ajax_edit_issued_invoice', array('n' => $n));

        return $this->render('invoices/invoice_form.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Modifica Fattura Emessa',
            'action_url' => $actionUrl,
            'type' => 'issued',
            'pa_invoice_number' => '',
            'proforma_number' => $invoice->getProformaNumber()
        ));
    }

    /**
     * @Route("ajax/edit-issued-invoice-{n}", name="ajax_edit_issued_invoice")
     */
    public function ajaxEditIssuedInvoiceAction(Request $request, int $n)
    {
        $em = $this->getDoctrine()->getManager();
        $invoice = $em->getRepository(IssuedInvoice::class)->findOneBy(array('invoiceId' => $n));
        if($invoice == null) return new Response('Fattura non trovata', 404);

        if($invoice->getPaInvoice() == 1) $invoice->setPaInvoice(true);
        if($invoice->getPaInvoice() == 0) $invoice->setPaInvoice(false);

        if($invoice->getIsProforma() == 1) $invoice->setIsProforma(true);
        if($invoice->getIsProforma() == 0) $invoice->setIsProforma(false);

        $form = $this->createForm(IssuedInvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoice = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $IH = new IssuedInvoiceHelper($invoice, $em, true);
            $IH->execute();
            $errors = $IH->getErrors();

            if ($errors == null) {
                $em->flush();

                return new Response('Fattura modificata con successo!', 200);
            }
            return new Response($errors, 500);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach ($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Accesso Negato');
    }

    /**
     * @Route("edit-received-invoice-{n}", name="edit_received_invoice")
     */
    public function editReceivedInvoiceAction(int $n)
    {
        $invoice = $this->getDoctrine()->getRepository(ReceivedInvoice::class)->findOneBy(array('invoiceId' => $n));
        if($invoice == null) return new Response('Fattura non trovata', 404);

        if($invoice->getPaInvoice() == 1) $invoice->setPaInvoice(true);
        if($invoice->getPaInvoice() == 0) $invoice->setPaInvoice(false);

        $form = $this->createForm(ReceivedInvoiceType::class, $invoice);

        $actionUrl = $this->generateUrl('ajax_edit_received_invoice', array('n' => $n));

        return $this->render('invoices/invoice_form.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Modifica Fattura Ricevuta',
            'action_url' => $actionUrl,
            'type' => 'received',
            'pa_invoice_number' => ''
        ));
    }

    /**
     * @Route("ajax/edit-received-invoice-{n}", name="ajax_edit_received_invoice")
     */
    public function ajaxEditReceivedInvoiceAction(Request $request, int $n)
    {
        $em = $this->getDoctrine()->getManager();
        $invoice = $em->getRepository(ReceivedInvoice::class)->findOneBy(array('invoiceId' => $n));
        if($invoice == null) return new Response('Fattura non trovata', 404);

        if($invoice->getPaInvoice() == 1) $invoice->setPaInvoice(true);
        if($invoice->getPaInvoice() == 0) $invoice->setPaInvoice(false);

        $form = $this->createForm(ReceivedInvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoice = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $IH = new ReceivedInvoiceHelper($invoice, $em, true);
            $IH->execute();
            $errors = $IH->getErrors();

            if ($errors == null) {
                $em->flush();

                return new Response('Fattura modificata con successo!', 200);
            }
            return new Response($errors, 500);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach ($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Accesso Negato');
    }

    /**
     * @Route("issued-invoice-list", name="issued_invoice_list")
     */
    public function issuedInvoiceListAction()
    {
        return $this->render('invoices/issued_invoice_list.html.twig');
    }

    /**
     * @Route("received-invoice-list", name="received_invoice_list")
     */
    public function receivedInvoiceListAction()
    {
        return $this->render('invoices/received_invoice_list.html.twig');
    }

    /**
     * @Route("proforma-to-invoice-{n}", name="proforma_to_invoice")
     */
    public function proformaToInvoice(int $n, InvoiceNumberManager $ivm)
    {
        $em = $this->getDoctrine()->getManager();
        $proforma = $em->getRepository(IssuedInvoice::class)->findBy(array('invoiceId' => $n, 'isProforma' => 1))[0];
        if($proforma == null) return new Response('Proforma non trovato', 404);

        $proforma->setInvoiceNumber($ivm->getCurrentInvoiceNumber());
        $proforma->setIsProforma(null);

        $em->flush();

        return new Response('Trasformazione avvenuta con successo!', 200);
    }

}