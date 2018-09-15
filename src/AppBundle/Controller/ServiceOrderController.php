<?php

namespace AppBundle\Controller;
use AppBundle\Entity\PriceQuotation\PriceQuotationDetail;
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
        if($pqd->getPriceQuotation()->getStatus !== 3) return new Response('Impossibile emettere ordini di servizio per un preventivo non confermato', 500);

        $stages = $pqd->getStages();

        /*
         * Nel microframework degli ordini di servizio ho una classe di ingresso che prende come parametro lo Stage e un array dove inserire
         * i vari ordini di servizio
         */

        $ServiceOrders = array();

        foreach($stages as $s) {

        }
    }
}