<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Vehicle\Insurance;
use AppBundle\Serializer\InsuranceViewNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use AppBundle\Entity\Vehicle\Vehicle;
use AppBundle\Serializer\VehicleViewNormalizer;

class JsonController extends Controller
{
    /**
     * @Route("json/vehicles", name="vehicles_json")
     */
    public function jsonVehiclesAction()
    {
        $vehicles = $this->getDoctrine()->getRepository(Vehicle::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new VehicleViewNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($vehicles, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/insurances", name="insurances_json")
     */
    public function jsonInsurancesAction()
    {
        $insurances = $this->getDoctrine()->getRepository(Insurance::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new InsuranceViewNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($insurances, 'json');

        return new Response($json);
    }
}
