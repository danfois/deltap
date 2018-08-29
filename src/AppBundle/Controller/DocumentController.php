<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use AppBundle\Entity\Employee\Curriculum;
use AppBundle\Entity\Employee\DriverQualificationLetter;
use AppBundle\Entity\Employee\DrivingLetter;
use AppBundle\Entity\Employee\Employee;
use AppBundle\Form\Employee\CurriculumType;
use AppBundle\Form\Employee\DriverQualificationLetterType;
use AppBundle\Form\Employee\DrivingLetterType;
use AppBundle\Helper\Employee\DrivingLetterHelper;
use AppBundle\Helper\Employee\QualificationLetterHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use AppBundle\Entity\Employee\DrivingLicense;
use AppBundle\Form\Employee\DrivingLicenseType;
use AppBundle\Helper\DocumentHelper;
use AppBundle\Helper\Employee\DrivingLicenseHelper;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DocumentController extends Controller
{
    /**
     * @Route("download-document/{id}", name="download_document")
     */
    public function downloadDocumentAction(Request $request, int $id)
    {
        $document = $this->getDoctrine()->getRepository(Document::class)->findOneBy(array('documentId' => $id));
        if ($document == null) return new Response('Nessun documento trovato', 404);

        $response = new BinaryFileResponse($document->getAbsolutePath());
        $response->headers->set('Content-Type', 'text/plain');
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $document->getName());
        return $response;
    }

    /**
     * @Route("delete-document", name="delete_document")
     */
    public function deleteDocumentAction(Request $request)
    {
        $id = $request->query->get('id');
        if (is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o nessun documento trovato', 400);

        $em = $this->getDoctrine()->getManager();
        $document = $em->getRepository(Document::class)->findOneBy(array('documentId' => $id));
        if ($document == null) return new Response('Nessun documento da cancellare trovato', 404);

        try {
            if (unlink($document->getAbsolutePath())) {

                $em->remove($document);
                $em->flush();

                return new Response('Documento rimosso con successo!', 200);
            }
        } catch (\Exception $e) {
            return new Response('Errore durante l\'eliminazione del file',500);
        }
        return new Response('Impossibile cancellare il file', 500);
    }

    /**
     * @Route("driving-licenses", name="driving_license")
     */
    public function drivingLicensesAction()
    {
        $dl = new DrivingLicense();
        $form = $this->createForm(DrivingLicenseType::class, $dl);

        $actionUrl = $this->generateUrl('create-driving-license-ajax');

        return $this->render('employees/driving_licenses.html.twig', array(
            'form' => $form->createView(),
            'documentType' => 'Patente',
            'action_url' => $actionUrl
        ));
    }

    /**
     * @Route("create-driving-license-ajax", name="create-driving-license-ajax")
     */
    public function createDrivingLicenseAjax(Request $request)
    {
        $dl = new DrivingLicense();
        $form = $this->createForm(DrivingLicenseType::class, $dl);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dl = $form->getData();
            $files = $form->get('files')->getData();

            $em = $this->getDoctrine()->getManager();

            $DLH = new DrivingLicenseHelper($dl, $em, false);
            $DLH->execute();
            $errors = $DLH->getErrors();

            $DH = new DocumentHelper($files, $em, $dl->getEmployee(), 'patente');
            $DH->execute();
            $errors .= $DH->getErrors();

            if ($errors == null) {
                $documents = $DH->getDocumentArray();

                foreach ($documents as $d) {
                    if ($d instanceof Document) {
                        $d->setDrivingLicense($dl);
                        $d->upload();
                        $em->persist($d);
                    }
                }

                $em->persist($dl);
                $em->flush();

                return new Response('Patente Creata con successo!', 200);
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
        throw new AccessDeniedException('Non sei autorizzato a vedere questa pagina');
    }

    /**
     * @Route("delete-driving-license", name="delete_driving_license")
     */
    public function deleteDrivingLicenseAction(Request $request)
    {
        $id = $request->query->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o patente non esistente', 400);

        $em = $this->getDoctrine()->getManager();
        $dl = $em->getRepository(DrivingLicense::class)->findOneBy(array('licenseId' => $id));
        if($dl == null) return new Response('Nessuna patente trovata', 404);

        $documents = $dl->getDocuments();

        try {
            foreach($documents as $d) {
                if (unlink($d->getAbsolutePath())) {
                    $em->remove($d);
                }
            }
            $em->remove($dl);
            $em->flush();

            return new Response('Patente Eliminata con Successo!', 200);
        } catch (\Exception $e) {
            return new Response('Errore durante l\'eliminazione della patente',500);
        }
    }

    /**
     * @Route("ajax/create-driving-license", name="ajax_create_driving_license")
     */
    public function ajaxCreateDrivingLicenseAction(Request $request)
    {
        $id = $request->query->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o dipendente non trovato', 400);

        $e = $this->getDoctrine()->getRepository(Employee::class)->findOneBy(array('employeeId' => $id));
        if($e == null) return new Response('Dipendente non trovato', 404);

        $dl = new DrivingLicense();
        $dl->setEmployee($e);

        $form = $this->createForm(DrivingLicenseType::class, $dl);

        $actionUrl = $this->generateUrl('create-driving-license-ajax');

        $html = $this->renderView('employees/forms/driving_license_form.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $actionUrl,
            'documentType' => 'Patente'
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Aggiungi Patente per ' . $e->getName() . ' ' . $e->getSurname(),
            'modal_content' => $html
        ));
    }

    /**
     * @Route("driving-letters", name="driving_letters")
     */
    public function drivingLettersAction()
    {
        $dl = new DrivingLetter();
        $form = $this->createForm(DrivingLetterType::class, $dl);

        $actionUrl = $this->generateUrl('create-driving-letter-ajax');

        return $this->render('employees/driving_letters.html.twig', array(
            'form' => $form->createView(),
            'documentType' => 'Carta Conducente',
            'action_url' => $actionUrl
        ));
    }

    /**
     * @Route("create-driving-letter-ajax", name="create-driving-letter-ajax")
     */
    public function createDrivingLetterAjax(Request $request)
    {
        $dl = new DrivingLetter();
        $form = $this->createForm(DrivingLetterType::class, $dl);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dl = $form->getData();
            $files = $form->get('files')->getData();

            $em = $this->getDoctrine()->getManager();

            $DLH = new DrivingLetterHelper($dl, $em, false);
            $DLH->execute();
            $errors = $DLH->getErrors();

            $DH = new DocumentHelper($files, $em, $dl->getEmployee(), 'cartaConducente');
            $DH->execute();
            $errors .= $DH->getErrors();

            if ($errors == null) {
                $documents = $DH->getDocumentArray();

                foreach ($documents as $d) {
                    if ($d instanceof Document) {
                        $d->setDrivingLetter($dl);
                        $d->upload();
                        $em->persist($d);
                    }
                }

                $em->persist($dl);
                $em->flush();

                return new Response('Carta Conducente Creata con successo!', 200);
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
        throw new AccessDeniedException('Non sei autorizzato a vedere questa pagina');
    }

    /**
     * @Route("delete-driving-letter", name="delete_driving_letter")
     */
    public function deleteDrivingLetterAction(Request $request)
    {
        $id = $request->query->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o Carta conducente non esistente', 400);

        $em = $this->getDoctrine()->getManager();
        $dl = $em->getRepository(DrivingLetter::class)->findOneBy(array('letterId' => $id));
        if($dl == null) return new Response('Nessuna carta conducente trovata', 404);

        $documents = $dl->getDocuments();

        try {
            foreach($documents as $d) {
                if (unlink($d->getAbsolutePath())) {
                    $em->remove($d);
                }
            }
            $em->remove($dl);
            $em->flush();

            return new Response('Carta Conducente Eliminata con Successo!', 200);
        } catch (\Exception $e) {
            return new Response('Errore durante l\'eliminazione della carta conducente',500);
        }
    }

    /**
     * @Route("ajax/create-driving-letter", name="ajax_create_driving_letter")
     */
    public function ajaxCreateDrivingLetterAction(Request $request)
    {
        $id = $request->query->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o dipendente non trovato', 400);

        $e = $this->getDoctrine()->getRepository(Employee::class)->findOneBy(array('employeeId' => $id));
        if($e == null) return new Response('Dipendente non trovato', 404);

        $dl = new DrivingLetter();
        $dl->setEmployee($e);

        $form = $this->createForm(DrivingLetterType::class, $dl);

        $actionUrl = $this->generateUrl('create-driving-letter-ajax');

        $html = $this->renderView('employees/forms/driving_letter_form.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $actionUrl,
            'documentType' => 'Carta Conducente'
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Aggiungi Carta Conducente per ' . $e->getName() . ' ' . $e->getSurname(),
            'modal_content' => $html
        ));
    }

    /**
     * @Route("qualification-letters", name="qualification_letters")
     */
    public function qualificationLettersAction()
    {
        $dl = new DriverQualificationLetter();
        $form = $this->createForm(DriverQualificationLetterType::class, $dl);

        $actionUrl = $this->generateUrl('create-qualification-letter-ajax');

        return $this->render('employees/qualification_letters.html.twig', array(
            'form' => $form->createView(),
            'documentType' => 'Carta Qualificazione Conducente',
            'action_url' => $actionUrl
        ));
    }

    /**
     * @Route("create-qualification-letter-ajax", name="create-qualification-letter-ajax")
     */
    public function createQualificationLetterAjax(Request $request)
    {
        $dl = new DriverQualificationLetter();
        $form = $this->createForm(DriverQualificationLetterType::class, $dl);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dl = $form->getData();
            $files = $form->get('files')->getData();

            $em = $this->getDoctrine()->getManager();

            $DLH = new QualificationLetterHelper($dl, $em, false);
            $DLH->execute();
            $errors = $DLH->getErrors();

            $DH = new DocumentHelper($files, $em, $dl->getEmployee(), 'cartaQualificazioneConducente');
            $DH->execute();
            $errors .= $DH->getErrors();

            if ($errors == null) {
                $documents = $DH->getDocumentArray();

                foreach ($documents as $d) {
                    if ($d instanceof Document) {
                        $d->setDriverQualificationLetter($dl);
                        $d->upload();
                        $em->persist($d);
                    }
                }

                $em->persist($dl);
                $em->flush();

                return new Response('Carta Qualificazione Conducente Creata con successo!', 200);
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
        throw new AccessDeniedException('Non sei autorizzato a vedere questa pagina');
    }

    /**
     * @Route("delete-qualification-letter", name="delete_qualification_letter")
     */
    public function deleteQualificationLetterAction(Request $request)
    {
        $id = $request->query->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o Carta qualificazione conducente non esistente', 400);

        $em = $this->getDoctrine()->getManager();
        $dl = $em->getRepository(DriverQualificationLetter::class)->findOneBy(array('qualificationId' => $id));
        if($dl == null) return new Response('Nessuna carta qualificazione conducente trovata', 404);

        $documents = $dl->getDocuments();

        try {
            foreach($documents as $d) {
                if (unlink($d->getAbsolutePath())) {
                    $em->remove($d);
                }
            }
            $em->remove($dl);
            $em->flush();

            return new Response('Carta Qualificazione Conducente Eliminata con Successo!', 200);
        } catch (\Exception $e) {
            return new Response('Errore durante l\'eliminazione della carta conducente',500);
        }
    }

    /**
     * @Route("ajax/create-qualification-letter", name="ajax_create_qualification_letter")
     */
    public function ajaxCreateQualificationLetterAction(Request $request)
    {
        $id = $request->query->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o dipendente non trovato', 400);

        $e = $this->getDoctrine()->getRepository(Employee::class)->findOneBy(array('employeeId' => $id));
        if($e == null) return new Response('Dipendente non trovato', 404);

        $dl = new DriverQualificationLetter();
        $dl->setEmployee($e);

        $form = $this->createForm(DriverQualificationLetterType::class, $dl);

        $actionUrl = $this->generateUrl('create-qualification-letter-ajax');

        $html = $this->renderView('employees/forms/qualification_letter_form.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $actionUrl,
            'documentType' => 'Carta Qualificazione Conducente'
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Aggiungi Carta Qualificazione Conducente per ' . $e->getName() . ' ' . $e->getSurname(),
            'modal_content' => $html
        ));
    }

    /**
     * @Route("curriculums", name="curriculums")
     */
    public function curriculumsAction()
    {
        $curriculum = new Curriculum();
        $form = $this->createForm(CurriculumType::class, $curriculum);

        $actionUrl = $this->generateUrl('create-curriculum-ajax');

        return $this->render('employees/curriculums.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $actionUrl,
            'documentType' => 'Curriculum'
        ));
    }

    /**
     * @Route("create-curriculum-ajax", name="create-curriculum-ajax")
     */
    public function createCurriculumAjaxAction(Request $request)
    {
        $curriculum = new Curriculum();
        $form = $this->createForm(CurriculumType::class, $curriculum);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $curriculum = $form->getData();
            $files = $form->get('files')->getData();

            $em = $this->getDoctrine()->getManager();

            $DH = new DocumentHelper($files, $em, $curriculum->getEmployee(), 'curriculum');
            $DH->execute();
            $errors = $DH->getErrors();

            if ($errors == null) {
                $documents = $DH->getDocumentArray();

                foreach ($documents as $d) {
                    if ($d instanceof Document) {
                        $d->setCurriculum($curriculum);
                        $d->upload();
                        $em->persist($d);
                    }
                }

                $em->persist($curriculum);
                $em->flush();

                return new Response('Curriculum creato con successo!', 200);
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
        throw new AccessDeniedException('Non sei autorizzato a vedere questa pagina');
    }

    /**
     * @Route("ajax/create-curriculum", name="ajax_create_curriculum")
     */
    public function ajaxCreateCurriculumAction(Request $request)
    {
        $id = $request->query->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o dipendente non trovato', 400);

        $e = $this->getDoctrine()->getRepository(Employee::class)->findOneBy(array('employeeId' => $id));
        if($e == null) return new Response('Dipendente non trovato', 404);

        $dl = new Curriculum();
        $dl->setEmployee($e);

        $form = $this->createForm(CurriculumType::class, $dl);

        $actionUrl = $this->generateUrl('create-curriculum-ajax');

        $html = $this->renderView('employees/forms/curriculum_form.html.twig', array(
            'form' => $form->createView(),
            'action_url' => $actionUrl,
            'documentType' => 'Curriculum'
        ));

        return $this->render('includes/generic_modal_content.html.twig', array(
            'modal_title' => 'Aggiungi Curriculum per ' . $e->getName() . ' ' . $e->getSurname(),
            'modal_content' => $html
        ));
    }

    /**
     * @Route("delete-curriculum", name="delete-curriculum")
     */
    public function deleteCurriculumAction(Request $request)
    {
        $id = $request->query->get('id');
        if(is_numeric($id) === false) return new Response('Richiesta effettuata in maniera non corretta o Curriculum non esistente', 400);

        $em = $this->getDoctrine()->getManager();
        $dl = $em->getRepository(Curriculum::class)->findOneBy(array('curriculumId' => $id));
        if($dl == null) return new Response('Nessun curriculum trovato', 404);

        $documents = $dl->getDocuments();

        try {
            foreach($documents as $d) {
                if (unlink($d->getAbsolutePath())) {
                    $em->remove($d);
                }
            }
            $em->remove($dl);
            $em->flush();

            return new Response('Curriculum eliminato con Successo!', 200);
        } catch (\Exception $e) {
            return new Response('Errore durante l\'eliminazione del curriculum',500);
        }
    }
}