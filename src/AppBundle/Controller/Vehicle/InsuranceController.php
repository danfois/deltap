<?php

namespace AppBundle\Controller\Vehicle;
use AppBundle\Entity\Vehicle\Insurance;
use AppBundle\Entity\Vehicle\InsuranceSuspension;
use AppBundle\Form\Vehicle\InsuranceSuspensionType;
use AppBundle\Form\Vehicle\InsuranceType;
use AppBundle\Helper\Vehicle\InsuranceEditHelper;
use AppBundle\Helper\Vehicle\InsuranceHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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

    /**
     * @Route("set-active-insurance", name="set_active_insurance")
     */
    public function setActiveInsuranceAction(Request $request)
    {
        $idA = $request->query->get('id');
        if(is_numeric($idA) === false) return new Response('Richiesta effettuata in maniera non corretta', 400);

        $em = $this->getDoctrine()->getManager();
        $insurance = $em->getRepository(Insurance::class)->findOneBy(array('insuranceId' => $idA));

        $v = $insurance->getVehicle();
        $is = $em->getRepository(Insurance::class)->findActiveInsurancesPerVehicle($v->getVehicleId());

        if($insurance->getEndDate() < new \DateTime()) return new Response('Impossibile impostare come attivo poichè la data di fine validità è precedente a quella odierna', 500);

        foreach($is as $i) {
            $i->setIsActive(0);
        }

        $insurance->setIsActive(1);
        $v->setCurrentInsurance($insurance);

        $em->flush();
        return new Response('Assicurazione impostata come attiva!');
    }

    /**
     * @Route("insurance-suspension", name="insurance_suspension")
     */
    public function insuranceSuspensionAction()
    {
        $is = new InsuranceSuspension();
        $form = $this->createForm(InsuranceSuspensionType::class, $is);

        return $this->render('DEBUG/show_form.html.twig', array(
            'form' => $form->createView()
        ));
    }
}