<?php

namespace AppBundle\Controller\Vehicle;
use AppBundle\Entity\Vehicle\Insurance;
use AppBundle\Entity\Vehicle\InsuranceSuspension;
use AppBundle\Entity\Vehicle\InsuranceVehicleAssociation;
use AppBundle\Entity\Vehicle\Vehicle;
use AppBundle\Form\Vehicle\InsuranceAssociationsType;
use AppBundle\Form\Vehicle\InsuranceSuspensionType;
use AppBundle\Form\Vehicle\InsuranceType;
use AppBundle\Helper\Vehicle\InsuranceEditHelper;
use AppBundle\Helper\Vehicle\InsuranceHelper;
use AppBundle\Helper\Vehicle\InsuranceSuspensionHelper;
use AppBundle\Util\TableMaker;
use Symfony\Component\Routing\Annotation\Route;
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

        if($insurance->getEndDate() < new \DateTime()) return new Response('Impossibile impostare come attivo poichè la data di fine validità è precedente a quella odierna', 500);

        $va = $insurance->getVehicleAssociations();

        foreach($va as $v) {
            if($v instanceof InsuranceVehicleAssociation) {
                $v->getVehicle()->setCurrentInsurance($insurance);
            }
        }

        $em->flush();
        return new Response('Assicurazione impostata come attiva!');
    }

    /**
     * @Route("associate-vehicles/{id}", name="associate_vehicle")
     */
    public function associateVehicleAction(Request $request, int $id) {
        if($id == null) return new Response("L'id dell'assicurazione non è stato inviato", 400);

        $em = $this->getDoctrine()->getManager();
        $insurance = $em->getRepository(Insurance::class)->find($id);

        if($insurance == null) return new Response("Impossibile trovare l'assicurazione selezionata", 404);

        $vehicles = $em->getRepository(Vehicle::class)->findAll();
        $associations = $insurance->getVehicleAssociations();

        $associations_array = array();

        foreach($associations as $a) {
            $associations_array[$a->getVehicle()->getPlate()] = ['vehicle' => $a->getVehicle()->getPlate(), 'isAssociated' => true];
        }

        foreach($vehicles as $v) {
            if(!array_key_exists($v->getPlate(), $associations_array)) {
                $associations_array[$v->getPlate()] = ['vehicle' => $v->getPlate(), 'isAssociated' => false];
            }
        }

        sort($associations_array);

        $html = $this->renderView('vehicles/forms/modal_insurance_vehicle_associations.html.twig', array(
            'associations' => $associations_array,
            'action_url' => $this->generateUrl('ajax_associate_vehicles', array('id' => $id))
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Veicoli associati all\'assicurazione',
            'modal_content' => $html
        ));
    }

    /**
     * @Route("ajax/associate-vehicles/{id}", name="ajax_associate_vehicles")
     */
    public function ajaxAssociateVehicles(Request $request, int $id) {
        if($id == null) return new Response("L'id dell'assicurazione non è stato inviato", 400);

        $em = $this->getDoctrine()->getManager();
        $insurance = $em->getRepository(Insurance::class)->find($id);

        if($insurance == null) return new Response("Impossibile trovare l'assicurazione selezionata", 404);

        $associations = $insurance->getVehicleAssociations();
        $newAssociations = $request->request->get('associations');

        foreach($associations as $a) {
            $insurance->removeVehicleAssociation($a);
            $em->remove($a);
        }

        foreach($newAssociations as $na) {
            $v = $em->getRepository(Vehicle::class)->findOneBy(array('plate' => $na));
            if($v != null) {
                $newAssociation = new InsuranceVehicleAssociation();
                $newAssociation
                    ->setVehicle($v)
                    ->setInsurance($insurance);

                $em->persist($newAssociation);
            }
        }

        $em->flush();

        return new Response(implode(', ', $newAssociations));
    }

    /**
     * @Route("suspend-insurance", name="insurance_suspension")
     */
    public function insuranceSuspensionAction(Request $request)
    {
        $id = $request->query->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o assicurazione non presente', 400);

        $insurance = $this->getDoctrine()->getRepository(Insurance::class)->findOneBy(array('insuranceId' => $id));
        if($insurance == null) return new Response('Assicurazione non trovata', 404);

        $is = new InsuranceSuspension();
        $is->setInsurance($insurance);

        $form = $this->createForm(InsuranceSuspensionType::class, $is);

        return $this->render('vehicles/forms/insurance_suspend_form.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("ajax/suspend-insurance", name="suspend_insurance_ajax")
     */
    public function suspendInsuranceAjax(Request $request)
    {
        $is = new InsuranceSuspension();
        $form = $this->createForm(InsuranceSuspensionType::class, $is);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $is = $form->getData();

            $ISH = new InsuranceSuspensionHelper($is, $em, false);
            $ISH->execute();
            $errors = $ISH->getErrors();

            if($errors == null) {

                $insurance = $em->getRepository(Insurance::class)->findOneBy(array('insuranceId' => $is->getInsurance()->getInsuranceId()));

                $dateInterval = $is->getStartDate()->diff($is->getEndDate());
                $newDate = $insurance->getEndDate()->add($dateInterval);
                $insurance->setEndDate(new \DateTime($newDate->format('Y-m-d')));

                $em->persist($is);
                $em->flush();

                return new Response('Assicurazione sospesa con successo!', 200);
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
     * @Route("ajax/delete-suspension", name="delete_suspension")
     */
    public function deleteSuspension(Request $request)
    {
        $id = $request->query->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta', 400);

        $em = $this->getDoctrine()->getManager();
        $suspension = $em->getRepository(InsuranceSuspension::class)->findOneBy(array('suspensionId' => $id));

        if($suspension == null) return new Response('Sospensione assicurazione non trovata', 404);

        $insurance = $em->getRepository(Insurance::class)->findOneBy(array('insuranceId' => $suspension->getInsurance()->getInsuranceId()));

        $dateInterval = $suspension->getStartDate()->diff($suspension->getEndDate());
        $newDate = $insurance->getEndDate()->sub($dateInterval);
        $insurance->setEndDate(new \DateTime($newDate->format('Y-m-d')));

        $em->remove($suspension);
        $em->flush();

        return new Response('Sospensione rimossa con successo!', 200);
    }

    /**
     * @Route("insurance-suspensions-table", name="insurance_suspensions_table")
     */
    public function insuranceSuspensionsTableAction(Request $request)
    {
        $id = $request->query->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o assicurazione non presente', 400);

        $suspensions = $this->getDoctrine()->getRepository(InsuranceSuspension::class)->findBy(array('insurance' => $id));
        if($suspensions == null) return new Response('Nessuna sospensione trovata per questa assicurazione', 404);

        $TableMaker = new TableMaker(TableMaker::DEFAULT_TABLE, $suspensions, array(
            'Id' => 'suspensionId',
            'Data Inizio' => 'startDate',
            'Data Fine' => 'endDate'
        ));

        $table = $TableMaker->createTable()->getTable();

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Lista Sospensioni per Assicurazione N. ' . $id,
            'modal_content' => $table
        ));
    }
}