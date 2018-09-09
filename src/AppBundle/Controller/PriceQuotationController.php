<?php

namespace AppBundle\Controller;
use AppBundle\Entity\PriceQuotation\PriceQuotation;
use AppBundle\Entity\PriceQuotation\PriceQuotationDetail;
use AppBundle\Entity\PriceQuotation\Stage;
use AppBundle\Entity\RepeatedTimes;
use AppBundle\Form\CreateCategoryType;
use AppBundle\Form\CreateServiceType;
use AppBundle\Form\CreateServiceTypeType;
use AppBundle\Form\PriceQuotation\PriceQuotationDetailType;
use AppBundle\Form\PriceQuotation\PriceQuotationType;
use AppBundle\Form\PriceQuotation\RepeatedTimesType;
use AppBundle\Helper\PriceQuotation\PriceQuotationHelper;
use AppBundle\Util\TableMaker;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PriceQuotationController extends Controller
{
    /**
     * @Route("create-price-quotation", name="create_price_quotation")
     */
    public function createPriceQuotationAction()
    {
        $PQ = new PriceQuotation();
        $PD = new PriceQuotationDetail();

        $PQ->getPriceQuotationDetails()->add($PD);

        $form = $this->createForm(PriceQuotationType::class, $PQ);

        //$actionUrl = $this->generateUrl('create_price_quotation_ajax_test');
        $actionUrl = $this->generateUrl('create_price_quotation_ajax');

        return $this->render('price_quotations/create_price_quotation.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $actionUrl
        ));
    }

    /**
     * @Route("create-price-quotation-ajax-test", name="create_price_quotation_ajax_test")
     */
    public function createPriceQuotationAjaxTest(Request $request)
    {
        $PQ = new PriceQuotation();
        $form = $this->createForm(PriceQuotationType::class, $PQ);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $data = $form->getData();

            return $this->render('DEBUG/form_data.html.twig', array(
                'data' => $data,
                'title' => 'DEBUG di preventivo'
            ));
        }

        return new Response('NON VA BENE', 200);
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
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();

            $PQH = new PriceQuotationHelper($PQ, $em, $user);
            $PQH->execute();
            $errors = $PQH->getErrors();

            if($errors == null) {
                $em->persist($PQ);
                $em->flush();

                return new Response('Preventivo Multiplo creato con successo', 200);
            }
            return new Response($errors, 500);
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

    /**
     * @Route("create-price-quotation-detail-{id}", name="create_price_quotation_detail")
     */
    public function createPriceQuotationDetailAction(Request $request, int $id = null)
    {
        //todo: l'id mi serve nel caso sto creando un dettaglio da associare ad un preventivo multiplo già esistente

        $PQD = new PriceQuotationDetail();
        $s = new Stage();
        $s->setRepeatedTimes(array(new RepeatedTimesType()));

        $PQD->getStages()->add($s);

        $form = $this->createForm(PriceQuotationDetailType::class, $PQD);

        return $this->render('price_quotations/create_price_quotation_detail.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("ajax/create-price-quotation-detail", name="create_price_quotation_detail_ajax")
     */
    public function createPriceQuotationDetaiAjax(Request $request)
    {
        $PQD = new PriceQuotationDetail();
        $form = $this->createForm(PriceQuotationDetailType::class, $PQD);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $PQD = $form->getData();

            //todo: eventualmente implementare un helper

            $em = $this->getDoctrine()->getManager();
            $em->persist($PQD);

            foreach($PQD->getStages() as $ss) {
                $em->persist($ss);
            }
            $em->flush();

            return new Response('ok', 200);
        }
        return new Response('nessun form inviato', 500);
    }

    /**
     * @Route("price-quotations-list", name="price_quotations_list")
     */
    public function priceQuotationListAction()
    {
        return $this->render('price_quotations/price_quotation_list.html.twig');
    }

    /**
     * @Route("generate-letter", name="generate_letter")
     */
    public function generateLetterAction(Request $request)
    {
        //TODO: create a good template for the letter

        $PQ = new PriceQuotation();
        $form = $this->createForm(PriceQuotationType::class, $PQ);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $PQ = $form->getData();

            return $this->render('price_quotations/letter_template.html.twig', array(
                'data' => $PQ
            ));
        }

        throw new \Exception('You should not be here', 403);
    }

    /**
     * @Route("/distance-matrix", name="distance_matrix")
     */
    public function distanceMatrixAction(Request $request)
    {
        $DistanceMatrixUrl = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=Washington,DC&destinations=New+York+City,NY&key=';
        $response = file_get_contents('https://maps.googleapis.com/maps/api/directions/json?origin=Sennori&destination=Sassari&key=AIzaSyBzvS_c1V5lQH9KZWO8A5QihgEAcYQfC1A');

        return new Response($response, 200);
    }
}