<?php

namespace AppBundle\Controller\Salary;
use AppBundle\Entity\Salary\Salary;
use AppBundle\Entity\Salary\SalaryDetail;
use AppBundle\Form\Salary\SalaryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

            $em->persist($salary);
            $em->flush();

            return new Response('ok', 200);
        }
    }
}