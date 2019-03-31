<?php

namespace AppBundle\Controller\ServiceOrder;

use AppBundle\Entity\PriceQuotation\PriceQuotationDetail;
use AppBundle\Entity\ServiceOrder\ServiceOrder;
use AppBundle\Entity\User;
use AppBundle\Entity\Vehicle\Vehicle;
use AppBundle\Form\ServiceOrder\DriverAndVehicleType;
use AppBundle\Form\ServiceOrder\ProblemType;
use AppBundle\Form\ServiceOrder\ServiceOrderType;
use AppBundle\Helper\ServiceOrder\ServiceOrderCreator;
use AppBundle\Helper\ServiceOrder\ServiceOrderHelper;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
        if ($pqd->getStatus() != PriceQuotationDetail::CONFIRMED) return new Response('Non puoi emettere ordini di servizio per un itinerario non confermato', 500);
        if ($pqd->getWrongDates() == true) return new Response('Non puoi emettere ordini di servizio per un itinerario con date NON confermate', 500);

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

            return $this->redirectToRoute('service_orders_list');
        }

        $actionUrl = $this->generateUrl('confirm_service_orders', array('id' => $id, 'confirm' => 'confirm'));

        return $this->render('service_orders/service_orders_preview.html.twig', array(
            'pqd' => $pqd,
            'serviceOrders' => $ServiceOrders,
            'action_url' => $actionUrl
        ));
    }

    /**
     * @Route("service-orders-list_old", name="service_orders_list_old")
     */
    public function serviceOrdersList()
    {
        return $this->render('service_orders/service_orders_list.html.twig');
    }

    /**
     * @Route("service-orders-list", name="service_orders_list")
     */
    public function serviceOrdersListTest()
    {
        return $this->render('service_orders/service_orders_list_test.html.twig');
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
                $em->persist($so);
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
        $so = $this->getDoctrine()->getRepository(ServiceOrder::class)->findOneBy(array('serviceOrder' => $id));
        if ($so == null) return new Response('Ordine di Servizio non trovato', 404);

        if($assigning === false) {
            $form = $this->createForm(ServiceOrderType::class, $so, array('pqd' => $so->getPriceQuotationDetail()));
        } else {
            $form = $this->createForm(DriverAndVehicleType::class, $so);
        }

        $customer = $so->getCustomer();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $so = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $SOH = new ServiceOrderHelper($so, $em, true);
            $SOH->execute();
            $errors = $SOH->getErrors();

            if($customer != $so->getCustomer() && $so->getPriceQuotation() != null) $errors .= 'Non puoi modificare il cliente se l\'Ordine di Servizio è associato ad un preventivo<br>';

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
     * @Route("mass-driver-and-vehicle-assignment-{n}", name="mass_driver_and_vehicle_assignment")
     */
    public function massDriverAndVehicleAssignment(int $n)
    {
        $so = $this->getDoctrine()->getRepository(ServiceOrder::class)->find($n);
        if($so == null) return new Response('Ordine di Servizio non trovato', 404);

        $form = $this->createForm(DriverAndVehicleType::class, $so);

        $actionUrl = $this->generateUrl('ajax_mass_driver_and_vehicle_assignment', array('n' => $n));

        $html = $this->renderView('service_orders/assign_driver_and_vehicle.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $actionUrl
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Assegna Autista e Veicolo in massa',
            'modal_content' => $html
        ));
    }

    /**
     * @Route("ajax/mass-driver-and-vehicle-assignment-{n}", name="ajax_mass_driver_and_vehicle_assignment")
     */
    public function ajaxMassDriverAndVehicleAssignment(Request $request, int $n)
    {
        $so = $this->getDoctrine()->getRepository(ServiceOrder::class)->find($n);
        if($so == null) return new Response('Ordine di Servizio non trovato', 404);

        $form = $this->createForm(DriverAndVehicleType::class, $so);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $so = $form->getData();
            $pqd = $so->getPriceQuotationDetail();

            foreach($pqd->getServiceOrders() as $s) {
                $s->setDriver($so->getDriver());
                $s->setVehicle($so->getVehicle());
            }

            $em->flush();

            return new Response('Autista e Mezzo assegnati correttamente a tutti gli Ordini di Servizio relativi a questo itinerario', 200);
        }
        return new Response('Errore durante l\'assegnazione', 500);
    }

    /**
     * @Route("ajax/assign-driver-{n}", name="ajax_assign_driver")
     */
    public function ajaxAssignDriverAction(Request $request, int $n)
    {
        $em = $this->getDoctrine()->getManager();

        $so = $em->getRepository(ServiceOrder::class)->find($n);
        if($so == null) return new Response('Ordine di Servizio non trovato!', 404);

        $driverId = $request->query->get('idUser');
        if(is_numeric($driverId) === false) return new Response('Richiesta effettuata in maniera non corretta', 400);

        $driver = $em->getRepository(User::class)->find($driverId);

        $so->setDriver($driver);
        $em->flush();

        return new Response('Autista assegnato correttamente', 200);
    }

    /**
     * @Route("ajax/assign-vehicle-{n}", name="ajax_assign_vehicle")
     */
    public function ajaxAssignVehicleAction(Request $request, int $n)
    {
        $em = $this->getDoctrine()->getManager();

        $so = $em->getRepository(ServiceOrder::class)->find($n);
        if($so == null) return new Response('Ordine di Servizio non trovato!', 404);

        $vehicleId = $request->query->get('idVehicle');
        if(is_numeric($vehicleId) === false) return new Response('Richiesta effettuata in maniera non corretta', 400);

        $vehicle = $em->getRepository(Vehicle::class)->find($vehicleId);

        $so->setVehicle($vehicle);
        $em->flush();

        return new Response('Veicolo assegnato correttamente', 200);
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

    /**
     * @Route("report-problems-{n}", name="report_problems")
     */
    public function reportProblemsAction(int $n)
    {
        $so = $this->getDoctrine()->getRepository(ServiceOrder::class)->find($n);
        if($so == null) return new Response('Nessun ordine di servizio trovato', 404);

        $form = $this->createForm(ProblemType::class, $so);

        return $this->render('service_orders/problems.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Segnalazione Problemi per Ods N. ' . $so->getServiceOrder(),
            'action_url' => $this->generateUrl('ajax_report_problems', array('n' => $n))
        ));
    }

    /**
     * @Route("ajax/report-problems-{n}", name="ajax_report_problems")
     */
    public function ajaxReportProblemsAction(Request $request, int $n)
    {
        $so = $this->getDoctrine()->getRepository(ServiceOrder::class)->find($n);
        if($so == null) return new Response('Nessun ordine di servizio trovato', 404);

        $form = $this->createForm(ProblemType::class, $so);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $so = $form->getData();

            $em->flush();
            return new Response('Segnalazione inviata con successo', 200);
        }

        return new Response('Errore durante la segnalazione dell\'errore', 500);
    }

    /**
     * @Route("view-problems-{n}", name="view_problems")
     */
    public function viewProblemsAction(int $n)
    {
        $so = $this->getDoctrine()->getRepository(ServiceOrder::class)->find($n);
        if($so == null) return new Response('Nessun ordine di servizio trovato', 404);

        if($so->getProblems() == null) {
            return $this->render('includes/generic_modal_content.html.twig', array(
                'modal_title' => 'Problemi Ordine di Servizio n.' . $so->getServiceOrder(),
                'modal_content' => '<h5 class="m--padding-20 m--font-success">Nessun problema per questo Ordine di Servizio</h5>'
            ));
        }

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Problemi Ordine di Servizio n.' . $so->getServiceOrder(),
            'modal_content' => '<div class="m--padding-20">' . $so->getProblems() . '</div>'
        ));
    }

    /**
     * @Route("print/service-order-{n}", name="print_service_order")
     */
    public function printServiceOrder(int $n)
    {
        $so = $this->getDoctrine()->getRepository(ServiceOrder::class)->find($n);
        if($so == null) return new Response('Ordine di Servizio non trovato', 404);

        $url = $this->generateUrl("print_service_order_effectively", array("n" => $n), UrlGeneratorInterface::ABSOLUTE_URL);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://greenteamsrl.it/maps-api/external-print/so/" . $n);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);

        return new PdfResponse($result);
    }

    /**
     * @Route("print-service-order-{n}", name="print_service_order_effectively")
     */
    public function printServiceOrderEffectively($n) {
        $so = $this->getDoctrine()->getRepository(ServiceOrder::class)->find($n);
        if($so == null) return new Response('Ordine di Servizio non trovato', 404);

        return $this->render('PRINTS/service_order.html.twig', array('so' => $so));
    }


    /**
     * @Route("print/repeated-service-order-{n}", name="print-repeated-service-order")
     */
    public function printRepeatedServiceOrderRemoteAction(int $n) {
        $so = $this->getDoctrine()->getRepository(ServiceOrder::class)->find($n);
        if($so == null) return new Response('Ordine di Servizio non trovato', 404);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://greenteamsrl.it/maps-api/external-print/re-so/" . $n);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);

        return new PdfResponse($result);
    }


    /**
     * @Route("print-repeated-service-order-{n}", name="print_repeated_service_order")
     */
    public function printRepeatedServiceOrderAction(int $n)
    {
        $so = $this->getDoctrine()->getRepository(ServiceOrder::class)->find($n);
        if($so == null) return new Response('Ordine di Servizio non trovato', 404);

        $pqd = $so->getPriceQuotationDetail();
        if($pqd == null) return new Response('Nessun itinerario associato a questo Ordine di Servizio', 500);

        if(count($pqd->getServiceOrders()) <= 1) return new Response('Ordine di Servizio non ripetitivo', 500);

        return $this->render('PRINTS/repeated_service_order.html.twig', array('pqd' => $pqd));

//        $html = $this->renderView('PRINTS/repeated_service_order.html.twig', array('pqd' => $pqd));
//
//        return new PdfResponse(
//            $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
//                'orientation' => 'Landscape'
//            ))
//        );
    }

}