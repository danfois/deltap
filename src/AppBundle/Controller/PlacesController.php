<?php

namespace AppBundle\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PlacesController extends Controller
{
    /**
     * @Route("json-places", name="json_places")
     */
    public function jsonPlacesAction()
    {
        $places = $this->getDoctrine()->getRepository('AppBundle:Place')->findAll();
        $encoders = array(new JsonEncoder());
        $normalizers = new ObjectNormalizer();
        $normalizers = array($normalizers);
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($places, 'json');
        return $this->render('places/places_json.html.twig', array(
            'dati' => $json
        ));
    }
}