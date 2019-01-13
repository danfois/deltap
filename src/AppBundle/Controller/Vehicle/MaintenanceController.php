<?php

namespace AppBundle\Controller\Vehicle;
use AppBundle\Entity\Vehicle\Maintenance;
use AppBundle\Entity\Vehicle\MaintenanceDetail;
use AppBundle\Entity\Vehicle\MaintenanceRelationship;
use AppBundle\Entity\Vehicle\MaintenanceType;
use AppBundle\Entity\Vehicle\Vehicle;
use AppBundle\Form\Vehicle\MaintenanceTypeType;
use AppBundle\Form\Vehicle\SetupMaintenanceType;
use AppBundle\Form\Vehicle\VehicleMaintenanceType;
use AppBundle\Helper\Vehicle\ExpiringMaintenanceProvider;
use AppBundle\Helper\Vehicle\MaintenanceHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceController extends Controller
{
    /**
     * @Route("maintenance-types", name="maintenance_types")
     */
    public function maintenanceTypesAction()
    {
        $maintenance = new MaintenanceType();
        $form = $this->createForm(MaintenanceTypeType::class, $maintenance);

        return $this->render('vehicles/maintenance_type_list.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Tipi Manutenzione',
            'new_button_path' => $this->generateUrl('create_maintenance'),
            'new_button_name' => 'Nuova Scheda Manutenzione',
            'action_url' => $this->generateUrl('ajax_create_maintenance_type'),
            'edit' => ''
        ));
    }

    /**
     * @Route("ajax/maintenance-type-creation", name="ajax_create_maintenance_type")
     */
    public function createMaintenanceTypeAjax(Request $request)
    {
        $maintenance = new MaintenanceType();
        $form = $this->createForm(MaintenanceTypeType::class, $maintenance);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $maintenance = $form->getData();

            if($maintenance->getDateInterval() == null && $maintenance->getKmInterval() == null) return new Response('Devi scegliere almeno un intervallo', 400);

            $em->persist($maintenance);
            $em->flush();
            return new Response('Tipo Manutenzione creato con successo', 200);
        }

        if($form->isSubmitted() && !$form->isValid()) {
            return new Response('Il form non è stato compilato correttamente', 500);
        }

        return new Response('Non sei autorizzato a fare questa operazione', 403);
    }

    /**
     * @Route("delete-maintenance-type", name="delete_maintenance_type")
     */
    public function deleteMaintenanceType(Request $request)
    {
        $id = $request->query->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta',400);

        $em = $this->getDoctrine()->getManager();

        $maintenance = $em->getRepository(MaintenanceType::class)->find($id);
        if($maintenance == null) return new Response('Tipo Manutenzione non trovato', 404);

        $em->remove($maintenance);
        $em->flush();

        return new Response('Tipo manutenzione eliminato', 200);
    }

    /**
     * @Route("edit/maintenance-type-{n}", name="edit_maintenance_type")
     */
    public function editMaintenanceTypeAction(int $n)
    {
        $m = $this->getDoctrine()->getRepository(MaintenanceType::class)->find($n);
        if($m == null) return new Response('Tipo manutenzione non trovato', 404);

        $form = $this->createForm(MaintenanceTypeType::class, $m);

        $html = $this->renderView('vehicles/forms/maintenance_type_form.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $this->generateUrl('ajax_edit_maintenance', array('n' => $n)),
            'edit' => '_edit'
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Modifica Tipo Manutenzione',
            'modal_content' => $html
        ));
    }

    /**
     * @Route("ajax/edit-maintenance-type-{n}", name="ajax_edit_maintenance")
     */
    public function ajaxEditMaintenanceTypeAction(Request $request, int $n)
    {
        $m = $this->getDoctrine()->getRepository(MaintenanceType::class)->find($n);
        if($m == null) return new Response('Tipo manutenzione non trovato', 404);

        $form = $this->createForm(MaintenanceTypeType::class, $m);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $maintenance = $form->getData();

            if($maintenance->getDateInterval() == null && $maintenance->getKmInterval() == null) return new Response('Devi scegliere almeno un intervallo', 400);

            $em->flush();
            return new Response('Tipo Manutenzione modificato con successo', 200);
        }

        if($form->isSubmitted() && !$form->isValid()) {
            return new Response('Il form non è stato compilato correttamente', 500);
        }

        return new Response('Non sei autorizzato a fare questa operazione', 403);
    }

    /**
     * @Route("create-maintenance", name="create_maintenance")
     */
    public function createMaintenanceAction()
    {
        $m = new Maintenance();
        $md = new MaintenanceDetail();
        $m->addMaintenanceDetail($md);

        $form = $this->createForm(VehicleMaintenanceType::class, $m);

        return $this->render('vehicles/maintenance.html.twig', array(
            'title' => 'Scheda Manutenzione',
            'action_url' => $this->generateUrl('ajax_create_maintenance'),
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("ajax/create-maintenance", name="ajax_create_maintenance")
     */
    public function ajaxCreateMaintenance(Request $request)
    {
        $m = new Maintenance();
        $form = $this->createForm(VehicleMaintenanceType::class, $m);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $m = $form->getData();

            $MH = new MaintenanceHelper($m, $em, false);
            $MH->execute();
            $errors = $MH->getErrors();

            if($errors == null) {
                $em->persist($m);
                $em->flush();

                return new Response('Scheda Manutenzione creata con successo!', 200);
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

        return new Response('Accesso Negato', 403);
    }

    /**
     * @Route("edit-maintenance-{n}", name="edit_maintenance")
     */
    public function editMaintenanceAction(int $n)
    {
        $m = $this->getDoctrine()->getRepository(Maintenance::class)->find($n);
        if($m == null) return new Response('Manutenzione non trovata', 404);

        $form = $this->createForm(VehicleMaintenanceType::class, $m);

        return $this->render('vehicles/maintenance.html.twig', array(
            'title' => 'Modifica Scheda Manutenzione',
            'action_url' => $this->generateUrl('ajax_edit_maintenance', array('n' => $n)),
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("ajax/edit-maintenance-{n}", name="ajax_edit_maintenance")
     */
    public function ajaxEditMaintenanceAction(Request $request, int $n)
    {
        $m = $this->getDoctrine()->getRepository(Maintenance::class)->find($n);
        if($m == null) return new Response('Manutenzione non trovata', 404);

        $form = $this->createForm(VehicleMaintenanceType::class, $m);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $m = $form->getData();

            $MH = new MaintenanceHelper($m, $em, true);
            $MH->execute();
            $errors = $MH->getErrors();

            if($errors == null) {
                $em->flush();

                return new Response('Scheda Manutenzione modificata con successo!', 200);
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

        return new Response('Accesso Negato', 403);
    }

    /**
     * @Route("delete-maintenance-{n}", name="delete_maintenance")
     */
    public function deleteMaintenanceAction(int $n)
    {
        $m = $this->getDoctrine()->getRepository(Maintenance::class)->find($n);
        if($m == null) return new Response('Manutenzione non trovata', 404);

        $em = $this->getDoctrine()->getManager();
        $em->remove($m);
        $em->flush();

        return new Response('Manutenzione Rimossa con successo', 200);
    }

    /**
     * @Route("maintenance-list", name="maintenance_list")
     */
    public function maintenanceListAction()
    {
        return $this->render('vehicles/maintenance_list.html.twig', array(
            'title' => 'Manutenzioni',
            'new_button_path' => $this->generateUrl('create_maintenance'),
            'new_button_name' => 'Nuova Scheda Manutenzione'
        ));
    }

    /**
     * @Route("setup-maintenances-{n}", name="setup_maintenances")
     */
    public function setupMaintenancesAction(int $n)
    {
        $vehicle = $this->getDoctrine()->getRepository(Vehicle::class)->find($n);
        if($vehicle == null) return new Response('Veicolo non trovato', 404);

        if(count($vehicle->getMaintenanceRelationships()) === 0) $vehicle->addMaintenanceRelationship(new MaintenanceRelationship());

        $form = $this->createForm(SetupMaintenanceType::class, $vehicle);

        $html = $this->renderView('vehicles/maintenance_setup.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $this->generateUrl('ajax_setup_maintenance', array('n' => $n))
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Imposta manutenzioni per ' . $vehicle->getPlate(),
            'modal_content' => $html
        ));
    }

    /**
     * @Route("ajax-setup-maintenance-{n}", name="ajax_setup_maintenance")
     */
    public function ajaxSetupMaintenance(Request $request, int $n)
    {
        $vehicle = $this->getDoctrine()->getRepository(Vehicle::class)->find($n);
        if($vehicle == null) return new Response('Veicolo non trovato', 404);

        $form = $this->createForm(SetupMaintenanceType::class, $vehicle);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $vehicle = $form->getData();

            foreach($vehicle->getMaintenanceRelationships() as $m) {
//                $em->persist($m);
                $m->setVehicle($vehicle);
            }

            $em->flush();

            return new Response('Impostazioni Salvate', 200);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        return new Response('Accesso Negato', 403);
    }

    /**
     * @Route("expiring-maintenances-{n}", name="expiring_maintenances")
     */
    public function expiringMaintenancesAction(int $n = null)
    {
        $em = $this->getDoctrine()->getManager();

        $emp = new ExpiringMaintenanceProvider($em);

        if($n !== null) {

            $vehicle = $this->getDoctrine()->getRepository(Vehicle::class)->find($n);
            if ($vehicle == null) return new Response('Veicolo non trovato', 404);

            $data = $emp->setVehicle($vehicle)->prepareData()->getPreparedData();

        } else {

            $data = $emp->prepareData()->getPreparedData();

        }

        return $this->render('vehicles/expiring_maintenances.html.twig', array(
            'data' => $data
        ));

//        return $this->render('DEBUG/form_data.html.twig', array(
//            'data' => $data,
//            'title' => 'bleru'
//        ));
    }
}