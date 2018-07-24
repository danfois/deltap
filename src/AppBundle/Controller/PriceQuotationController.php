<?php

namespace AppBundle\Controller;
use AppBundle\Entity\PriceQuotation;
use AppBundle\Entity\PriceQuotationDetail;
use AppBundle\Form\CreateCategoryType;
use AppBundle\Form\CreateServiceType;
use AppBundle\Form\CreateServiceTypeType;
use AppBundle\Form\PriceQuotationType;
use AppBundle\Form\RepeatedTimesType;
use AppBundle\Util\TableMaker;
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

            return $this->render('DEBUG/form_data.html.twig', array(
                'data' => $PQ,
                'title' => 'Debug Price Quotation Form'
            ));
        }
        $errors = $form->getErrors();
        return $this->render('DEBUG/form_data.html.twig', array(
            'data' => $errors,
            'title' => 'Errore durante l\'invio del form'
        ));
    }
}