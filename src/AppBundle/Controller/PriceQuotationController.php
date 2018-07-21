<?php

namespace AppBundle\Controller;
use AppBundle\Entity\PriceQuotation;
use AppBundle\Form\PriceQuotationType;
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
        $form = $this->createForm(PriceQuotationType::class, $PQ);

        return $this->render('price_quotations/price_quotation.html.twig', array(
            'form' => $form->createView()
        ));
    }
}