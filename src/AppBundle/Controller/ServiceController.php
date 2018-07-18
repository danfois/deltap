<?php

namespace AppBundle\Controller;
use AppBundle\Entity\ServiceType;
use AppBundle\Form\CreateServiceTypeType;
use AppBundle\Util\TableMaker;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    /**
     * @Route("create-service", name="create_service")
     */
    public function createServiceAction()
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
     * @Route("create-service-ajax", name="create_service_ajax")
     */
    public function createServiceAjaxAction(Request $request)
    {
        $serviceType = new ServiceType();
        $form = $this->createForm(CreateServiceTypeType::class, $serviceType);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $serviceType = $form->getData();

            $em->persist($serviceType);
            $em->flush();

            return new Response($this->generateUrl('generate_service_table'), 200);
        }
        return new Response('Error', 500);
    }

    /**
     * @Route("generate-service-table", name="generate_service_table")
     */
    public function generateServiceTableAction()
    {
        $services = $this->getDoctrine()->getRepository('AppBundle:ServiceType')->findAll();

        $TableMaker = new TableMaker(TableMaker::DEFAULT_TABLE, $services, array(
            'Id' => 'service_id',
            'Tipo Servizio' => 'service_name'
        ));

        $table = $TableMaker->createTable()->getTable();

        return new Response($table, 200);
    }
}