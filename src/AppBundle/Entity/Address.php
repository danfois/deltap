<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\Table(name="addresses")
 */
class Address
{
    /**
     * @ORM\Column(type="integer", name="addressId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $addressId;

    /**
     * @ORM\Column(type="string", length=120, name="zone", nullable=true)
     * @Assert\Length(max=120, maxMessage="Zone too long. Max 120 characters.")
     */
    private $zone;

    /**
     * @ORM\Column(type="string", length=6, name="cap", nullable=false)
     * @Assert\Length(max=6, maxMessage="Cap is too long. Max 6 characters.")
     * @Assert\NotBlank(message="Cap is empty.")
     */
    private $cap;

    /**
     * @ORM\Column(type="string", name="city", length=32, nullable=false)
     * @Assert\NotBlank(message="City is empty. You have to provide a valid City")
     * @Assert\Length(max=32, maxMessage="City name is too long. Max 32 chars.")
     */
    private $city;

    /**
     * @ORM\Column(type="string", name="country", length=32, nullable=false)
     * @Assert\NotBlank(message="Country is empty")
     * @Assert\Length(max=32, maxMessage="Country name is too long. Max 32 chars.")
     */
    private $country;

    /**
     * @ORM\Column(type="string", name="region", length=2, nullable=true)
     * @Assert\Length(max=2, maxMessage="Region abbreviation can be long only 2 chars")
     */
    private $region;
}