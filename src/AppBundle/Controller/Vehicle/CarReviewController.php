<?php

namespace AppBundle\Controller\Vehicle;

use AppBundle\Entity\Vehicle\CarReview;
use AppBundle\Form\Vehicle\CarReviewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CarReviewController extends Controller
{
    /**
     * @Route("create-car-review", name="create_car_review")
     */
    public function createCarReviewAction()
    {
        $cr = new CarReview();
        $form = $this->createForm(CarReviewType::class, $cr);

        return $this->render('vehicles/car_review.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("create-car-review-ajax", name="create_car_review_ajax")
     */
    public function createCarReviewAjax(Request $request)
    {
        return new Response('OK', 200);
    }
}