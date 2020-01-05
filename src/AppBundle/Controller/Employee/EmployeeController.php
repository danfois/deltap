<?php

namespace AppBundle\Controller\Employee;

use AppBundle\Entity\Employee\Course;
use AppBundle\Entity\Employee\CourseAttendance;
use AppBundle\Entity\Employee\Employee;
use AppBundle\Entity\Employee\EmployeeUnavailability;
use AppBundle\Form\Employee\CourseType;
use AppBundle\Form\Employee\EmployeeAttendancesType;
use AppBundle\Form\Employee\EmployeeType;
use AppBundle\Form\Employee\EmployeeUnavailabilityType;
use AppBundle\Form\Employee\TerminateEmployeeType;
use AppBundle\Helper\Employee\EmployeeHelper;
use AppBundle\Helper\Employee\UnavailabilityHelper;
use AppBundle\Service\EmployeeTurn\EmployeeTurnManager;
use Symfony\Component\Routing\Annotation\Route;
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
    public function createEmployeeAjaxAction(Request $request, EmployeeTurnManager $etm)
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
                $etm->generateYearlyTurnsForEmployee($employee);
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
     * @Route("ajax/terminate-employee", name="terminate_employee_ajax")
     */
    public function terminateEmployeeAction(Request $request)
    {
        $id = $request->query->get('id');
        if (is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o dipendente non trovato', 400);

        $employee = $this->getDoctrine()->getRepository(Employee::class)->findOneBy(array('employeeId' => $id));

        if ($employee == null) return new Response('Dipendente non trovato!', 404);

        $form = $this->createForm(TerminateEmployeeType::class, $employee);

        $actionUrl = $this->generateUrl('terminate_employee_ajax_id', array('id' => $employee->getEmployeeId()));

        $html = $this->renderView('employees/forms/terminate_form.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $actionUrl
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Cessazione Rapporto di Lavoro per ' . $employee->getName() . ' ' . $employee->getSurname(),
            'modal_content' => $html
        ));
    }

    /**
     * @Route("ajax/terminate-employee/{id}", name="terminate_employee_ajax_id")
     */
    public function terminateEmployeeAjaxId(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $employee = $em->getRepository(Employee::class)->findOneBy(array('employeeId' => $id));

        if($employee == null) return new Response('Nessun dipendente trovato', 404);

        $form = $this->createForm(TerminateEmployeeType::class, $employee);

        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()) {
            $employee = $form->getData();

            if($employee->getTerminationDate() != null) {
                $employee->setisFired(1);
            } else {
                $employee->setisFired(0);
            }

            $em->flush();

            return new Response('Cessazione rapporto registrata', 200);
        }
        return new Response('Errore durante la registrazione della cessazione del rapporto', 500);
    }

    /**
     * @Route("create-employee-unavailability", name="create_employee_unavailability")
     */
    public function createEmployeeUnavailability()
    {
        $eu = new EmployeeUnavailability();
        $form = $this->createForm(EmployeeUnavailabilityType::class, $eu);

        return $this->render('employees/unavailabilities.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("ajax/create-employee-unavailability", name="ajax_create_employee_unavailability")
     */
    public function ajaxCreateEmployeeUnavailability(Request $request)
    {
        $eu = new EmployeeUnavailability();
        $form = $this->createForm(EmployeeUnavailabilityType::class, $eu);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $eu = $form->getData();

            $EH = new UnavailabilityHelper($eu, $em, false);
            $EH->execute();
            $errors = $EH->getErrors();

            if($errors == null) {
                $em->persist($eu);
                $em->flush();

                return new Response('Indisponibilità creata con successo!', 200);
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
     * @Route("edit-employeeUnavailability-{n}", name="edit_employee_unavailability")
     */
    public function editEmployeeUnavailabilityAction(int $n)
    {
        $eu = $this->getDoctrine()->getRepository(EmployeeUnavailability::class)->find($n);
        if($eu == null) return new Response('Indisponibilità non trovata', 404);

        $form = $this->createForm(EmployeeUnavailabilityType::class, $eu);

        $html = $this->renderView('employees/forms/unavailability_edit_form.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $this->generateUrl('ajax_edit_employee_unavailability', array('n' => $n))
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Modifica Indisponibilità',
            'modal_content' => $html
        ));
    }

    /**
     * @Route("ajax/edit-employeeUnavailability-{n}", name="ajax_edit_employee_unavailability")
     */
    public function ajaxEditEmployeeUnavailability(Request $request, int $n)
    {
        $eu = $this->getDoctrine()->getRepository(EmployeeUnavailability::class)->find($n);
        if($eu == null) return new Response('Indisponibilità non trovata', 404);

        $form = $this->createForm(EmployeeUnavailabilityType::class, $eu);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $eu = $form->getData();

            $EH = new UnavailabilityHelper($eu, $em, true);
            $EH->execute();
            $errors = $EH->getErrors();

            if($errors == null) {
                $em->flush();

                return new Response('Indisponibilità modificata con successo!', 200);
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
     * @Route("delete-employeeUnavailability-{n}", name="delete_employee_unavailability")
     */
    public function deleteEmployeeUnavailabilityAction(int $n)
    {
        $eu = $this->getDoctrine()->getRepository(EmployeeUnavailability::class)->find($n);
        if($eu == null) return new Response('Indisponibilità non trovata', 404);

        $em = $this->getDoctrine()->getManager();
        $em->remove($eu);
        $em->flush();

        return new Response('Indisponibilità rimossa con successo', 200);
    }

    /**
     * @Route("courses", name="courses")
     */
    public function coursesAction()
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);

        return $this->render('employees/create_course.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("generate-course-table", name="generate_course_table")
     */
    public function generateCourseTable()
    {
        $courses = $this->getDoctrine()->getRepository(Course::class)->findAll();
        return $this->render('employees/course_table.html.twig', array(
            'courses' => $courses
        ));
    }

    /**
     * @Route("create-course-ajax", name="create_course_ajax")
     */
    public function createCourseAjaxAction(Request $request)
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $course = $form->getData();

            $em->persist($course);
            $em->flush();

            return new Response("Corso salvato con successo", 200);
        }

        return new Response("Errore durante il salvataggio del corso", 500);
    }

    /**
     * @Route("edit-course/{courseId}", name="edit_course")
     */
    public function editCourse(int $courseId)
    {
        if($courseId == null) return new Response("Scegliere il corso da modificare", 400);
        $em = $this->getDoctrine()->getManager();

        $course = $em->getRepository(Course::class)->find($courseId);
        if($course == null) return new Response("Il corso che stai cercando di modificare non esiste", 404);

        $form = $this->createForm(CourseType::class, $course);

        $html = $this->renderView('employees/edit_course_form.html.twig', array(
            'form' => $form->createView(),
            'courseId' => $courseId
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Modifica corso',
            'modal_content' => $html
        ));
    }

    /**
     * @Route("edit-course-ajax/{courseId}", name="edit_course_ajax")
     */
    public function editCourseAjaxAction(Request $request, int $courseId)
    {
        if($courseId == null) return new Response("Scegliere il corso da modificare", 400);
        $em = $this->getDoctrine()->getManager();

        $course = $em->getRepository(Course::class)->find($courseId);
        if($course == null) return new Response("Il corso che stai cercando di modificare non esiste", 404);

        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $course = $form->getData();

            $em->flush();
            return new Response("Corso aggiornato con successo", 200);
        }

        return new Response("Errore durante il salvataggio del corso", 500);
    }

    /**
     * @Route("delete-course/{courseId}", name="delete_course")
     */
    public function deleteCourse(int $courseId)
    {
        if($courseId == null) return new Response("Scegliere il corso da eliminare", 400);
        $em = $this->getDoctrine()->getManager();

        $course = $em->getRepository(Course::class)->find($courseId);
        if($course == null) return new Response("Il corso che stai cercando di eliminare non esiste", 404);
        if(count($course->getAttendances()) > 0) return new Response("Non puoi cancellare il corso perchè ha già degli iscritti", 500);

        $em->remove($course);
        $em->flush();

        return new Response("Corso eliminato con successo", 200);
    }

    /**
     * @Route("attendances/{employeeId}", name="attendances")
     */
    public function attendancesAction(int $employeeId)
    {
        if($employeeId == null) return new Response("Devi scegliere un dipendente", 400);
        $em = $this->getDoctrine()->getManager();

        $e = $em->getRepository(Employee::class)->find($employeeId);
        if($e == null) return new Response("Dipendente non trovato", 404);

        if(count($e->getAttendances()) < 1) $e->addAttendance(new CourseAttendance());

        $form = $this->createForm(EmployeeAttendancesType::class, $e);

        $html = $this->renderView('employees/attendances.html.twig', array(
            'form' => $form->createView(),
            'employeeId' => $employeeId
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Corsi frequentati',
            'modal_content' => $html
        ));
    }

    /**
     * @Route("save-attendances/{employeeId}", name="save_attendances")
     */
    public function saveAttendancesAjax(Request $request, int $employeeId)
    {
        if($employeeId == null) return new Response("Devi scegliere un dipendente", 400);
        $em = $this->getDoctrine()->getManager();

        $e = $em->getRepository(Employee::class)->find($employeeId);
        if($e == null) return new Response("Dipendente non trovato", 404);

        $form = $this->createForm(EmployeeAttendancesType::class, $e);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $e = $form->getData();
            foreach($e->getAttendances() as $a) {
                $a->setEmployee($e);
            }
            $em->flush();

            return new Response('Modifiche salvate con successo!', 200);
        }

        return new Response("Errore durante il salvataggio", 500);
    }

}