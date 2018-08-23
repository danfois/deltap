<?php

namespace AppBundle\Controller\Vehicle;

use AppBundle\Entity\Vehicle\Vehicle;
use AppBundle\Form\Vehicle\VehicleType;
use AppBundle\Helper\Vehicle\VehicleHelper;
use AppBundle\Serializer\VehicleViewNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;


class VehicleController extends Controller
{
    //todo: aggiugere crud per i veicoli

    /**
     * @Route("create-vehicle", name="create_vehicle")
     */
    public function createVehicleAction()
    {
        $vehicle = new Vehicle();

        $form = $this->createForm(VehicleType::class, $vehicle);

        $actionUrl = $this->generateUrl('vehicle_ajax');

        return $this->render('vehicles/create_vehicle.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Creazione Veicolo',
            'action_url' => $actionUrl
        ));
    }

    /**
     * @Route("vehicle-ajax", name="vehicle_ajax")
     */
    public function createVehicleAjax(Request $request, $isEdited = false)
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $VH = new VehicleHelper($vehicle, $em);
            $VH->execute();

            $errors = $VH->getErrors();

            if ($errors == null) {

                $em->persist($vehicle);
                $em->flush();

                return new Response('Veicolo creato con successo!', 200);
            } else {
                return new Response($errors, 500);
            }
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Accesso Negato');
    }


    /**
     * @Route("edit-vehicle-{id}", name="edit_vehicle")
     */
    public function editVehicleAction(Request $request, int $id)
    {
        $vehicle = $this->getDoctrine()->getRepository(Vehicle::class)->findOneBy(array('vehicleId' => $id));
        if($vehicle == null) return new Response('Veicolo non trovato', 404);

        $vehicle->setCarRegistrationDate($vehicle->getCarRegistrationDate()->format('d/m/Y'));
        $vehicle->setRegistrationCardDate($vehicle->getRegistrationCardDate()->format('d/m/Y'));
        $vehicle->setPurchaseDate($vehicle->getPurchaseDate()->format('d/m/Y'));
        if ($vehicle->getSaleDate() != null) $vehicle->setSaleDate($vehicle->getSaleDate()->format('d/m/Y'));
        $vehicle->setFireExtinguisherExpiration($vehicle->getFireExtinguisherExpiration()->format('d/m/Y'));

        $form = $this->createForm(VehicleType::class, $vehicle);

        $actionUrl = $this->generateUrl('ajax_edit_vehicle', array('id' => $id));

        return $this->render('vehicles/create_vehicle.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Modifica Veicolo',
            'action_url' => $actionUrl
        ));
    }

    /**
     * @Route("ajax/edit-vehicle-{id}", name="ajax_edit_vehicle")
     */
    public function editVehicleAjaxAction(Request $request, int $id)
    {
        $vehicle = $this->getDoctrine()->getRepository(Vehicle::class)->findOneBy(array('vehicleId' => $id));
        $form = $this->createForm(VehicleType::class, $vehicle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $VH = new VehicleHelper($vehicle, $em, true);
            $VH->execute();

            $errors = $VH->getErrors();

            if ($errors == null) {

                $em->flush();

                return new Response('Veicolo modificato con successo!', 200);
            } else {
                return new Response($errors, 500);
            }
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Accesso Negato');
    }

    /**
     * @Route("vehicles", name="vehicles")
     */
    public function viewVehicles()
    {
        //json is being loaded from JsonController:jsonVehicles
        return $this->render('vehicles/vehicle_list.html.twig', array(
        ));
    }

    /**
     * @Route("vehicle/brands", name="vehicle_brands")
     */
    public function vehicleBrands()
    {
        return $this->render('vehicles/brands_json.html.twig');
    }

    /**
     * @Route("vehicle/models", name="vehicle_models")
     */
    public function vehicleModelsAction()
    {
        return $this->render('vehicles/models_json.html.twig');
    }

}