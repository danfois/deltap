<?php

namespace AppBundle\Controller\Vehicle;
use AppBundle\Entity\Vehicle\Insurance;
use AppBundle\Form\Vehicle\InsuranceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InsuranceController extends Controller
{
    /**
     * @Route("create-insurance", name="create_insurance")
     */
    public function createInsuranceAction()
    {
        $insurance = new Insurance();

        $form = $this->createForm(InsuranceType::class, $insurance);

        return $this->render('vehicles/insurances.html.twig', array(
            'form' => $form->createView()
        ));
    }
}