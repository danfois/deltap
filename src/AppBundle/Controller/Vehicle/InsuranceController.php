<?php

namespace AppBundle\Controller\Vehicle;
use AppBundle\Entity\Vehicle\Insurance;
use AppBundle\Form\Vehicle\InsuranceType;
use AppBundle\Helper\Vehicle\InsuranceHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

    /**
     * @Route("create-insurance-ajax", name="create_insurance_ajax")
     */
    public function createInsuranceAjax(Request $request)
    {
        $insurance = new Insurance();
        $form = $this->createForm(InsuranceType::class, $insurance);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $insurance = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $IH = new InsuranceHelper($insurance, $em);
            $IH->execute();
            $errors = $IH->getErrors();

            if ($errors == null) {

                $em->persist($insurance);
                $em->flush();

                return new Response('OK', 200);
            } else {
                return new Response($errors, 500);
            }
        }
        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Accesso Negato');
    }
}