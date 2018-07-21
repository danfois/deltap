<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Service;
use AppBundle\Entity\ServiceType;
use AppBundle\Form\CreateServiceType;
use AppBundle\Form\CreateServiceTypeType;
use AppBundle\Util\TableMaker;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{

    //TODO: AGGIUNGERE CRUD

    /**
     * @Route("create-service-type", name="create_service_type")
     */
    public function createServiceTypeAction()
    {
        $serviceType = new ServiceType();
        $form = $this->createForm(CreateServiceTypeType::class, $serviceType);

        $services = $this->getDoctrine()->getRepository('AppBundle:ServiceType')->findAll();

        return $this->render('services/create_service_type.html.twig', array(
            'form' => $form->createView(),
            'services' => $services
        ));
    }

    /**
     * @Route("create-service-type-ajax", name="create_service_type_ajax")
     */
    public function createServiceTypeAjaxAction(Request $request)
    {
        $serviceType = new ServiceType();
        $form = $this->createForm(CreateServiceTypeType::class, $serviceType);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $serviceType = $form->getData();

            $em->persist($serviceType);
            $em->flush();

            return new Response($this->generateUrl('generate_service_type_table'), 200);
        }
        return new Response('Error', 500);
    }

    /**
     * @Route("generate-service-type-table", name="generate_service_type_table")
     */
    public function generateServiceTypeTableAction()
    {
        $services = $this->getDoctrine()->getRepository('AppBundle:ServiceType')->findAll();

        $TableMaker = new TableMaker(TableMaker::DEFAULT_TABLE, $services, array(
            'Id' => 'service_id',
            'Tipo Servizio' => 'service_name'
        ));

        $table = $TableMaker->createTable()->getTable();

        return new Response($table, 200);
    }

    /**
     * @Route("create-service", name="create_service")
     */
    public function createServiceAction()
    {
        $service = new Service();
        $services = $this->getDoctrine()->getRepository('AppBundle:Service')->findAll();
        $form = $this->createForm(CreateServiceType::class, $service);

        return $this->render('services/create_service.html.twig', array(
            'form' => $form->createView(),
            'services' => $services
        ));
    }

    /**
     * @Route("create-service-ajax", name="create_service_ajax")
     */
    public function createServiceAjax(Request $request)
    {
        $service = new Service();
        $form = $this->createForm(CreateServiceType::class, $service);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $service = $form->getData();

            $em->persist($service);
            $em->flush();

            return new Response($this->generateUrl('generate_service_table'), 200);
        }
        return new Response('Error', 500);
    }

    /**
     * @Route("generate-service-table", name="generate_service_table")
     */
    public function generateServicetableAction()
    {
        $services = $this->getDoctrine()->getRepository('AppBundle:Service')->findAll();

        $TableMaker = new TableMaker(TableMaker::DEFAULT_TABLE, $services, array(
            'Id' => 'service_id',
            'Cod. Servizio' => 'service_code',
            'Servizio' => 'service'
        ));

        $table = $TableMaker->createTable()->getTable();

        return new Response($table, 200);
    }
}