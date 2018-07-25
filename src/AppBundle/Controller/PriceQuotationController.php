<?php

namespace AppBundle\Controller;
use AppBundle\Entity\PriceQuotation;
use AppBundle\Entity\PriceQuotationDetail;
use AppBundle\Form\CreateCategoryType;
use AppBundle\Form\CreateServiceType;
use AppBundle\Form\CreateServiceTypeType;
use AppBundle\Form\PriceQuotationType;
use AppBundle\Form\RepeatedTimesType;
use AppBundle\Helper\PriceQuotation\PriceQuotationHelper;
use AppBundle\Util\TableMaker;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PriceQuotationController extends Controller
{
    /**
     * @Route("create-price-quotation", name="create_price_quotation")
     */
    public function createPriceQuotationAction()
    {
        $PQ = new PriceQuotation();
        $QD = new PriceQuotationDetail();
        $PQ->getQuotationDetails()->add($QD);
        $QD->getArrayRepeatedTimes()->add(new RepeatedTimesType());
        $form = $this->createForm(PriceQuotationType::class, $PQ);
        $formCategory = $this->createForm(CreateCategoryType::class);
        $formServiceType = $this->createForm(CreateServiceTypeType::class);
        $formService = $this->createForm(CreateServiceType::class);

        return $this->render('price_quotations/price_quotation.html.twig', array(
            'form' => $form->createView(),
            'category_form' => $formCategory->createView(),
            'service_type_form' => $formServiceType->createView(),
            'service_form' => $formService->createView()
        ));
    }

    /**
     * @Route("create-price-quotation-ajax", name="create_price_quotation_ajax")
     */
    public function createPriceQuotationAjaxAction(Request $request)
    {
        $PQ = new PriceQuotation();
        $form = $this->createForm(PriceQuotationType::class, $PQ);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $PQ = $form->getData();

            $user = $this->getUser();

            try {
                $PQHelper = new PriceQuotationHelper($PQ, $user);
                $PQHelper->execute();
            } catch(\Exception $e) {
                return new Response( $e->getMessage(), 500);
            }

            $em = $this->getDoctrine()->getManager();

            $em->persist($PQ);
            $em->flush();

            return new Response('Ok', 200);
        }

        $errors = $form->getErrors();
        return new Response($errors, 500);
    }
}