<?php

namespace AppBundle\Controller;
use AppBundle\Entity\ServiceType;
use AppBundle\Form\CreateServiceTypeType;
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

        $table = '';
        $table_start = '<table class="table m-table m-table--head-separator-primary">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tipo Servizio</th>
                                </tr>
                                </thead>
                                <tbody>';
        $table_body = '';
        foreach($services as $s) {
            $table_body .= "<tr>
                               <th scope='row'>{$s->getServiceId()}</th>
                               <td>{$s->getServiceName()}</td>
                           </tr>";
        }
        $table_end = "</tbody>
                       </table>";
        $table .= $table_start;
        $table .= $table_body;
        $table .= $table_end;

        return new Response($table, 200);
    }
}