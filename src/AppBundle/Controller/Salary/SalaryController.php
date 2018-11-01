<?php

namespace AppBundle\Controller\Salary;
use AppBundle\Entity\Salary\Salary;
use AppBundle\Entity\Salary\SalaryDetail;
use AppBundle\Form\Salary\SalaryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SalaryController extends Controller
{
    /**
     * @Route("create-salary", name="create_salary")
     */
    public function createSalaryAction()
    {
        $salary = new Salary();
        $salaryDetail = new SalaryDetail();

        $salary->addSalaryDetail($salaryDetail);

        $form = $this->createForm(SalaryType::class, $salary);

        return $this->render('DEBUG/show_form.html.twig', array(
            'form' => $form->createView()
        ));
    }
}