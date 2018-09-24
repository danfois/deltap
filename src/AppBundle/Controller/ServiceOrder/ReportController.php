<?php

namespace AppBundle\Controller\ServiceOrder;

use AppBundle\Entity\ServiceOrder\Report;
use AppBundle\Entity\ServiceOrder\ServiceOrder;
use AppBundle\Form\ServiceOrder\ReportType;
use AppBundle\Helper\ServiceOrder\ReportHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class ReportController extends Controller
{
    /**
     * @Route("create-report-{id}", name="create_report")
     */
    public function createReportAction(int $id)
    {
        $user = $this->getUser();
        $so = $this->getDoctrine()->getRepository(ServiceOrder::class)->findOneBy(array('serviceOrder' => $id));
        if ($so == null) return new Response('Ordine di Servizio non trovato!', 404);
        if ($so->getReport() != null) return new Response('Esiste già un report per questo Ordine di Servizio', 500);
        if ($so->getDriver() !== $user) return new Response('Non sei autorizzato a fare questa operazione. Il prossimo tentativo verrà segnalato all\'amministratore', 403);

        $report = new Report();
        $report->setServiceOrder($so);

        $form = $this->createForm(ReportType::class, $report);

        $actionUrl = $this->generateUrl('ajax_create_report');

        return $this->render('service_orders/report.html.twig', array(
            'title' => 'Creazione Report per Ordine di Servizio N. ' . $so->getServiceOrder(),
            'action_url' => $actionUrl,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("ajax/create-report", name="ajax_create_report")
     */
    public function createReportAjaxAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $report = new Report();
        $form = $this->createForm(ReportType::class, $report);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $report = $form->getData();
            $so = $report->getServiceOrder();

            if ($so == null) return new Response('Ordine di Servizio non trovato', 404);
            if ($so->getReport() != null) return new Response('Esiste già un Report per questo Ordine di Servizio', 500);
            if ($so->getDriver() != $user) return new Response('Non sei autorizzato a fare questa operazione. Il prossimo tentativo verrà segnalato all\'Amministratore', 403);

            $RH = new ReportHelper($report, $em, false);
            $RH->execute();
            $errors = $RH->getErrors();

            if ($errors == null) {
                $report->setUser($user);
                $em->persist($report);
                $em->flush();

                return new Response('Report inviato correttamente!', 200);
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

        throw new AccessDeniedException();
    }

    /**
     * @Route("edit-report-{id}", name="edit-report")
     */
    public function editReportAction(int $id)
    {
        $user = $this->getUser();
        $so = $this->getDoctrine()->getRepository(ServiceOrder::class)->findOneBy(array('serviceOrder' => $id));
        if ($so == null) return new Response('Ordine di Servizio non trovato!', 404);
        if ($so->getReport() == null) return new Response('Non esiste un report per questo Ordine di Servizio', 500);
        if ($so->getDriver() != $user && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) return new Response('Non sei autorizzato a fare questa operazione. Il prossimo tentativo verrà segnalato all\'amministratore', 403);

        $report = $so->getReport();

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            if($report->getSubmitDate()->diff(new \DateTime())->days > 1) return new Response('Non sei autorizzato a fare questa operazione', 403);
        }

        $form = $this->createForm(ReportType::class, $report);

        $actionUrl = $this->generateUrl('ajax_edit_report', array('id' => $id));

        return $this->render('service_orders/report.html.twig', array(
            'title' => 'Modifica Report per Ordine di Servizio N. ' . $so->getServiceOrder(),
            'form' => $form->createView(),
            'action_url' => $actionUrl
        ));
    }

    /**
     * @Route("ajax/edit-report-{id}", name="ajax_edit_report")
     */
    public function editReportAjaxAction(Request $request, int $id)
    {
        $user = $this->getUser();
        $so = $this->getDoctrine()->getRepository(ServiceOrder::class)->findOneBy(array('serviceOrder' => $id));
        if ($so == null) return new Response('Ordine di Servizio non trovato!', 404);
        if ($so->getReport() == null) return new Response('Non esiste un report per questo Ordine di Servizio', 500);
        if ($so->getDriver() != $user && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) return new Response('Non sei autorizzato a fare questa operazione. Il prossimo tentativo verrà segnalato all\'amministratore', 403);

        $report = $so->getReport();

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            if($report->getSubmitDate()->diff(new \DateTime())->days > 1) return new Response('Non sei autorizzato a fare questa operazione', 403);
        }

        $form = $this->createForm(ReportType::class, $report);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $report = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $RH = new ReportHelper($report, $em, true);
            $RH->execute();
            $errors = $RH->getErrors();

            if($errors == null) {
                $em->flush();
                return new Response('Report modificato con successo!', 200);
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

        throw new AccessDeniedException();
    }

}