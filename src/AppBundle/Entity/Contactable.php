<?php

namespace AppBundle\Entity;

interface Contactable
{
    public function getEmail();

    public function getPhone();

    public function getMobile();

    public function getFax();

    public function setEmail();

    public function setPhone();

    public function setMobile();

    public function setFax();
}