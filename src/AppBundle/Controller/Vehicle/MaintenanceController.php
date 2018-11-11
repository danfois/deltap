<?php

namespace AppBundle\Controller\Vehicle;
use AppBundle\Entity\Vehicle\Maintenance;
use AppBundle\Entity\Vehicle\MaintenanceDetail;
use AppBundle\Entity\Vehicle\MaintenanceType;
use AppBundle\Form\Vehicle\MaintenanceTypeType;
use AppBundle\Form\Vehicle\VehicleMaintenanceType;
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
    public function ajaxEditMaintenanceAction(Request $request, int $n)
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

        return $this->render('DEBUG/show_form.html.twig', array(
            'form' => $form->createView()
        ));
    }
}