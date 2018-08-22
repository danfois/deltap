<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Vehicle\CarReview;
use AppBundle\Entity\Vehicle\CarTax;
use AppBundle\Entity\Vehicle\Insurance;
use AppBundle\Entity\Vehicle\InsuranceSuspension;
use AppBundle\Entity\Vehicle\Unavailability;
use AppBundle\Serializer\CarReviewViewNormalizer;
use AppBundle\Serializer\CarTaxViewNormalizer;
use AppBundle\Serializer\InsuranceSuspensionViewNormalizer;
use AppBundle\Serializer\InsuranceViewNormalizer;
use AppBundle\Serializer\UnavailabilityViewNormalizer;
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

    /**
     * @Route("json/insurance-suspensions", name="insurance_suspensions")
     */
    public function jsonInsuranceSuspensionAction(Request $request)
    {
        $id = $request->request->get('id');
        $suspensions = $this->getDoctrine()->getRepository(InsuranceSuspension::class)->findBy(array('insurance' => $id));

        $encoders = [new JsonEncoder()];
        $normalizers = [new InsuranceSuspensionViewNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($suspensions, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/cartaxes", name="car_taxes_json")
     */
    public function jsonCarTaxAction()
    {
        $carTaxes = $this->getDoctrine()->getRepository(CarTax::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new CarTaxViewNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($carTaxes, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/carreviews", name="car_review_json")
     */
    public function jsonCarReviewAction()
    {
        $carReviews = $this->getDoctrine()->getRepository(CarReview::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new CarReviewViewNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($carReviews, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/unavailabilities", name="unavailabilities_json")
     */
    public function jsonUnavailabilitiesAction()
    {
        $u= $this->getDoctrine()->getRepository(Unavailability::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new UnavailabilityViewNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($u, 'json');

        return new Response($json);
    }
}
