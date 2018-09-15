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
use AppBundle\Form\PriceQuotation\PriceQuotationDetailEditType;
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
        $PQ->addPriceQuotationDetail($PD);

        //questo mi serve perchè altrimenti non mi fa fare il form di creazione
        $em = $this->getDoctrine()->getManager();
        $em->persist($PD);

        $em = $this->getDoctrine()->getManager();
        $PQ->setCode(PriceQuotationUtils::generatePriceQuotationCode($em));

        $form = $this->createForm(PriceQuotationType::class, $PQ);

        //$actionUrl = $this->generateUrl('create_price_quotation_ajax_test');
        $actionUrl = $this->generateUrl('create_price_quotation_ajax');

        return $this->render('price_quotations/create_price_quotation.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $actionUrl,
            'title' => 'Creazione Preventivo'
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

                foreach($PQ->getPriceQuotationDetails() as $d) {
                    $em->persist($d);
                }

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

        $actionUrl = $this->generateUrl('create_price_quotation_detail_ajax');

        return $this->render('price_quotations/create_price_quotation_detail.html.twig', array(
            'form' => $form->createView(),
            'service_form' => $serviceType->createView(),
            'service_type_form' => $service_form_type->createView(),
            'action_url' => $actionUrl,
            'title' => 'Crea Itinerario'
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
     * @Route("edit-pq-detail-{id}", name="edit_price_quotation_detail")
     */
    public function editPriceQuotationDetailAction(int $id)
    {
        $pqd = $this->getDoctrine()->getRepository(PriceQuotationDetail::class)->findOneBy(array('priceQuotationDetailId' => $id));
        if($pqd == null) return new Response('Itinerario non trovato!', 404);

        $form = $this->createForm(PriceQuotationDetailEditType::class, $pqd);

        $st = new ServiceType();
        $service = new Service();

        $service_form_type = $this->createForm(CreateServiceTypeType::class, $st);
        $serviceType = $this->createForm(CreateServiceType::class, $service);

        $actionUrl = $this->generateUrl('ajax_edit_price_quotation_detail', array('id' => $id));

        return $this->render('price_quotations/create_price_quotation_detail.html.twig', array(
            'form' => $form->createView(),
            'service_form' => $serviceType->createView(),
            'service_type_form' => $service_form_type->createView(),
            'action_url' => $actionUrl,
            'title' => 'Modifica Itinerario'
        ));
    }

    /**
     * @Route("ajax/edit-pq-detail-{id}", name="ajax_edit_price_quotation_detail")
     */
    public function ajaxEditPriceQuotationDetailAction(Request $request, int $id)
    {
        $pqd = $this->getDoctrine()->getRepository(PriceQuotationDetail::class)->findOneBy(array('priceQuotationDetailId' => $id));
        if($pqd == null) return new Response('Itinerario non trovato!', 404);

        $form = $this->createForm(PriceQuotationDetailEditType::class, $pqd);

        $form->handleRequest($request);

        /*if($form->isSubmitted() && $form->isValid()) {
            $pqd = $form->getData();

            return $this->render('DEBUG/modal_debug.html.twig', array(
                'data' => $pqd
            ));
        }*/

        if ($form->isSubmitted() && $form->isValid()) {
            $PQD = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $PQDH = new PriceQuotationDetailHelper($PQD, $em, true);
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
     * @Route("edit-price-quotation-{id}", name="edit_price_quotation")
     */
    public function editPriceQuotation(int $id)
    {
        $PQ = $this->getDoctrine()->getRepository(PriceQuotation::class)->findOneBy(array('priceQuotationId' => $id));

        if($PQ == null) return new Response('Impossibile trovare questo preventivo', 404);

        $form = $this->createForm(PriceQuotationType::class, $PQ);

        $actionUrl = $this->generateUrl('ajax_edit_price_quotation', array('id' => $id));
        //$actionUrl = $this->generateUrl('test_submit', array('id' => $id));

        return $this->render('price_quotations/create_price_quotation.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $actionUrl,
            'title' => 'Modifica Preventivo'
        ));
    }

    /**
     * @Route("ajax/edit-price-quotation-{id}", name="ajax_edit_price_quotation")
     */
    public function ajaxEditPriceQuotation(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();

        $PQ = $em->getRepository(PriceQuotation::class)->findOneBy(array('priceQuotationId' => $id));
        if($PQ == null) return new Response('Impossibile trovare questo preventivo', 404);

        $form = $this->createForm(PriceQuotationType::class, $PQ);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $PQ = $form->getData();

            $PQH = new PriceQuotationHelper($PQ, $em, $this->getUser());
            $PQH->execute();
            $errors = $PQH->getErrors();

            if ($errors == null) {

                $em->flush();

                return new Response('Preventivo modificato con successo', 200);
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

    /**
     * @Route("change-price-quotation-status", name="change_price_quotation_status")
     */
    public function changePriceQuotationStatusAction(Request $request)
    {
        $id = $request->query->get('id');
        $status = $request->query->get('status');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o Preventivo non trovato', 400);

        $possibleStatusArray = array(
            1 => 'da Inviare',
            2 => 'inviato',
            3 => 'confermato',
            4 => 'annullato'
        );

        //todo: devo fare un check per vedere se ho gia emesso ordini di servizio per un itinerario di questo preventivo

        if(array_key_exists($status, $possibleStatusArray) === false) return new Response('Stato del preventivo richiesto NON valido!', 500);

        $em = $this->getDoctrine()->getManager();

        $pq = $em->getRepository(PriceQuotation::class)->findOneBy(array('priceQuotationId' => $id));

        if($pq == null) return new Response('Preventivo non trovato', 404);

        $pq->setStatus($status);
        $em->flush();

        return new Response('Preventivo ' . $possibleStatusArray[$status] . ' con successo!', 200);
    }
}