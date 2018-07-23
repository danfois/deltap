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
}