<?php

namespace AppBundle\Util;

/**
 * Class DistanceMatrixAPI
 * @package AppBundle\Util
 *
 * It is particularly important to NOT set a departure time
 * otherwise Google is going to bill highly
 */
class DistanceMatrixAPI
{
    private $key = 'AIzaSyBzvS_c1V5lQH9KZWO8A5QihgEAcYQfC1A';
    private $baseUrl = 'maps.googleapis.com/maps/api/distancematrix/';
    private $startPoint;
    private $endPoint;
    private $outputFormat;
    private $protocol;
    private $fullUrl;
    private $rawResponse;

    public function __construct(string $startPoint, string $endPoint, string $outputFormat, bool $https)
    {
        $this->setStartPoint($startPoint);
        $this->setEndPoint($endPoint);
        $this->setOutputFormat($outputFormat);
        $this->setProtocol($https);
    }

    private function setOutputFormat($format)
    {
        if($format !== 'json' && $format !== 'xml') throw new \Exception('Output format not supported. Must be either json or xml');
        $this->outputFormat = $format;
    }

    private function setProtocol(bool $protocol)
    {
        ($protocol ? $this->protocol = 'https://' : $this->protocol = 'http://');
    }

    private function setStartPoint($sp)
    {
        if($sp == null) throw new \Exception('Start Point cannot be null');
        $this->startPoint = $sp;
    }

    private function setEndPoint($ep)
    {
        if($ep == null) throw new \Exception('End Point cannot be null');
        $this->endPoint = $ep;
    }

    public function generateRequestUrl()
    {
        $this->fullUrl = $this->protocol . $this->baseUrl . $this->outputFormat . '?origins=' . urlencode($this->startPoint) . '&destinations=' . urlencode($this->endPoint) . '&key=' . $this->key;
        return $this->fullUrl;
    }

    protected function sendRequest()
    {
        $this->rawResponse = file_get_contents($this->fullUrl);
    }

    public function getResult()
    {
        $this->sendRequest();
        $responseClass = new DistanceMatrixAPIResponse($this->rawResponse);
        $response = $responseClass->getFormattedResponse();

        //if $response is an array it is ok, otherwise there has been an error

        return $response;
    }


}