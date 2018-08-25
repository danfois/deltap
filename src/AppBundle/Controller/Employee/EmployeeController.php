<?php

namespace AppBundle\Controller\Employee;
use AppBundle\Entity\Employee\Employee;
use AppBundle\Form\Employee\EmployeeType;
use AppBundle\Helper\Employee\EmployeeHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class EmployeeController extends Controller
{
    /**
     * @Route("create-employee", name="create_employee")
     */
    public function createEmployeeAction()
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);

        $actionUrl = $this->generateUrl('create_employee_ajax');

        return $this->render('employees/employee.html.twig', array(
            'title' => 'Creazione Dipendente',
            'action_url' => $actionUrl,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("create-employee-ajax", name="create_employee_ajax")
     */
    public function createEmployeeAjaxAction(Request $request)
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $employee = $form->getData();

            $EH = new EmployeeHelper($employee, $em, false);
            $EH->execute();
            $errors = $EH->getErrors();

            if($errors == null) {
                $em->persist($employee);
                $em->flush();

                return new Response('Dipendente registrato con successo!', 200);
            }
            return new Response($errors, 500);
        }

        if($form->isSubmitted() && !$form->isValid()) {
            if ($form->isSubmitted() && !$form->isValid()) {
                $errors = $form->getErrors(true);
                $error = '';

                foreach($errors as $k => $e) {
                    $error .= $e->getMessage() . '<br> ';

                }
                return new Response($error, 500);
            }
        }
        return new AccessDeniedException('Non sei autorizzato a vedere questa pagina');
    }
}