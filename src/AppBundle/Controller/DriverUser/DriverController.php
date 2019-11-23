<?php

namespace AppBundle\Controller\DriverUser;
use AppBundle\Entity\ServiceOrder\ServiceOrder;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DriverController extends Controller
{
    /**
     * @Route("/drivers/daily-orders", name="daily_orders")
     */
    public function dailyOrdersAction()
    {
        $user = $this->getUser()->getIdUser();
        $em = $this->getDoctrine()->getManager();

        $newOrders = $em->getRepository(ServiceOrder::class)->findDriverNewOrders($user, new \DateTime(), 1);
        $oldOrders = $em->getRepository(ServiceOrder::class)->findDriverOldOrders($user, new \DateTime('- 1 minute'), 2);
        $futureOrders = $em->getRepository(ServiceOrder::class)->findDriverFutureOrders($user, new \DateTime('+ 1 day'), 1);
        $toReportOrders = $em->getRepository(ServiceOrder::class)->findDriverToReportOrders($user, new \DateTime());

        return $this->render('driver/driver_service_orders.html.twig', array(
            'new_orders' => $newOrders,
            'old_orders' => $oldOrders,
            'future_orders' => $futureOrders,
            'to_report_orders' => $toReportOrders
        ));
    }
}