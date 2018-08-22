<?php

namespace AppBundle\Entity\Vehicle;

interface UnavailabilityInterface
{
    public function getStartDate();
    public function getEndDate();
    public function getVehicle();
    public function getIssue();
}