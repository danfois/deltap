<?php

namespace AppBundle\Controller\Employee;
use AppBundle\Entity\Employee\Employee;
use AppBundle\Form\Employee\EmployeeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    /**
     * @Route("create-employee", name="create_employee")
     */
    public function createEmployeeAction()
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);

        return $this->render('employees/employee.html.twig', array(
            'title' => 'Creazione Dipendente',
            'action_url' => '',
            'form' => $form->createView()
        ));
    }
}