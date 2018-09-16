<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Document;
use AppBundle\Entity\Employee\Curriculum;
use AppBundle\Entity\Employee\DriverQualificationLetter;
use AppBundle\Entity\Employee\DrivingLetter;
use AppBundle\Entity\Employee\DrivingLicense;
use AppBundle\Entity\Employee\Employee;
use AppBundle\Entity\PriceQuotation\PriceQuotation;
use AppBundle\Entity\PriceQuotation\PriceQuotationDetail;
use AppBundle\Entity\ServiceOrder\ServiceOrder;
use AppBundle\Entity\Vehicle\CarReview;
use AppBundle\Entity\Vehicle\CarTax;
use AppBundle\Entity\Vehicle\Insurance;
use AppBundle\Entity\Vehicle\InsuranceSuspension;
use AppBundle\Entity\Vehicle\Unavailability;
use AppBundle\Serializer\CarReviewViewNormalizer;
use AppBundle\Serializer\CarTaxViewNormalizer;
use AppBundle\Serializer\CurriculumViewNormalizer;
use AppBundle\Serializer\DocumentViewNormalizer;
use AppBundle\Serializer\DrivingDocumentViewNormalizer;
use AppBundle\Serializer\EmployeeViewNormalizer;
use AppBundle\Serializer\InsuranceSuspensionViewNormalizer;
use AppBundle\Serializer\InsuranceViewNormalizer;
use AppBundle\Serializer\PriceQuotationDetailViewNormalizer;
use AppBundle\Serializer\PriceQuotationViewNormalizer;
use AppBundle\Serializer\ServiceOrderViewNormalizer;
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

    /**
     * @Route("json/employees", name="employees_json")
     */
    public function jsonEmployeesAction()
    {
        $e = $this->getDoctrine()->getRepository(Employee::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new EmployeeViewNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($e, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/driving-documents/{type}", name="driving_documents_json")
     */
    public function jsonDrivingDocuments(string $type)
    {
        $repositoryClass = '';

        switch($type) {
            case 'driving-license':
                $repositoryClass = DrivingLicense::class;
                break;
            case 'driving-letter':
                $repositoryClass = DrivingLetter::class;
                break;
            case 'qualification-letter':
                $repositoryClass = DriverQualificationLetter::class;
                break;
        }

        $data = $this->getDoctrine()->getRepository($repositoryClass)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new DrivingDocumentViewNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($data, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/documents", name="documents_json")
     */
    public function jsonDocuments(Request $request)
    {
        $id = $request->request->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta', 400);

        $type = $request->request->get('type');
        if($type == null) return new Response('Richiesta effettuata in maniera non corretta', 400);

        switch($type) {
            case 'driving-license':
                $data = $this->getDoctrine()->getRepository(Document::class)->findBy(array('drivingLicense' => $id));
                break;
            case 'driving-letter':
                $data = $this->getDoctrine()->getRepository(Document::class)->findBy(array('drivingLetter' => $id));
                break;
            case 'qualification-letter':
                $data = $this->getDoctrine()->getRepository(Document::class)->findBy(array('driverQualificationLetter' => $id));
                break;
            case 'curriculum':
                $data = $this->getDoctrine()->getRepository(Document::class)->findBy(array('curriculum' => $id));
                break;
        }

        if(!isset($data)) return new Response('Nessun Documento trovato', 404);

        $encoders = [new JsonEncoder()];
        $normalizers = [new DocumentViewNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($data, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/curriculums", name="json_curriculums")
     */
    public function jsonCurriculumsAction()
    {
        $curriculums = $this->getDoctrine()->getRepository(Curriculum::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new CurriculumViewNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($curriculums, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/price-quotations", name="json_price_quotations")
     */
    public function jsonPriceQuotationsAction()
    {
        $pq = $this->getDoctrine()->getRepository(PriceQuotation::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new PriceQuotationViewNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($pq, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/price-quotation-details", name="json_price_quotations_details")
     */
    public function jsonPriceQuotationsDetailsAction(Request $request)
    {
        $id = $request->request->get('id');

        $pqd = $this->getDoctrine()->getRepository(PriceQuotationDetail::class)->findBy(array('priceQuotation' => $id));

        $encoders = [new JsonEncoder()];
        $normalizers = [new PriceQuotationDetailViewNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($pqd, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/service-orders", name="json_service_orders")
     */
    public function jsonServiceOrdersAction()
    {
        $so = $this->getDoctrine()->getRepository(ServiceOrder::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new ServiceOrderViewNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($so, 'json');

        return new Response($json);
    }


}
