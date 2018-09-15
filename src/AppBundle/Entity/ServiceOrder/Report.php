<?php

namespace AppBundle\Entity\ServiceOrder;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReportRepository")
 * @ORM\Table(name="reports")
 */
class Report
{

    //todo: implementare tutti i metodi

    /**
     * @ORM\Column(type="integer", name="reportId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $reportId;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ServiceOrder\ServiceOrder", inversedBy="report")
     * @ORM\JoinColumn(name="serviceOrderId", referencedColumnName="serviceOrderId")
     */
    protected $serviceOrder;
}