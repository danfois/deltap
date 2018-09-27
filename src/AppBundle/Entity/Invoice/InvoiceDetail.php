<?php

namespace AppBundle\Entity\Invoice;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Validator\Constraints as Assert;

class InvoiceDetail
{
    //todo: implementare metodi completi per totale tasse escluse e incluse
    /**
     * @ORM\Column(type="integer", name="invoiceDetailId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $invoiceDetail;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=2, nullable=false, name="vat")
     * @Assert\NotBlank(message="Vat percentage cannot be null")
     */
    protected $vat;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="totTaxExc")
     */
    protected $totTaxExc;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="totTaxInc")
     */
    protected $totTaxInc;

    /**
     * @ORM\Column(type="string", nullable=false, length=12, name="productCode")
     * @Assert\NotBlank(message="Product Code must not be null")
     * @Assert\Length(max=12, maxMessage="Product Code is too long. Max 12 chars")
     */
    protected $productCode;

    /**
     * @ORM\Column(type="string", nullable=false, length=128, name="productName")
     * @Assert\NotBlank(message="Product name cannot be null")
     * @Assert\Length(max=128, maxMessage="Product name is too long. Max 128 chars")
     */
    protected $productName;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Invoice\IssuedInvoice", inversedBy="invoiceDetails")
     * @ORM\JoinColumn(name="issuedInvoiceId", referencedColumnName="invoiceId", nullable=true)
     */
    protected $issuedInvoice;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Invoice\ReceivedInvoice", inversedBy="invoiceDetails")
     * @ORM\JoinColumn(name="receivedInvoiceId", referencedColumnName="invoiceId", nullable=true)
     */
    protected $receivedInvoice;


}