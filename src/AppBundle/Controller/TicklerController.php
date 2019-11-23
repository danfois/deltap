<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Expiration;
use AppBundle\Entity\Invoice\IssuedInvoice;
use AppBundle\Entity\Invoice\ReceivedInvoice;
use AppBundle\Form\ExpirationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TicklerController extends Controller
{
    /**
     * @Route("tickler", name="tickler")
     */
    public function ticklerAction()
    {
        return $this->render('tickler/tickler.html.twig');
    }

    /**
     * @Route("create-expiration", name="create_expiration")
     */
    public function createExpirationAction()
    {
        $e = new Expiration();
        $form = $this->createForm(ExpirationType::class, $e);

        $html = $this->renderView('expirations/expiration_form.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $this->generateUrl("ajax_create_expiration")
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => "Nuova Scadenza",
            'modal_content' => $html
        ));
    }

    /**
     * @Route("create-expiration-from-issued-invoice/{id}", name="create_expiration_from_issued_invoice")
     */
    public function createExpirationFromIssuedInvoiceAction(int $id) {
        $issuedInvoice = $this->getDoctrine()->getRepository(IssuedInvoice::class)->find($id);
        if($issuedInvoice == null) return new Response('Fattura non trovata', 404);

        $e = new Expiration();
        $e->setIssuedInvoice($issuedInvoice)
            ->setUser($this->getUser())
            ->setDescription("Scadenza Fattura Emessa n. {$issuedInvoice->getInvoiceNumber()}")
            ->setCreatedAt(new \DateTime())
            ->setIsResolved(false)
            ->setTitle("Scadenza Fattura Emessa n. {$issuedInvoice->getInvoiceNumber()}");

        $form = $this->createForm(ExpirationType::class, $e);

        $html = $this->renderView('expirations/expiration_form.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $this->generateUrl("ajax_create_expiration")
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => "Nuova Scadenza",
            'modal_content' => $html
        ));
    }

    /**
     * @Route("create-expiration-from-received-invoice/{id}", name="create_expiration_from_received_invoice")
     */
    public function createExpirationFromReceivedInvoiceAction(int $id) {
        $receivedInvoice = $this->getDoctrine()->getRepository(ReceivedInvoice::class)->find($id);
        if($receivedInvoice== null) return new Response('Fattura non trovata', 404);

        $e = new Expiration();
        $e->setReceivedInvoice($receivedInvoice)
            ->setUser($this->getUser())
            ->setDescription("Scadenza Fattura Ricevuta n. {$receivedInvoice->getInvoiceNumber()}")
            ->setCreatedAt(new \DateTime())
            ->setIsResolved(false)
            ->setTitle("Scadenza Fattura Emessa n. {$receivedInvoice->getInvoiceNumber()}");

        $form = $this->createForm(ExpirationType::class, $e);

        $html = $this->renderView('expirations/expiration_form.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $this->generateUrl("ajax_create_expiration")
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => "Nuova Scadenza",
            'modal_content' => $html
        ));
    }

    /**
     * @Route("ajax/create-expiration", name="ajax_create_expiration")
     */
    public function ajaxCreateExpiration(Request $request)
    {
        $e = new Expiration();
        $form = $this->createForm(ExpirationType::class, $e);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $e = $form->getData();
            $e->setIsResolved(false);
            $e->setCreatedAt(new \DateTime());
            $e->setUser($this->getUser());

            $em->persist($e);
            $em->flush();

            return new Response('Scadenza salvata con successo. Potrai trovarla nella lista scadenze, o se è idonea anche nello scadenziario.', 200);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach ($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        return new Response('Non sei autorizzato a fare questa operazione', 500);
    }

    /**
     * @Route("edit-expiration-{n}", name="edit_expiration")
     */
    public function editExpirationAction(int $n)
    {
        $d = $this->getDoctrine()->getRepository(Expiration::class)->find($n);
        if($d == null) return new Response('Scadenza non trovata', 404);

        $form = $this->createForm(ExpirationType::class, $d);

        $html = $this->renderView('expirations/expiration_form.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $this->generateUrl('ajax_edit_expiration', array('n' => $n)),
            'edit' => '_edit'
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Modifica Scadenza',
            'modal_content' => $html
        ));
    }

    /**
     * @Route("ajax/edit-expiration-{n}", name="ajax_edit_expiration")
     */
    public function ajaxEditExpirationAction(Request $request, int $n)
    {
        $d = $this->getDoctrine()->getRepository(Expiration::class)->find($n);
        if($d == null) return new Response('Scadenza non trovata', 404);

        $form = $this->createForm(ExpirationType::class, $d);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $d = $form->getData();

            $em->flush();

            return new Response('Scadenza modificata con successo', 200);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach ($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        return new Response('Non sei autorizzato a fare questa operazione', 500);
    }

    /**
     * @Route("expiration-list", name="expiration_list")
     */
    public function expirationListAction()
    {
        return $this->render('expirations/expiration_list.html.twig', array(
            'title' => 'Scadenze',
            'new_button_name' => 'Nuova Scadenza',
            'new_button_path' => "javascript:genericModalFunction('GET', window.location.origin + '/create-expiration', {}, {'initializeWidgets' : true, 'initializeForm': true, 'formJquery' : 'form_expiration'} )"
        ));
    }
}