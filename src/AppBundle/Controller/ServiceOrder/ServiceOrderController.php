<?php

namespace AppBundle\Controller\ServiceOrder;

use AppBundle\Entity\PriceQuotation\PriceQuotationDetail;
use AppBundle\Entity\ServiceOrder\ServiceOrder;
use AppBundle\Form\ServiceOrder\DriverAndVehicleType;
use AppBundle\Form\ServiceOrder\ServiceOrderType;
use AppBundle\Helper\ServiceOrder\ServiceOrderCreator;
use AppBundle\Helper\ServiceOrder\ServiceOrderHelper;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
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

        if ($confirm !== null && $confirm !== 'confirm') return new Response('Pagina non Trovata', 404);

        if ($pqd == null) return new Response('Itinerario non trovato', 404);
        if ($pqd->getEmittedOrders() === 1) return new Response('Sono già stati emessi ordini di servizio per questo itinerario');
        if ($pqd->getPriceQuotation()->getStatus() !== 3) return new Response('Impossibile emettere ordini di servizio per un preventivo non confermato', 500);

        $stages = $pqd->getStages();

        $ServiceOrders = array();

        //todo: eventuale blocco try/catch per le eccezioni

        foreach ($stages as $s) {
            $soc = new ServiceOrderCreator($s);
            $soc->createOrdersAndPushInResultArray();
            $results = $soc->getResultArray();

            foreach ($results as $r) {
                $ServiceOrders[] = $r;
            }
        }

        if ($confirm === 'confirm') {
            $em = $this->getDoctrine()->getManager();
            $pqd->setEmittedOrders(1);
            foreach ($ServiceOrders as $so) {
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

    /**
     * @Route("create-service-order", name="create_service_order")
     */
    public function createServiceOrderAction()
    {
        $so = new ServiceOrder();

        $form = $this->createForm(ServiceOrderType::class, $so, array('pqd' => $so->getPriceQuotationDetail()));

        $actionUrl = $this->generateUrl('ajax_create_service_order');

        return $this->render('service_orders/service_order.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Creazione Ordine di Servizio',
            'action_url' => $actionUrl
        ));
    }

    /**
     * @Route("ajax/create-service-order", name="ajax_create_service_order")
     */
    public function createServiceOrderAjaxAction(Request $request)
    {
        $so = new ServiceOrder();

        $form = $this->createForm(ServiceOrderType::class, $so, array('pqd' => $so->getPriceQuotationDetail()));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $so = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $SOH = new ServiceOrderHelper($so, $em, false);
            $SOH->execute();
            $errors = $SOH->getErrors();

            if ($errors == null) {
                $em->flush();
                return new Response('Ordine di Servizio Creato con Successo', 200);
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

        throw new AccessDeniedException();
    }

    /**
     * @Route("edit-service-order-{id}", name="edit_service_order")
     */
    public function editServiceOrder(int $id)
    {
        $so = $this->getDoctrine()->getRepository(ServiceOrder::class)->findOneBy(array('serviceOrder' => $id));
        if ($so == null) return new Response('Ordine di Servizio non trovato', 404);

        if ($so->getReport() != null) return new Response('Impossibile modificare un Ordine di Servizio già eseguito', 500);

        $form = $this->createForm(ServiceOrderType::class, $so, array('pqd' => $so->getPriceQuotationDetail()));

        $actionUrl = $this->generateUrl('ajax_edit_service_order', array('id' => $id));

        return $this->render('service_orders/service_order.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Modifica Ordine di Servizio',
            'action_url' => $actionUrl
        ));
    }

    /**
     * @Route("ajax/edit-service-order-{id}/{assigning}", name="ajax_edit_service_order")
     */
    public function ajaxEditServiceOrderAction(Request $request, int $id, $assigning = false)
    {

        //todo: se l'ordine è stato fatturato non può essere modificato per nessun motivo

        $so = $this->getDoctrine()->getRepository(ServiceOrder::class)->findOneBy(array('serviceOrder' => $id));
        if ($so == null) return new Response('Ordine di Servizio non trovato', 404);

        if($assigning === false) {
            $form = $this->createForm(ServiceOrderType::class, $so, array('pqd' => $so->getPriceQuotationDetail()));
        } else {
            $form = $this->createForm(DriverAndVehicleType::class, $so);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $so = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $SOH = new ServiceOrderHelper($so, $em, true);
            $SOH->execute();
            $errors = $SOH->getErrors();

            if ($errors == null) {
                $em->flush();
                return new Response('Ordine di Servizio Modificato con Successo', 200);
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

        throw new AccessDeniedException();
    }

    /**
     * @Route("ajax/delete-service-order-{id}", name="delete_service_order")
     */
    public function deleteServiceOrderAction(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $so = $em->getRepository(ServiceOrder::class)->findOneBy(array('serviceOrder' => $id));

        if($so == null) return new Response('Ordine di Servizio non trovato', 404);

        $em->remove($so);
        $em->flush();

        //todo: se è stato fatturato non può essere eliminato per nessun motivo

        return new Response('Ordine di Servizio eliminato correttamente');
    }

    /**
     * @Route("assign-driver-and-vehicle", name="assign_driver_and_vehicle")
     */
    public function assignDriverAndVehicle(Request $request)
    {
        $id = $request->query->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o Ordine di Servizio non trovato', 400);

        $so = $this->getDoctrine()->getRepository(ServiceOrder::class)->findOneBy(array('serviceOrder' => $id));
        if($so == null) return new Response('Ordine di Servizio non trovato', 404);

        $form = $this->createForm(DriverAndVehicleType::class, $so);

        $actionUrl = $this->generateUrl('ajax_edit_service_order', array('id' => $id, 'assigning' => true));

        $html = $this->renderView('service_orders/assign_driver_and_vehicle.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $actionUrl
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Assegna Autista e Veicolo',
            'modal_content' => $html
        ));
    }

    /**
     * @Route("change-service-order-status", name="change_service_order_status")
     */
    public function changeServiceOrderStatusAction(Request $request)
    {
        $id = $request->query->get('id');
        $status = $request->query->get('status');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o Ordine di Servizio non trovato', 400);

        $possibleStatusArray = array(
            1 => 'da Eseguire',
            2 => 'Eseguito',
            3 => 'Annullato',
        );

        if(array_key_exists($status, $possibleStatusArray) === false) return new Response('Stato dell\'Ordine di Servizio richiesto NON valido!', 500);

        $em = $this->getDoctrine()->getManager();

        $so = $em->getRepository(ServiceOrder::class)->findOneBy(array('serviceOrder' => $id));

        if($so == null) return new Response('Preventivo non trovato', 404);

        $so->setStatus($status);
        $em->flush();

        return new Response('Ordine di Servizio impostato come ' . $possibleStatusArray[$status] . '!', 200);
    }

}