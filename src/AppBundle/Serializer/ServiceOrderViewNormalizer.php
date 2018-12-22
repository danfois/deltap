<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\ServiceOrder\ServiceOrder;
use AppBundle\Entity\User;
use AppBundle\Entity\Vehicle\Vehicle;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ServiceOrderViewNormalizer implements NormalizerInterface
{

    protected $em;
    protected $vehicles;
    protected $employees;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getEmployeeSelect()
    {
        $this->employees = $this->em->getRepository(User::class)->findWithEmployee();
    }

    public function getVehicleSelect()
    {
        $this->vehicles = $this->em->getRepository(Vehicle::class)->findAll();
    }

    protected function prepareUserOptions($id)
    {
        $options = null;
        $options .= '<option value="">Nessuno</option>';

        foreach($this->employees as $e) {
            if($id === $e->getIdUser()) {
                $options .= '<option selected="selected" value=' . $e->getIdUser() . '>' . $e->getEmployee()->getSurname() . ' ' . $e->getEmployee()->getName()  . ' </option>';
            } else {
                $options .= '<option value="' . $e->getIdUser() . '">' . $e->getEmployee()->getSurname() . ' ' . $e->getEmployee()->getName() . ' </option>';
            }
        }

        return $options;
    }

    protected function prepareVehicleOptions($id)
    {
        $options = null;
        $options .= '<option value="">Nessuno</option>';

        foreach($this->vehicles as $e) {
            if($id === $e->getVehicleId()) {
                $options .= '<option selected="selected" value=' . $e->getVehicleId() . '>' . $e->getPlate() . ' </option>';
            } else {
                $options .= '<option value="' . $e->getVehicleId() . '">' . $e->getPlate() .  ' </option>';
            }
        }

        return $options;
    }

    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        $this->getEmployeeSelect();
        $this->getVehicleSelect();

        foreach($object as $o) {
            if($o instanceof ServiceOrder) {

                $startTime = \DateTime::createFromFormat('H:i', $o->getStartTime());
                $endTime = \DateTime::createFromFormat('H:i', $o->getEndTime());

                $totalTime = $endTime->diff($startTime)->format('%H') < 5 ? 1 : 0;

                $r[] = [
                    'id' => $o->getServiceOrder(),
                    'idv' => $o->getServiceOrder(),
                    'ids' => $o->getServiceOrder(),
                    'customer' => $o->getCustomer()->getBusinessName(),
                    'pq' => ($o->getPriceQuotation() == null ? '' : $o->getPriceQuotation()->getCode()),
                    'pqd' => $o->getPriceQuotationDetail()->getName(),
                    'departureLocation' => $o->getDepartureLocation(),
                    'arrivalLocation' => $o->getArrivalLocation(),
                    'departureDate' => $o->getDepartureDate()->format('d-m-Y'),
                    'arrivalDate' => $o->getArrivalDate()->format('d-m-Y'),
                    'time' => $o->getStartTime() . ' - ' . $o->getEndTime(),
                    'lessThanFive' => $totalTime,
//                    'driver' => ($o->getDriver() != null ? $o->getDriver()->getUsername() : 'Nessuno'),
                    'driver' => '<select class="driver_select" data-so="' . $o->getServiceOrder() . '">' . $this->prepareUserOptions($o->getDriver() != null ? $o->getDriver()->getIdUser() : '') . '</select>',
                    'vehicle' => '<select class="vehicle_select" data-so="' . $o->getServiceOrder() . '">' . $this->prepareVehicleOptions($o->getVehicle() != null ? $o->getVehicle()->getVehicleId() : '') . '</select>',
                    //'vehicle' => ($o->getVehicle() != null ? $o->getVehicle()->getPlate() : 'Nessuno'),
                    'price' => $o->getPrice(),
                    'frequency' => $o->getServiceFrequency()->getServiceName(),
                    'service' => $o->getService()->getService(),
                    'passengers' => $o->getPassengers(),
                    'status' => $o->getStatus()
                ];
            }
        }

        return $r;
    }

    public function supportsNormalization($data, $format = null)
    {
        return true;
    }
}