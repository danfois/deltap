<?php

namespace AppBundle\Controller\Employee;

use AppBundle\Entity\Employee\Employee;
use AppBundle\Entity\Employee\EmployeeTurn;
use AppBundle\Form\Employee\EmployeeTurnDetailDriverType;
use AppBundle\Form\Employee\EmployeeTurnType;
use AppBundle\Helper\Employee\TurnDetailHelper;
use AppBundle\Helper\Employee\TurnHelper;
use AppBundle\Helper\Employee\TurnViewTransformer;
use AppBundle\Service\EmployeeTurn\EmployeeTurnManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TurnController extends Controller
{
    /**
     * @Route("daily-turns/{n}", name="daily_turns")
     */
    public function dailyTurnsAction(EmployeeTurnManager $etm, string $n = null)
    {
        if ($n !== null) {

            $date = \DateTime::createFromFormat('d-m-Y', $n);
            if ($date === false) return new Response('Data non corretta', 500);

            $turn = $this->getDoctrine()->getRepository(EmployeeTurn::class)->findOneBy(array('turnDate' => $date));
            if ($turn == null) return new Response('Nessun turno esistente per questa data', 404);

        } else {
            $date = new \DateTime();
            $turn = $etm->getTodayTurn();
        }

        $form = $this->createForm(EmployeeTurnType::class, $turn);

        return $this->render('employees/turns/daily_turns.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Turni Giornalieri',
            'action_url' => $this->generateUrl('ajax_daily_turns', array('n' => $n)),
            'date' => $date
        ));
    }

    /**
     * @Route("ajax-daily-turns/{n}", name="ajax_daily_turns")
     */
    public function submitdailyTurnsAction(Request $request, EmployeeTurnManager $etm, $n = null)
    {
        if ($n !== null) {

            $date = \DateTime::createFromFormat('d-m-Y', $n);
            if ($date === false) return new Response('Data non corretta', 500);

            $turn = $this->getDoctrine()->getRepository(EmployeeTurn::class)->findOneBy(array('turnDate' => $date));
            if ($turn == null) return new Response('Nessun turno esistente per questa data', 404);

        } else {
            $date = new \DateTime();
            $turn = $etm->getTodayTurn();
        }

        $form = $this->createForm(EmployeeTurnType::class, $turn);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $turn = $form->getData();

            $TH = new TurnHelper($turn, $em, false);
            $TH->execute();
            $errors = $TH->getErrors();

            if ($errors == null) {
                $em->flush();
                return new Response('Turni salvati', 200);
            }
            return new Response($errors, 500);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            if ($form->isSubmitted() && !$form->isValid()) {
                $errors = $form->getErrors(true);
                $error = '';

                foreach ($errors as $k => $e) {
                    $error .= $e->getMessage() . '<br> ';

                }
                return new Response($error, 500);
            }
        }

        throw new AccessDeniedException('Non sei autorizzato a fare questa operazione');
    }

    /**
     * @Route("daily-driver-turn", name="daily_driver_turn")
     */
    public function dailyDriverTurnAction(EmployeeTurnManager $etm)
    {
        $user = $this->getUser();
        if ($user == null) return new Response('Non sei autorizzato a fare questa operazione');

        $turn = $etm->getTodayDriverTurn($user);

        $form = $this->createForm(EmployeeTurnDetailDriverType::class, $turn);

        return $this->render('employees/turns/daily_driver_turns.html.twig', array(
            'title' => 'Turno Giornaliero',
            'action_url' => $this->generateUrl('ajax_daily_driver_turn'),
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("ajax/daily-driver-turn", name="ajax_daily_driver_turn")
     */
    public function ajaxDailyDriverTurnAction(Request $request, EmployeeTurnManager $etm)
    {
        $user = $this->getUser();
        if ($user == null) return new Response('Non sei autorizzato a fare questa operazione');

        $turn = $etm->getTodayDriverTurn($user);

        $form = $this->createForm(EmployeeTurnDetailDriverType::class, $turn);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $turn = $form->getData();

            $THD = new TurnDetailHelper($turn, $em, false);
            $THD->execute();
            $errors = $THD->getErrors();

            if ($errors == null) {
                $em->flush();
                return new Response('Turno salvato', 200);
            }
            return new Response($errors, 500);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            if ($form->isSubmitted() && !$form->isValid()) {
                $errors = $form->getErrors(true);
                $error = '';

                foreach ($errors as $k => $e) {
                    $error .= $e->getMessage() . '<br> ';

                }
                return new Response($error, 500);
            }
        }

        throw new AccessDeniedException('Non sei autorizzato a fare questa operazione');
    }

    /**
     * @Route("monthly-turn-view/{m}/{y}", name="monthly_turn_view")
     */
    public function monthlyTurnView(int $m, int $y)
    {
        if ($m > 12) return new Response('Non ci sono altri mesi dopo Dicembre', 500);

        $startDate = $y . '/' . $m . '/' . '01';
        $endDate = $y . '/' . $m . '/' . '31';

        try {
            $turns = $this->getDoctrine()->getRepository(EmployeeTurn::class)->findTurnsInMonthAndYear($startDate, $endDate);
        } catch (\Exception $e) {
            return new Response('Errore durante il recupero dei turni', 500);
        }

        $TVT = new TurnViewTransformer($turns);
        $turns = $TVT->prepareDataArray()->getTransformedData();

        return $this->render('employees/turns/monthly_turn_views.html.twig', array(
            'data' => $turns
        ));
    }
}