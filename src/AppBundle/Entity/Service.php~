<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\Table(name="services")
 */
class Service
{
    /**
     * @ORM\Column(type="integer", name="service_id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $service_id;

    /**
     * @ORM\Column(type="string", length=4, nullable=false, name="service_code")
     * @Assert\NotBlank(message="You have to provide a valid Service Code")
     * @Assert\Length(max=4, maxMessage="Service Code is too long. Max 4 chars.")
     */
    private $service_code;

    /**
     * @ORM\Column(type="string", name="service", nullable=false, length=120)
     * @Assert\NotBlank(message="You have to provide a valid Service Name")
     * @Assert\Length(max=120, maxMessage="Service Name is too long. Max 120 chars")
     */
    private $service;

    /**
     * Get serviceId
     *
     * @return integer
     */
    public function getServiceId()
    {
        return $this->service_id;
    }

    /**
     * Set serviceCode
     *
     * @param string $serviceCode
     *
     * @return Service
     */
    public function setServiceCode($serviceCode)
    {
        $this->service_code = $serviceCode;

        return $this;
    }

    /**
     * Get serviceCode
     *
     * @return string
     */
    public function getServiceCode()
    {
        return $this->service_code;
    }

    /**
     * Set service
     *
     * @param string $service
     *
     * @return Service
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }
}
