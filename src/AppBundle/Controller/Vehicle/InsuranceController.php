<?php

namespace AppBundle\Controller\Vehicle;
use AppBundle\Entity\Vehicle\Insurance;
use AppBundle\Form\Vehicle\InsuranceType;
use AppBundle\Helper\Vehicle\InsuranceEditHelper;
use AppBundle\Helper\Vehicle\InsuranceHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class InsuranceController extends Controller
{
    /**
     * @Route("create-insurance", name="create_insurance")
     */
    public function createInsuranceAction()
    {
        $insurance = new Insurance();

        $form = $this->createForm(InsuranceType::class, $insurance);

        return $this->render('vehicles/insurances.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("create-insurance-ajax", name="create_insurance_ajax")
     */
    public function createInsuranceAjax(Request $request)
    {
        $insurance = new Insurance();
        $form = $this->createForm(InsuranceType::class, $insurance);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $insurance = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $IH = new InsuranceHelper($insurance, $em);
            $IH->execute();
            $errors = $IH->getErrors();

            if ($errors == null) {

                $em->persist($insurance);
                $em->flush();

                return new Response('OK', 200);
            } else {
                return new Response($errors, 500);
            }
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
     * @Route("edit-insurance-{idInsurance}", name="edit_insurance")
     */
    public function editInsuranceAction(Request $request, int $idInsurance)
    {
        $insurance = $this->getDoctrine()->getRepository(Insurance::class)->findOneBy(array('insuranceId' => $idInsurance));

        if($insurance == null) return new Response('Questa assicurazione non esiste', 404);

        $insurance->setStartDate($insurance->getStartDate()->format('d/m/Y'));
        $insurance->setEndDate($insurance->getEndDate()->format('d/m/Y'));

        $form = $this->createForm(InsuranceType::class, $insurance);

        return $this->render('vehicles/forms/insurance_edit_form.html.twig', array(
            'form' => $form->createView(),
            'idInsurance' => $insurance->getInsuranceId()
        ));
    }

    /**
     * @Route("ajax/edit-insurance-{idInsurance}", name="edit_insurance_ajax")
     */
    public function editInsuranceAjaxAction(Request $request, int $idInsurance)
    {
        $em = $this->getDoctrine()->getManager();
        $insurance = $em->getRepository(Insurance::class)->findOneBy(array('insuranceId' => $idInsurance));
        if($insurance == null) return new Response('Questa assicurazione non esiste', 404);

        $form = $this->createForm(InsuranceType::class, $insurance);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $insurance = $form->getData();

            $IH = new InsuranceEditHelper($insurance, $em);
            $IH->execute();

            $errors = $IH->getErrors();

            if($errors == null) {
                $em->flush();
                return new Response('OK', 200);
            } else {
                return new Response($errors, 500);
            }
        }

        if($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Non sei autorizzato ad entrare in questa pagina');
    }

    /**
     * @Route("ajax/delete-insurance-{idInsurance}", name="delete_insurance_ajax")
     */
    public function deleteInsuranceAjaxAction(Request $request, int $idInsurance)
    {
        $em = $this->getDoctrine()->getManager();
        $insurance = $em->getRepository(Insurance::class)->findOneBy(array('insuranceId' => $idInsurance));
        if($insurance == null) return new Response('Questa assicurazione non esiste', 404);

        $em->remove($insurance);
        $em->flush();

        return new Response('OK', 200);
    }
}