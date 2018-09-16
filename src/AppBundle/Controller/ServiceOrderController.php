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
     * @Route("confirm-service-orders-{id}/{confirm}", name="confirm_service_orders")
     */
    public function confirmServiceOrdersAction(int $id, string $confirm = null)
    {
        $pqd = $this->getDoctrine()->getRepository(PriceQuotationDetail::class)->findOneBy(array('priceQuotationDetailId' => $id));

        if($confirm !== null && $confirm !== 'confirm') return new Response('Pagina non Trovata', 404);

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

        if($confirm === 'confirm') {
            $em = $this->getDoctrine()->getManager();
            $pqd->setEmittedOrders(1);
            foreach($ServiceOrders as $so) {
                $em->persist($so);
            }
            $em->flush();

            //todo: fare il redirect alla lista degli ordini di servizio
            return new Response('Ordini di Servizio Creati', 200);
        }

        $actionUrl = $this->generateUrl('confirm_service_orders', array('id' => $id, 'confirm' => 'confirm'));

        return $this->render('service_orders/service_orders_preview.html.twig', array(
            'pqd' => $pqd,
            'serviceOrders' => $ServiceOrders,
            'action_url' => $actionUrl
        ));
    }

    /**
     * @Route("service-orders-list", name="service_orders_list")
     */
    public function serviceOrdersList()
    {
        return $this->render('service_orders/service_orders_list.html.twig');
    }
}