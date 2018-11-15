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
}