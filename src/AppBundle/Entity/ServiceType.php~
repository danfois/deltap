<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\Table(name="service_types")
 */
class ServiceType
{
    /**
     * @ORM\Column(type="integer", name="service_id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $service_id;

    /**
     * @ORM\Column(type="string", length=24, nullable=false, name="service_name")
     * @Assert\NotBlank(message="Service Name cannot be blank")
     * @Assert\Length(max=24, maxMessage="Service Name cannot exceed 24 chars.")
     */
    private $service_name;
}