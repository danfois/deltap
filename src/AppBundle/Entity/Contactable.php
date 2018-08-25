<?php

namespace AppBundle\Entity;

interface Contactable
{
    public function getEmail();

    public function getPhone();

    public function getMobile();

    public function getFax();

    public function setEmail($email);

    public function setPhone($phone);

    public function setMobile($mobile);

    public function setFax($fax);
}