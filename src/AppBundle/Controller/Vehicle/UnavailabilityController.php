<?php

namespace AppBundle\Controller\Vehicle;
use AppBundle\Entity\Vehicle\Unavailability;
use AppBundle\Form\Vehicle\UnavailabilityType;
use AppBundle\Helper\Vehicle\UnavailabilityHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class UnavailabilityController extends Controller
{
    /**
     * @Route("create-unavailability", name="create_unavailability")
     */
    public function createUnavailabilityAction()
    {
        $u = new Unavailability();
        $form = $this->createForm(UnavailabilityType::class, $u);

        return $this->render('vehicles/unavailabilities.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("create-unavailability-ajax", name="create_unavailability_ajax")
     */
    public function createUnavailabilityAjax(Request $request)
    {
        $u = new Unavailability();
        $form = $this->createForm(UnavailabilityType::class, $u);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $u = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $UH = new UnavailabilityHelper($u, $em, false);
            $UH->execute();
            $errors = $UH->getErrors();

            if($errors == null) {
                $em->persist($u);
                $em->flush();

                return new Response('OK', 200);
            }

            return new Response($errors, 500);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Accesso Negato');
    }

    /**
     * @Route("edit-unavailability-{idU}", name="edit_unavailability")
     */
    public function editUnavailabilityAction(Request $request, int $idU)
    {
        $u = $this->getDoctrine()->getRepository(Unavailability::class)->findOneBy(array('unavailabilityId' => $idU));
        if($u == null) return new Response('Indisponibilità non trovata', 404);

        $u->setStartDate($u->getStartDate()->format('d/m/Y'));
        $u->setEndDate($u->getEndDate()->format('d/m/Y'));

        $form = $this->createForm(UnavailabilityType::class, $u);

        return $this->render('vehicles/forms/unavailability_edit_form.html.twig', array(
            'form' => $form->createView(),
            'idU' => $u->getUnavailabilityId()
        ));
    }

    /**
     * @Route("ajax/edit-unavailability-{idU}", name="edit_unavailability_ajax")
     */
    public function editUnavailabilityAjaxAction(Request $request, int $idU)
    {
        $u = $this->getDoctrine()->getRepository(Unavailability::class)->findOneBy(array('unavailabilityId' => $idU));
        if($u == null) return new Response('Indisponibilità non trovata', 404);

        $form = $this->createForm(UnavailabilityType::class, $u);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $u = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $UH = new UnavailabilityHelper($u, $em, true);
            $UH->execute();
            $errors = $UH->getErrors();

            if($errors == null) {
                $em->flush();

                return new Response('OK', 200);
            }
            return new Response($errors, 500);
        }
        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Accesso Negato');
    }

    /**
     * @Route("ajax/delete-unavailability-{idU}", name="delete_unavailability_ajax")
     */
    public function deleteUnavailabilityAjax(Request $request, int $idU)
    {
        $em = $this->getDoctrine()->getManager();
        $u = $em->getRepository(Unavailability::class)->findOneBy(array('unavailabilityId' => $idU));
        if($u == null) return new Response('Indisponibilità non trovata', 500);

        $em->remove($u);
        $em->flush();

        return new Response('OK', 200);
    }

    /**
     * @Route("ajax/batch-delete-unavailabilities", name="ajax_batch_delete_unavailabilities")
     */
    public function ajaxDeleteBatchUnavailabilities(Request $request)
    {
        $uArray = json_decode($request->request->get('ids'));
        $em = $this->getDoctrine()->getManager();

        foreach($uArray as $uId) {
            $u = $em->getRepository(Unavailability::class)->findOneBy(array('unavailabilityId' => $uId));
            if($u != null) $em->remove($u);
        }

        $em->flush();

        return new Response('ok', 200);
    }
}