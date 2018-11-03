<?php

namespace AppBundle\Controller\Salary;
use AppBundle\Entity\Salary\Salary;
use AppBundle\Entity\Salary\SalaryDetail;
use AppBundle\Form\Salary\SalaryType;
use AppBundle\Helper\Salary\SalaryHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class SalaryController extends Controller
{
    /**
     * @Route("create-salary", name="create_salary")
     */
    public function createSalaryAction(Request $request)
    {
        $salary = new Salary();
        $salaryDetail = new SalaryDetail();

        $salary->addSalaryDetail($salaryDetail);

        $form = $this->createForm(SalaryType::class, $salary);

        return $this->render('salary/salary_form.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Crea Stipendio',
            'action_url' => $this->generateUrl('create_salary_ajax')
        ));
    }

    /**
     * @Route("create-salary-ajax", name="create_salary_ajax")
     */
    public function createSalaryAjax(Request $request)
    {
        $salary = new Salary();

        $form = $this->createForm(SalaryType::class, $salary);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $salary = $form->getData();

            $SH = new SalaryHelper($salary, $em, false);
            $SH->execute();
            $errors = $SH->getErrors();

            if($errors == null) {
                $em->persist($salary);
                $em->flush();

                return new Response('Stipendio creato con successo!', 200);
            } else {
                return new Response($errors, 500);
            }
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach ($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Accesso Negato');
    }

    /**
     * @Route("edit-salary-{n}", name="edit_salary")
     */
    public function editSalary(int $n)
    {
        $salary = $this->getDoctrine()->getRepository(Salary::class)->find($n);
        if($salary == null) return new Response('Stipendio non trovato', 404);

        $form = $this->createForm(SalaryType::class, $salary);

        return $this->render('salary/salary_form.html.twig', array(
            'title' => 'Modifica Stipendio',
            'action_url' => $this->generateUrl('edit_salary_ajax', array('n' => $n)),
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("ajax/edit-salary-{n}", name="edit_salary_ajax")
     */
    public function editSalaryAction(Request $request, int $n)
    {
        $salary = $this->getDoctrine()->getRepository(Salary::class)->find($n);
        if($salary == null) return new Response('Stipendio non trovato', 404);

        $form = $this->createForm(SalaryType::class, $salary);

        $oldSalary = clone $salary;
        $oldDetails = array();

        foreach($oldSalary->getSalaryDetails() as $d) {
            $oldDetails[] = $d->getSalaryDetailId();
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $salary = $form->getData();

            $SH = new SalaryHelper($salary, $em, true);
            $SH->execute();
            $SH->removeOldPayments($oldDetails);
            $errors = $SH->getErrors();

            if($errors == null) {
                $em->flush();

                return new Response('Stipendio modificato con successo!', 200);
            } else {
                return new Response($errors, 500);
            }
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach ($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Accesso Negato');
    }
}