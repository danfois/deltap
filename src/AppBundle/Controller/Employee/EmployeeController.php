<?php

namespace AppBundle\Controller\Employee;

use AppBundle\Entity\Document;
use AppBundle\Entity\Employee\DrivingLicense;
use AppBundle\Entity\Employee\Employee;
use AppBundle\Form\Employee\DrivingLicenseType;
use AppBundle\Form\Employee\EmployeeType;
use AppBundle\Helper\DocumentHelper;
use AppBundle\Helper\Employee\DrivingLicenseHelper;
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

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $employee = $form->getData();

            $EH = new EmployeeHelper($employee, $em, false);
            $EH->execute();
            $errors = $EH->getErrors();

            if ($errors == null) {
                $em->persist($employee);
                $em->flush();

                return new Response('Dipendente registrato con successo!', 200);
            }
            return new Response($errors, 500);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            if ($form->isSubmitted() && !$form->isValid()) {
                $errors = $form->getErrors(true);
                $error = '';

                foreach ($errors as $k => $e) {
                    $error .= $e->getMessage() . '<br> ';

                }
                return new Response($error, 500);
            }
        }
        return new AccessDeniedException('Non sei autorizzato a vedere questa pagina');
    }

    /**
     * @Route("edit-employee-{id}", name="edit_employee")
     */
    public function editEmployeeAction(Request $request, int $id)
    {
        $employee = $this->getDoctrine()->getRepository(Employee::class)->findOneBy(array('employeeId' => $id));
        if ($employee == null) return new Response('Dipendente non trovato', 404);

        $employee->setAdmission($employee->getAdmission()->format('d/m/Y'));
        $employee->setBirthDate($employee->getBirthDate()->format('d/m/Y'));

        $form = $this->createForm(EmployeeType::class, $employee);

        $actionUrl = $this->generateUrl('ajax_edit_employee', array('id' => $id));

        return $this->render('employees/employee.html.twig', array(
            'title' => 'Modifica Dipendente',
            'action_url' => $actionUrl,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("ajax/edit-employee-{id}", name="ajax_edit_employee")
     */
    public function editEmployeeAjaxAction(Request $request, int $id)
    {
        $employee = $this->getDoctrine()->getRepository(Employee::class)->findOneBy(array('employeeId' => $id));
        if ($employee == null) return new Response('Dipendente non trovato', 404);

        $form = $this->createForm(EmployeeType::class, $employee);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $employee = $form->getData();

            $EH = new EmployeeHelper($employee, $em, true);
            $EH->execute();
            $errors = $EH->getErrors();

            if ($errors == null) {

                $em->flush();

                return new Response('Dipendente modificato con successo!', 200);
            }
            return new Response($errors, 500);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            if ($form->isSubmitted() && !$form->isValid()) {
                $errors = $form->getErrors(true);
                $error = '';

                foreach ($errors as $k => $e) {
                    $error .= $e->getMessage() . '<br> ';

                }
                return new Response($error, 500);
            }
        }
        return new AccessDeniedException('Non sei autorizzato a vedere questa pagina');
    }

    /**
     * @Route("employees", name="employees")
     */
    public function employeesAction()
    {
        return $this->render('employees/employees_list.html.twig');
    }

    /**
     * @Route("employee-details", name="employee_details")
     */
    public function employeeDetailsAction(Request $request)
    {
        $id = $request->query->get('id');

        if (is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o dipendente non trovato', 400);

        $employee = $this->getDoctrine()->getRepository(Employee::class)->findOneBy(array('employeeId' => $id));

        if ($employee == null) return new Response('Dipendente non trovato!', 404);

        $html = $this->renderView('employees/employee_details.html.twig', array(
            'e' => $employee
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Dettagli di ' . $employee->getName() . ' ' . $employee->getSurname(),
            'modal_content' => $html
        ));
    }

    /**
     * @Route("driving-licenses", name="driving_license")
     */
    public function drivingLicensesAction()
    {
        $dl = new DrivingLicense();
        $form = $this->createForm(DrivingLicenseType::class, $dl);

        $actionUrl = $this->generateUrl('create-driving-license-ajax');

        return $this->render('employees/driving_licenses.html.twig', array(
            'form' => $form->createView(),
            'documentType' => 'Patente',
            'action_url' => $actionUrl
        ));
    }

    /**
     * @Route("create-driving-license-ajax", name="create-driving-license-ajax")
     */
    public function createDrivingLicenseAjax(Request $request)
    {
        $dl = new DrivingLicense();
        $form = $this->createForm(DrivingLicenseType::class, $dl);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dl = $form->getData();
            $files = $form->get('files')->getData();

            $em = $this->getDoctrine()->getManager();

            $DLH = new DrivingLicenseHelper($dl, $em, false);
            $DLH->execute();
            $errors = $DLH->getErrors();

            $DH = new DocumentHelper($files, $em, $dl->getEmployee());
            $DH->execute();
            $errors .= $DH->getErrors();

            if ($errors == null) {
                $documents = $DH->getDocumentArray();

                foreach ($documents as $d) {
                    if ($d instanceof Document) {
                        $d->setDrivingLicense($dl);
                        $d->upload();
                        $em->persist($d);
                        }
                }

                $em->persist($dl);
                $em->flush();

                return new Response('Patente Creata con successo!', 200);
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
        throw new AccessDeniedException('Non sei autorizzato a vedere questa pagina');
    }

}