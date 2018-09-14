<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PriceQuotation\PriceQuotation;
use AppBundle\Entity\PriceQuotation\PriceQuotationDetail;
use AppBundle\Entity\PriceQuotation\Stage;
use AppBundle\Entity\RepeatedTimes;
use AppBundle\Entity\Service;
use AppBundle\Entity\ServiceType;
use AppBundle\Form\CreateCategoryType;
use AppBundle\Form\CreateServiceType;
use AppBundle\Form\CreateServiceTypeType;
use AppBundle\Form\PriceQuotation\PriceQuotationDetailType;
use AppBundle\Form\PriceQuotation\PriceQuotationType;
use AppBundle\Form\PriceQuotation\RepeatedTimesType;
use AppBundle\Helper\PriceQuotation\PriceQuotationDetailHelper;
use AppBundle\Helper\PriceQuotation\PriceQuotationHelper;
use AppBundle\Util\DistanceMatrixAPI;
use AppBundle\Util\PriceQuotationUtils;
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

        $PQ->setPriceQuotationDate(new \DateTime);
        $PQ->getPriceQuotationDetails()->add($PD);

        $em = $this->getDoctrine()->getManager();
        $PQ->setCode(PriceQuotationUtils::generatePriceQuotationCode($em));

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

        if ($form->isSubmitted()) {
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

        if ($form->isSubmitted() && $form->isValid()) {
            $PQ = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();

            $PQH = new PriceQuotationHelper($PQ, $em, $user);
            $PQH->execute();
            $errors = $PQH->getErrors();

            if ($errors == null) {
                $em->persist($PQ);
                $em->flush();

                return new Response('Preventivo Multiplo creato con successo', 200);
            }
            return new Response($errors, 500);
        }
        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach ($errors as $k => $e) {
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
        $em = $this->getDoctrine()->getManager();

        $st = new ServiceType();
        $service = new Service();

        $service_form_type = $this->createForm(CreateServiceTypeType::class, $st);
        $serviceType = $this->createForm(CreateServiceType::class, $service);

        $PQD = new PriceQuotationDetail();
        $PQD->setName(PriceQuotationUtils::generatePriceQuotationDetailCode($em));
        $s = new Stage();
        $s->setRepeatedTimes(array(new RepeatedTimesType()));

        if ($id != null) {
            $PQ = $em->getRepository(PriceQuotation::class)->findOneBy(array('priceQuotationId' => $id));
            if($PQ == null) return new Response('Nessun preventivo trovato', 404);
            $PQD->setPriceQuotation($PQ);
        }

        $PQD->getStages()->add($s);

        $form = $this->createForm(PriceQuotationDetailType::class, $PQD);

        return $this->render('price_quotations/create_price_quotation_detail.html.twig', array(
            'form' => $form->createView(),
            'service_form' => $serviceType->createView(),
            'service_type_form' => $service_form_type->createView()
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

        /*if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            return $this->render('DEBUG/form_data.html.twig', array(
                'data' => $data,
                'title' => 'Price Quotation Detail Debug'
            ));
        }*/

        if ($form->isSubmitted() && $form->isValid()) {
            $PQD = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $PQDH = new PriceQuotationDetailHelper($PQD, $em, false);
            $PQDH->execute();
            $errors = $PQDH->getErrors();

            if($errors == null) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($PQD);

                foreach ($PQD->getStages() as $ss) {
                    $em->persist($ss);
                }
                $em->flush();
                return new Response('Itinerario salvato con successo!', 200);
            }
            return new Response($errors, 500);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            $error = '';

            foreach ($errors as $k => $e) {
                $error .= $e->getMessage() . '<br> ';

            }
            return new Response($error, 500);
        }

        throw new AccessDeniedException('Accesso Negato');
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

        if ($form->isSubmitted()) {
            $PQ = $form->getData();

            return $this->render('price_quotations/letter_template.html.twig', array(
                'data' => $PQ
            ));
        }

        throw new \Exception('You should not be here', 403);
    }

    /**
     * @Route("/stage-details", name="stage_details")
     */
    public function stageDetailsAction(Request $request)
    {
        $id = $request->query->get('id');

        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o itinerario non trovato', 400);

        $PQD = $this->getDoctrine()->getRepository(PriceQuotationDetail::class)->findOneBy(array('priceQuotationDetailId' => $id));

        if($PQD == null) return new Response('Nessun itinerario trovato', 404);

        $html = $this->renderView('price_quotations/stage_details.html.twig', array(
            'stages' => $PQD->getStages()
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Tragitti per l\'itinerario ' . $PQD->getName(),
            'modal_content' => $html
        ));
    }

    /**
     * @Route("/distance-matrix", name="distance_matrix")
     */
    public function distanceMatrixAction(Request $request)
    {
        $startPoint = $request->query->get('startPoint');
        $endPoint = $request->query->get('endPoint');
        $startFromCompany = ($request->query->get('sfc') != 'false' ? $request->query->get('sfc') : false);
        $returnToCompany  = ($request->query->get('rtc') != 'false' ? $request->query->get('rtc') : false);

        $DM = new DistanceMatrixAPI($startPoint, $endPoint, 'json', true);
        $DM->generateRequestUrl();
        $response = $DM->getResult();

        if($startFromCompany !== false && is_array($response) !== false) {
            $sfc = new DistanceMatrixAPI('Nuoro', $startPoint, 'json', true);
            $sfc->generateRequestUrl();
            $sfcResult = $sfc->getResult();

            $response['km'] = $response['km'] + $sfcResult['km'];
            $response['time'] = $response['time'] + $sfcResult['time'];
        }

        if($returnToCompany !== false && is_array($response) !== false) {
            $rtc = new DistanceMatrixAPI($endPoint, 'Nuoro', 'json', true);
            $rtc->generateRequestUrl();
            $rtcResult = $rtc->getResult();

            $response['km'] = $response['km'] + $rtcResult['km'];
            $response['time'] = $response['time'] + $rtcResult['time'];
        }

        if(is_array($response) === true) {
            return new Response(json_encode($response));
        }

        return new Response($response, 500);
    }
}