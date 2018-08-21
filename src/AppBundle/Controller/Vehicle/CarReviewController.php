<?php

namespace AppBundle\Controller\Vehicle;

use AppBundle\Entity\Vehicle\CarReview;
use AppBundle\Form\Vehicle\CarReviewType;
use AppBundle\Helper\Vehicle\CarReviewHelper;
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
        $cr = new CarReview();
        $form = $this->createForm(CarReviewType::class, $cr);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $cr = $form->getData();

            $CRH = new CarReviewHelper($cr, $em, false);
            $CRH->execute();
            $errors = $CRH->getErrors();

            if ($errors == null) {

                $em->persist($cr);
                $em->flush();

                return new Response('OK', 200);
            } else {
                return new Response($errors, 500);
            }
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach ($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Accesso Negato');
    }

    /**
     * @Route("edit-carreview-{idCr}", name="edit_carreview")
     */
    public function editCarTaxAction(Request $request, int $idCr)
    {
        $cr = $this->getDoctrine()->getRepository(CarReview::class)->findOneBy(array('carReviewId' => $idCr));
        if ($cr == null) return new Response('Revisione non trovata', 404);

        $cr->setStartDate($cr->getStartDate()->format('d/m/Y'));
        $cr->setEndDate($cr->getEndDate()->format('d/m/Y'));

        $form = $this->createForm(CarReviewType::class, $cr);

        return $this->render('vehicles/forms/car_review_edit_form.html.twig', array(
            'form' => $form->createView(),
            'idCarReview' => $cr->getCarReviewId()
        ));
    }

    /**
     * @Route("ajax/edit-carreview-{idCarreview}", name="edit_carreview_ajax")
     */
    public function editCarReviewAjax(Request $request, int $idCarreview)
    {
        $em = $this->getDoctrine()->getManager();
        $cr = $em->getRepository(CarReview::class)->findOneBy(array('carReviewId' => $idCarreview));
        if ($cr == null) return new Response('Questa revisione non esiste', 404);

        $form = $this->createForm(CarReviewType::class, $cr);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carTax = $form->getData();

            $IH = new CarReviewHelper($carTax, $em, true);
            $IH->execute();

            $errors = $IH->getErrors();

            if ($errors == null) {
                $em->flush();
                return new Response('OK', 200);
            } else {
                return new Response($errors, 500);
            }
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach ($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Non sei autorizzato ad entrare in questa pagina');
    }

    /**
     * @Route("ajax/delete-carreview-{idCr}", name="delete_carreview")
     */
    public function deleteCarReviewAction(Request $request, int $idCr)
    {
        $em = $this->getDoctrine()->getManager();
        $cr = $em->getRepository(CarReview::class)->findOneBy(array('carReviewId' => $idCr));
        if ($cr == null) return new Response('Revisione non trovata', 404);

        $em->remove($cr);
        $em->flush();

        return new Response('OK', 200);
    }

    /**
     * @Route("set-active-car-review", name="set-active-car-review")
     */
    public function setActiveCarReview(Request $request)
    {
        $idC = $request->query->get('id');
        if(is_numeric($idC) === false) return new Response('Richiesta effettuata in maniera non corretta', 400);

        $em = $this->getDoctrine()->getManager();
        $cr = $em->getRepository(CarReview::class)->findOneBy(array('carReviewId' => $idC));

        $v = $cr->getVehicle();

        if($cr->getEndDate() < new \DateTime()) return new Response('Impossibile impostare come attivo poichè la data di fine validità è precedente a quella odierna', 500);

        $cs = $em->getRepository(CarReview::class)->findActiveCarReviewPerVehicle($idC);

        foreach($cs as $c) {
            $c->setIsActive(0);
        }

        $cr->setIsActive(1);
        $v->setCurrentCarReview($cr);

        $em->flush();

    return new Response('Revisione impostata come attiva!', 200);
    }
}