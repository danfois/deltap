<?php


namespace AppBundle\Controller;
use AppBundle\Entity\PriceQuotation\Demand;
use AppBundle\Form\PriceQuotation\DemandType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DemandController extends Controller
{
    /**
     * @Route("create-demand", name="create_demand")
     */
    public function createDemandAction()
    {
        $d = new Demand();
        $form = $this->createForm(DemandType::class, $d);

        return $this->render('DEBUG/show_form.html.twig', array(
            'form' => $form->createView()
        ));
    }
}