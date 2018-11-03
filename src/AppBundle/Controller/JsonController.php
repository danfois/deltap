<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Document;
use AppBundle\Entity\Employee\Curriculum;
use AppBundle\Entity\Employee\DriverQualificationLetter;
use AppBundle\Entity\Employee\DrivingLetter;
use AppBundle\Entity\Employee\DrivingLicense;
use AppBundle\Entity\Employee\Employee;
use AppBundle\Entity\Invoice\IssuedInvoice;
use AppBundle\Entity\Invoice\ReceivedInvoice;
use AppBundle\Entity\Loan\Loan;
use AppBundle\Entity\Loan\LoanInstalment;
use AppBundle\Entity\Payment\BankAccount;
use AppBundle\Entity\Payment\Payment;
use AppBundle\Entity\PriceQuotation\PriceQuotation;
use AppBundle\Entity\PriceQuotation\PriceQuotationDetail;
use AppBundle\Entity\Provider;
use AppBundle\Entity\PurchaseOrder\PurchaseOrder;
use AppBundle\Entity\PurchaseOrder\PurchaseOrderDetail;
use AppBundle\Entity\Salary\Salary;
use AppBundle\Entity\Salary\SalaryDetail;
use AppBundle\Entity\ServiceOrder\ServiceOrder;
use AppBundle\Entity\Vehicle\CarReview;
use AppBundle\Entity\Vehicle\CarTax;
use AppBundle\Entity\Vehicle\Insurance;
use AppBundle\Entity\Vehicle\InsuranceSuspension;
use AppBundle\Entity\Vehicle\Unavailability;
use AppBundle\Serializer\BankAccountNormalizer;
use AppBundle\Serializer\CarReviewViewNormalizer;
use AppBundle\Serializer\CarTaxViewNormalizer;
use AppBundle\Serializer\CurriculumViewNormalizer;
use AppBundle\Serializer\CustomerNormalizer;
use AppBundle\Serializer\DocumentViewNormalizer;
use AppBundle\Serializer\DrivingDocumentViewNormalizer;
use AppBundle\Serializer\EmployeeViewNormalizer;
use AppBundle\Serializer\InsuranceSuspensionViewNormalizer;
use AppBundle\Serializer\InsuranceViewNormalizer;
use AppBundle\Serializer\IssuedInvoiceSerializer;
use AppBundle\Serializer\LoanInstalmentNormalizer;
use AppBundle\Serializer\LoanNormalizer;
use AppBundle\Serializer\PaymentNormalizer;
use AppBundle\Serializer\PriceQuotationDetailViewNormalizer;
use AppBundle\Serializer\PriceQuotationViewNormalizer;
use AppBundle\Serializer\ProviderNormalizer;
use AppBundle\Serializer\PurchaseOrderDetailNormalizer;
use AppBundle\Serializer\PurchaseOrderNormalizer;
use AppBundle\Serializer\ReceivedInvoiceSerializer;
use AppBundle\Serializer\SalaryDetailNormalizer;
use AppBundle\Serializer\SalaryNormalizer;
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
     * @Route("json/customers", name="customers_json")
     */
    public function jsonCustomersAction()
    {
        $customers = $this->getDoctrine()->getRepository(Customer::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new CustomerNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($customers, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/providers", name="providers_json")
     */
    public function jsonProvidersAction()
    {
        $providers = $this->getDoctrine()->getRepository(Provider::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new ProviderNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($providers, 'json');

        return new Response($json);
    }

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
        $u = $this->getDoctrine()->getRepository(Unavailability::class)->findAll();

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

        switch ($type) {
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
        if (is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta', 400);

        $type = $request->request->get('type');
        if ($type == null) return new Response('Richiesta effettuata in maniera non corretta', 400);

        switch ($type) {
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

        if (!isset($data)) return new Response('Nessun Documento trovato', 404);

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

    /**
     * @Route("json/issued-invoices", name="json_issued_invoices")
     */
    public function jsonIssuedInvoices()
    {
        $i = $this->getDoctrine()->getRepository(IssuedInvoice::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new IssuedInvoiceSerializer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($i, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/received-invoices", name="json_received_invoices")
     */
    public function jsonReceivedInvoices()
    {
        $i = $this->getDoctrine()->getRepository(ReceivedInvoice::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new ReceivedInvoiceSerializer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($i, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/bank-accounts", name="json_bank_accounts")
     */
    public function jsonBankAccountsAction()
    {
        $ba = $this->getDoctrine()->getRepository(BankAccount::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new BankAccountNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($ba, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/payments", name="json_payments")
     */
    public function jsonPaymentsAction(Request $request)
    {
        $id = $request->request->get('id');
        $invoiceType = $request->request->get('invoiceType');

        if(is_numeric($id) !== false && $id != '' && $invoiceType != '') {
            $payments = $this->getDoctrine()->getRepository(Payment::class)->findBy(array($invoiceType => $id));
        } else {
            $payments = $this->getDoctrine()->getRepository(Payment::class)->findAll();
        }

        $encoders = [new JsonEncoder()];
        $normalizers = [new PaymentNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($payments, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/purchase-orders", name="json_purchase_orders")
     */
    public function jsonPurchaseOrders()
    {
        $po = $this->getDoctrine()->getRepository(PurchaseOrder::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new PurchaseOrderNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($po, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/purchase-order-details", name="json_purchase_order_details")
     */
    public function jsonPurchaseOrderDetails(Request $request)
    {
        $id = $request->request->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettutata in maniera non corretta', 400);

        $pod = $this->getDoctrine()->getRepository(PurchaseOrderDetail::class)->findBy(array('purchaseOrder' => $id));

        $encoders = [new JsonEncoder()];
        $normalizers = [new PurchaseOrderDetailNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($pod, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/loans", name="json_loans")
     */
    public function jsonLoansAction()
    {
        $loans = $this->getDoctrine()->getRepository(Loan::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new LoanNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($loans, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/loan-instalments", name="json_loan_instalments")
     */
    public function jsonLoansInstalments(Request $request)
    {
        $id = $request->request->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta', 400);

        $instalments = $this->getDoctrine()->getRepository(LoanInstalment::class)->findBy(array('loan' => $id));

        $encoders = [new JsonEncoder()];
        $normalizers = [new LoanInstalmentNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($instalments, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/salaries", name="json_salaries")
     */
    public function jsonSalariesAction()
    {
        $salaries = $this->getDoctrine()->getRepository(Salary::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new SalaryNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($salaries, 'json');

        return new Response($json);
    }

    /**
     * @Route("json/salary-details", name="json_salary_details")
     */
    public function jsonSalaryDetailsAction(Request $request)
    {
        $id = $request->request->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta', 400);

        $details = $this->getDoctrine()->getRepository(SalaryDetail::class)->findBy(array('salary' => $id));

        $encoders = [new JsonEncoder()];
        $normalizers = [new SalaryDetailNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($details, 'json');

        return new Response($json);
    }

}
