<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Invoice\IssuedInvoice;
use AppBundle\Entity\Invoice\ReceivedInvoice;
use AppBundle\Entity\Payment\Payment;
use AppBundle\Entity\Provider;
use AppBundle\Entity\Provider\ProviderRating;
use AppBundle\Form\CreateCategoryType;
use AppBundle\Form\Provider\ProviderRatingType;
use AppBundle\Form\ProviderType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProviderController extends Controller
{
    /**
     * @Route("create-provider", name="create_provider")
     */
    public function createProviderAction()
    {
        $provider = new Provider();
        $category = new Category();

        $form = $this->createForm(ProviderType::class, $provider);
        $categoryForm = $this->createForm(CreateCategoryType::class, $category);

        return $this->render('providers/provider.html.twig', array(
            'title' => 'Crea Fornitore',
            'action_url' => $this->generateUrl('create_provider_ajax'),
            'form' => $form->createView(),
            'category_form' => $categoryForm->createView()
        ));
    }

    /**
     * @Route("create-provider-ajax", name="create_provider_ajax")
     */
    public function createProviderAjax(Request $request)
    {
        $provider = new Provider();
        $form = $this->createForm(ProviderType::class, $provider);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $provider = $form->getData();
            $provider->setRegistrationDate(new \DateTime);

            $em->persist($provider);
            $em->flush();

            return new Response('Fornitore creato con successo!', 200);
        }

        return new Response('Errore', 500);
    }

    /**
     * @Route("edit-provider-{n}", name="edit_provider")
     */
    public function editProvider(int $n)
    {
        $provider = $this->getDoctrine()->getRepository(Provider::class)->find($n);
        if ($provider == null) return new Response('Fornitore non trovato', 404);

        $category = new Category();

        $form = $this->createForm(ProviderType::class, $provider);
        $categoryForm = $this->createForm(CreateCategoryType::class, $category);

        return $this->render('providers/provider.html.twig', array(
            'title' => 'Modifica Fornitore',
            'action_url' => $this->generateUrl('ajax_edit_provider', array('n' => $n)),
            'form' => $form->createView(),
            'category_form' => $categoryForm->createView()
        ));
    }

    /**
     * @Route("ajax/edit-provider-{n}", name="ajax_edit_provider")
     */
    public function ajaxEditProvider(Request $request, int $n)
    {
        $provider = $this->getDoctrine()->getRepository(Provider::class)->find($n);
        if ($provider == null) return new Response('Fornitore non trovato', 404);

        $form = $this->createForm(ProviderType::class, $provider);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $provider = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $em->flush();
            return new Response('Fornitore modificato con successo', 200);
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
     * @Route("provider-list", name="provider_list")
     */
    public function providersListAction()
    {
        return $this->render('providers/provider_list.html.twig');
    }

    /**
     * @Route("provider-details", name="provider_details")
     */
    public function providerDetailsAction(Request $request)
    {
        $id = $request->query->get('id');
        $provider = $this->getDoctrine()->getRepository(Provider::class)->find($id);

        if ($provider == null) return new Response('Questo Fornitore non è registrato', 404);

        $html = $this->renderView('providers/provider_details.html.twig', array(
            'c' => $provider
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Dettagli Fornitore - ' . $provider->getBusinessName(),
            'modal_content' => $html
        ));
    }

    /**
     * @Route("provider-invoices-{n}", name="provider_invoices")
     */
    public function providerInvoicesAction(int $n)
    {
        $invoices = $this->getDoctrine()->getRepository(ReceivedInvoice::class)->findBy(array('provider' => $n));

        $totalSum = 0;
        $paidSum = 0;
        $debtSum = 0;

        foreach ($invoices as $i) {

            $totalSum += $i->getAmount();
            $payment = $i->getPayments();
            foreach ($payment as $p) {
                if ($p->getDirection() == 'OUT') $paidSum += $p->getAmount();
            }

        }

        $html = $this->renderView('invoices/invoice_list_modal.html.twig', array(
            'invoices' => $invoices,
            'total' => $totalSum,
            'paidTotal' => $paidSum,
            'debtTotal' => $totalSum - $paidSum
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Lista Fatture per Fornitore',
            'modal_content' => $html
        ));
    }

    /**
     * @Route("/rate-invoice/{invoiceNumber}", name="rate_invoice")
     */
    public function rateInvoiceModal(int $invoiceNumber)
    {
        if($invoiceNumber == null) return new Response("Scegliere la fattura da valutare");

        $em = $this->getDoctrine()->getManager();

        $invoice = $em->getRepository(ReceivedInvoice::class)->find($invoiceNumber);
        if($invoice == null) return new Response("La fattura che stai cercando di valutare non esiste");

        $rating = $em->getRepository(ProviderRating::class)->findOneBy(array('invoice' => $invoice));
        $action_url = $this->generateUrl('ajax_edit_invoice_rating', array('invoiceNumber' => $invoiceNumber));

        if($rating == null) {
            $rating = new ProviderRating();
            $action_url = $this->generateUrl('ajax_create_invoice_rating', array('invoiceNumber' => $invoiceNumber));
        }

        $form = $this->createForm(ProviderRatingType::class, $rating);

        $html = $this->renderView('providers/invoice_rating.html.twig', array(
            'form' => $form->createView(),
            'invoice' => $invoice,
            'rating' => $rating,
            'action_url' => $action_url
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Valutazione della fattura n. ' . $invoice->getInvoiceNumber() . ' del fornitore ' . $invoice->getProvider()->getBusinessName(),
            'modal_content' => $html
        ));
    }

    /**
     * @Route("ajax-create-invoice-rating/{invoiceNumber}", name="ajax_create_invoice_rating")
     */
    public function ajaxCreateInvoiceRating(Request $request, int $invoiceNumber)
    {
        if($invoiceNumber == null) return new Response("Scegliere una fattura da valutare", 400);

        $em = $this->getDoctrine()->getManager();

        $invoice = $em->getRepository(ReceivedInvoice::class)->find($invoiceNumber);
        if($invoice == null) return new Response("La fattura che stai cercando di valutare non esiste");

        $rating = new ProviderRating();
        $form = $this->createForm(ProviderRatingType::class, $rating);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $rating = $form->getData();
            $rating
                ->setInvoice($invoice)
                ->setInsertionDate(new \DateTime())
                ->setAuthor($this->getUser());

            $em->persist($rating);
            $em->flush();

            return new Response("Votazione salvata con successo", 200);
        }

        if($form->isSubmitted() && !$form->isValid())
        {
            $errors = $form->getErrors(true);
            $error = '';

            foreach ($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        return new Response("Non sei autorizzato a fare questa operazione", 403);
    }

    /**
     * @Route("ajax-edit-invoice-rating/{invoiceNumber}", name="ajax_edit_invoice_rating")
     */
    public function ajaxEditInvoiceRating(Request $request, int $invoiceNumber)
    {
        if($invoiceNumber == null) return new Response("Scegliere una fattura da valutare", 400);

        $em = $this->getDoctrine()->getManager();

        $invoice = $em->getRepository(ReceivedInvoice::class)->find($invoiceNumber);
        if($invoice == null) return new Response("La fattura che stai cercando di valutare non esiste");

        $rating = $invoice->getRating();
        if($rating == null) return new Response("La valutazione che stai cercando di modificare non esiste", 404);

        $form = $this->createForm(ProviderRatingType::class, $rating);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $rating = $form->getData();
            $rating
                ->setInsertionDate(new \DateTime())
                ->setAuthor($this->getUser());

            $em->persist($rating);
            $em->flush();

            return new Response("Votazione salvata con successo", 200);
        }

        if($form->isSubmitted() && !$form->isValid())
        {
            $errors = $form->getErrors(true);
            $error = '';

            foreach ($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        return new Response("Non sei autorizzato a fare questa operazione", 403);
    }

    /**
     * @Route("ajax-delete-invoice-rating/{invoiceNumber}", name="ajax_delete_invoice_rating")
     */
    public function ajaxDeleteInvoiceRating(int $invoiceNumber)
    {
        if($invoiceNumber == null) return new Response("Devi scegliere una fattura", 400);
        $em = $this->getDoctrine()->getManager();

        $invoice = $em->getRepository(ReceivedInvoice::class)->find($invoiceNumber);
        if($invoice == null) return new Response("La fattura della quale vuoi cancellare la valutazione non esiste", 404);

        $rating = $invoice->getRating();
        if($rating == null) return new Response("Questa fattura non ha nessuna valutazione associata");

        $em->remove($rating);
        $em->flush();

        return new Response("Valutazione rimossa con successo", 200);
    }

    /**
     * @Route("show-ratings/{providerId}", name="show_ratings")
     */
    public function showRatings(int $providerId)
    {
        if($providerId == null) return new Response("Fornitore non valido", 400);
        $em = $this->getDoctrine()->getManager();

        $provider = $em->getRepository(Provider::class)->find($providerId);
        if($provider == null) return new Response("Fornitore non trovato", 404);

        $invoicesWithRating = $em->getRepository(ProviderRating::class)->getRatingsByProvider($providerId);

        $html = $this->renderView('providers/rating_table.html.twig', array(
            'ratings' => $invoicesWithRating,
            'count' => count($invoicesWithRating),
            'totQuality' => array_sum(array_map(function($a) {
                return $a->getQuality();
            }, $invoicesWithRating)),
            'totReliability' => array_sum(array_map(function($a) {
                return $a->getReliability();
            }, $invoicesWithRating)),
            'totPrice' => array_sum(array_map(function($a) {
                return $a->getPrice();
            }, $invoicesWithRating))
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Riepilogo valutazioni per ' . $provider->getBusinessName(),
            'modal_content' => $html
        ));
    }
}