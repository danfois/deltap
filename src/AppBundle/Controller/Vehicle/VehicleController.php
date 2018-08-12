<?php

namespace AppBundle\Controller\Vehicle;
use AppBundle\Entity\Vehicle\Vehicle;
use AppBundle\Form\Vehicle\VehicleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class VehicleController extends Controller
{
    /**
     * @Route("create-vehicle", name="create_vehicle")
     */
    public function createVehicleAction()
    {
        $vehicle = new Vehicle();

        $form = $this->createForm(VehicleType::class, $vehicle);

        /*return $this->render('DEBUG/show_form.html.twig', array(
            'form' => $form->createView()
        ));*/

        return $this->render('vehicles/create_vehicle.html.twig', array(
            'form' => $form->createView()
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