<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    /**
     * @Route("test-google-api", name="test_google_api")
     */
    public function testGoogleApiAction()
    {
        $response = file_get_contents('https://maps.googleapis.com/maps/api/directions/json?origin=Sennori&destination=Sassari&key=AIzaSyBzvS_c1V5lQH9KZWO8A5QihgEAcYQfC1A');

        return new Response($response, 200);
    }

}