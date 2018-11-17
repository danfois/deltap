<?php


namespace AppBundle\Controller;
use AppBundle\Entity\PriceQuotation\Demand;
use AppBundle\Form\PriceQuotation\DemandType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DemandController extends Controller
{
    /**
     * @Route("create-demand", name="create_demand")
     */
    public function createDemandAction()
    {
        $d = new Demand();
        $form = $this->createForm(DemandType::class, $d);

        $html = $this->renderView('price_quotations/demand_form.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $this->generateUrl('ajax_create_demand')
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Nuova Richiesta',
            'modal_content' => $html
        ));
    }

    /**
     * @Route("ajax/create-demand", name="ajax_create_demand")
     */
    public function ajaxCreateDemandAction(Request $request)
    {
        $d = new Demand();
        $form = $this->createForm(DemandType::class, $d);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $d = $form->getData();

            $d->setStatus(Demand::UNRESOLVED);

            $em->persist($d);
            $em->flush();

            return new Response('Richiesta salvata con successo', 200);
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
     * @Route("edit-demand-{n}", name="edit_demand")
     */
    public function editDemandAction(int $n)
    {
        $d = $this->getDoctrine()->getRepository(Demand::class)->find($n);
        if($d == null) return new Response('Richiesta non trovata', 404);

        $form = $this->createForm(DemandType::class, $d);

        $html = $this->renderView('price_quotations/demand_form.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $this->generateUrl('ajax_edit_demand', array('n' => $n)),
            'edit' => '_edit'
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Modifica Richiesta',
            'modal_content' => $html
        ));
    }

    /**
     * @Route("ajax/delete-demand-{n}", name="ajax_delete_demand")
     */
    public function ajaxDeleteDemandAction(int $n)
    {
        $d = $this->getDoctrine()->getRepository(Demand::class)->find($n);
        if($d == null) return new Response('Richiesta non trovata', 404);

        if($d->getPriceQuotation() != null) return new Response('Non puoi eliminare una richiesta associata ad un preventivo', 403);

        $em = $this->getDoctrine()->getManager();
        $em->remove($d);
        $em->flush();

        return new Response('Richiesta eliminata con successo!', 200);
    }

    /**
     * @Route("ajax/edit-demand-{n}", name="ajax_edit_demand")
     */
    public function ajaxEditDemandAction(Request $request, int $n)
    {
        $d = $this->getDoctrine()->getRepository(Demand::class)->find($n);
        if($d == null) return new Response('Richiesta non trovata', 404);

        $form = $this->createForm(DemandType::class, $d);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $d = $form->getData();

            $em->flush();

            return new Response('Richiesta modificata con successo', 200);
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
     * @Route("demand-list", name="demand_list")
     */
    public function demandListAction()
    {
        return $this->render('price_quotations/demand_list.html.twig', array(
            'title' => 'Richieste Clienti',
            'new_button_name' => 'Nuova Richiesta',
            'new_button_path' => "javascript:genericModalFunction('GET', window.location.origin + '/create-demand', {}, {'initializeWidgets' : true, 'initializeForm': true, 'formJquery' : 'form_demand'} )"
        ));
    }

    /**
     * @Route("demand-status", name="demand_status")
     */
    public function demandStatusAction(Request $request)
    {
        $status = $request->query->get('status');
        if(is_numeric($status) === false || !in_array($status, [1,2,3,4])) return new Response('Richiesta effettuata in maniera non corretta', 400);

        $id = $request->query->get('id');
        if(!is_numeric($id)) return new Response('Richiesta effettuata in maniera non corretta', 400);

        $em = $this->getDoctrine()->getManager();
        $demand = $em->getRepository(Demand::class)->find($id);

        if($demand == null) return new Response('Richiesta non trovata', 404);

        $demand->setStatus($status);
        $em->flush();

        return new Response('Stato richiesta modificato con successo', 200);
    }
}