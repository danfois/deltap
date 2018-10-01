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
            'pa_invoice_number' => $ivm->getCurrentPaInvoiceNumber()
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

        if($form->isSubmitted() && $form->isValid()) {
            $invoice = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $IH = new IssuedInvoiceHelper($invoice, $em, false);
            $IH->execute();
            $errors = $IH->getErrors();

            if($errors == null) {
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

        if($form->isSubmitted() && $form->isValid()) {
            $invoice = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $IH = new ReceivedInvoiceHelper($invoice, $em, false);
            $IH->execute();
            $errors = $IH->getErrors();

            if($errors == null) {
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
}