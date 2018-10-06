<?php

namespace AppBundle\Service\Invoice;

use AppBundle\Entity\Invoice\IssuedInvoice;
use AppBundle\Entity\Invoice\ReceivedInvoice;
use AppBundle\Entity\PriceQuotation\PriceQuotation;
use AppBundle\Entity\ServiceOrder\ServiceOrder;
use AppBundle\Entity\Vehicle\CarReview;
use AppBundle\Entity\Vehicle\Insurance;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class InvoiceRequestManager
{
    protected $em;
    protected $request;
    protected $parametersArray;
    protected $invoice;
    protected $data;
    protected $invoiceFormManager;

    public function __construct(EntityManager $entityManager, Request $request)
    {
        $this->em = $entityManager;
        $this->request = $request;
    }

    public function getInvoiceFormManager() : InvoiceFormManager
    {
        if($this->invoiceFormManager == null) throw new \Exception('InvoiceFormManager not instantiated');

        return $this->invoiceFormManager;
    }

    public function generateInvoiceFormManager()
    {
        $this->createParametersArray();
        $this->checkIfParametersAreCorrect();
        $this->instantiateInvoice();
        $this->fetchData();
        $this->createInvoiceFormManagerInstance();

        return $this;
    }

    protected function createInvoiceFormManagerInstance()
    {
        if($this->data == null) throw new \Exception('Nessun dato per la creazione della fattura');
        if($this->invoice == null) throw new \Exception('La fattura non è stata istanziata');

        $this->invoiceFormManager = new InvoiceFormManager($this->invoice, $this->data);

        return true;
    }

    protected function createParametersArray()
    {
        $this->parametersArray = array(
            'dataType' => $this->request->query->get('datatype'),
            'type' => $this->request->query->get('type'),
            'data' => $this->request->query->get('data')
        );
    }

    protected function checkIfParametersAreCorrect()
    {
        $pa = $this->parametersArray;

        $allowedDataTypes = array(
            'priceQuotation' => 'issued',
            'serviceOrders' => 'issued',
            'insurances' => 'received',
            'reviews' => 'received'
        );

        if ($pa['type'] == null)                                                throw new \Exception('Specificare il tipo della fattura');
        if ($pa['type'] != 'issued' && $pa['type'] != 'received')               throw new \Exception('Tipo di fattura non valido');
        if ($pa['dataType'] == null)                                            throw new \Exception('Specificare cosa si vuole fatturare');
        if ($pa['data'] == null)                                                throw new \Exception('Nessun oggetto specificato per la fatturazione');
        if (array_key_exists($pa['dataType'], $allowedDataTypes) === false)     throw new \Exception('Tipo di oggetto non fatturabile');
        if ($allowedDataTypes[$pa['dataType']] != $pa['type'])                  throw new \Exception('Tipo di fattura non corretto in base ai dati specificati');

        return true;
    }

    protected function instantiateInvoice()
    {
        switch($this->parametersArray['type']) {
            case 'issued':
                $this->invoice = new IssuedInvoice();
                return true;
                break;
            case 'received':
                $this->invoice = new ReceivedInvoice();
                return true;
                break;
        }
        throw new \Exception('Impossibile creare la fattura');
    }

    protected function fetchData()
    {
        $pa = $this->parametersArray;

        $data = json_decode($pa['data'], true);

        switch($pa['dataType']) {
            case 'priceQuotation':
                $this->fetchPriceQuotation($data);
                return true;
                break;
            case 'serviceOrders':
                $this->fetchServiceOrders($data);
                return true;
                break;
            case 'insurances':
                $this->fetchInsurances($data);
                return true;
                break;
            case 'reviews':
                $this->fetchReviews($data);
                return true;
                break;
        }

        return false;
    }


    protected function fetchPriceQuotation(array $data)
    {
        if(count($data) > 1) throw new \Exception('Puoi fatturare soltanto un preventivo per volta');

        $dataToPass = $this->em->getRepository(PriceQuotation::class)->findOneBy(array('priceQuotationId' => $data[0]));
        if($dataToPass == null) throw new \Exception('Preventivo non trovato');

        $this->data = $dataToPass;
    }

    protected function fetchServiceOrders(array $data)
    {
        $dataToPass = $this->em->getRepository(ServiceOrder::class)->findServiceOrdersInArray($data);
        if($dataToPass == null) throw new \Exception('Ordini di Servizio non trovati');

        $this->data = $dataToPass;
    }

    protected function fetchInsurances(array $data)
    {
        $dataToPass = $this->em->getRepository(Insurance::class)->findInsurancesInArray($data);
        if($dataToPass == null) throw new \Exception('Assicurazioni non trovate');

        $this->data = $dataToPass;
    }

    protected function fetchReviews(array $data)
    {
        $dataToPass = $this->em->getRepository(CarReview::class)->findCarReviewsInArray($data);
        if($dataToPass == null) throw new \Exception('Revisioni non trovate');

        $this->data = $dataToPass;
    }
}