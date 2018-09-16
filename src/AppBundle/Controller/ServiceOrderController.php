<?php

namespace AppBundle\Controller;
use AppBundle\Entity\PriceQuotation\PriceQuotationDetail;
use AppBundle\Helper\ServiceOrder\ServiceOrderCreator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceOrderController extends Controller
{
    /**
     * @Route("confirm-service-orders-{id}", name="confirm_service_orders")
     */
    public function confirmServiceOrdersAction(int $id)
    {
        $pqd = $this->getDoctrine()->getRepository(PriceQuotationDetail::class)->findOneBy(array('priceQuotationDetailId' => $id));

        if($pqd == null) return new Response('Itinerario non trovato', 404);
        if($pqd->getEmittedOrders() === 1) return new Response('Sono già stati emessi ordini di servizio per questo itinerario');
        if($pqd->getPriceQuotation()->getStatus() !== 3) return new Response('Impossibile emettere ordini di servizio per un preventivo non confermato', 500);

        $stages = $pqd->getStages();

        $ServiceOrders = array();

        //todo: eventuale blocco try/catch per le eccezioni

        foreach($stages as $s) {
            $soc = new ServiceOrderCreator($s);
            $soc->createOrdersAndPushInResultArray();
            $results = $soc->getResultArray();

            foreach($results as $r) {
                $ServiceOrders[] = $r;
            }
        }


        return $this->render('DEBUG/form_data.html.twig', array(
            'title' => 'Debug Ordini di Servizio',
            'data' => $ServiceOrders
        ));
    }
}