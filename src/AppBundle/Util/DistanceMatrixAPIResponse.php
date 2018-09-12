<?php

namespace AppBundle\Util;

/**
 * Class DistanceMatrixAPIResponse
 * @package AppBundle\Util
 * La Risposta deve essere un semplice json che contiene somma km e somma tempo
 */
class DistanceMatrixAPIResponse
{
    protected $response;
    protected $apiArray;
    protected $apiJson;

    public function __construct($apiJson)
    {
        $this->apiJson = $apiJson;
    }

    protected function jsonToArray()
    {
        $this->apiArray = json_decode($this->apiJson, true);
    }

    protected function isResponseOk()
    {
        $status = $this->apiArray['status'];
        if($status == 'OK') return true;

        switch($status) {
            case 'INVALID_REQUEST':
                return 'Richiesta non valida<br>';
                break;
            case 'MAX_ELEMENTS_EXCEEDED':
                return 'Troppe partenze e/o destinazioni<br>';
                break;
            case 'OVER_DAILY_LIMIT':
                return 'Richieste giornaliere esaurite<br>';
                break;
            case 'REQUEST_DENIED':
                return 'Richiesta negata. Contattare lo sviluppatore<br>';
                break;
            case 'UNKNOWN_ERROR':
                return 'Errore del server di Google. Riprovare più tardi<br>';
                break;
        }

        return false;
    }

    protected function processData()
    {
        $this->jsonToArray();
        if($this->apiArray == null) throw new \Exception('Error in DistanceMatrixAPIResponse::processData()');

        //DEBUG: print_r($this->apiArray);

        $isResponseOk = $this->isResponseOk();

        if($isResponseOk !== true) {
            $this->response = $isResponseOk;
            return $this->response;
        }

        $rows = $this->apiArray['rows'];
        $kms = [];
        $time = [];

        foreach($rows as $r) {
            foreach($r['elements'] as $e) {
                if($e['status'] != 'OK') {
                    $this->response = $e['status'];
                    return false;
                }
                $kms[] = $e['distance']['value'];
                $time[] = $e['duration']['value'];
            }
        }

        $totalKm = array_sum($kms);
        $totalTime = array_sum($time);

        $response = array(
            'km' => $totalKm,
            'time' => $totalTime
        );

        $this->response = $response;
        return true;
    }

    public function getFormattedResponse()
    {
        $this->processData();

        //if the response is an array it's ok, otherwise there is an error
        return $this->response;
    }



}