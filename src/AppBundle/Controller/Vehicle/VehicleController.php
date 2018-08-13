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

        return $this->render('vehicles/create_vehicle.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("create-vehicle-ajax", name="create_vehicle_ajax")
     */
    public function createVehicleAjax(Request $request)
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

                return new Response('OK', 200);
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