<?php

namespace AppBundle\Entity\Invoice;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="invoice_details")
 */
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



    /**
     * Get invoiceDetail
     *
     * @return integer
     */
    public function getInvoiceDetail()
    {
        return $this->invoiceDetail;
    }

    /**
     * Set vat
     *
     * @param string $vat
     *
     * @return InvoiceDetail
     */
    public function setVat($vat)
    {
        $this->vat = $vat;

        return $this;
    }

    /**
     * Get vat
     *
     * @return string
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * Set totTaxExc
     *
     * @param string $totTaxExc
     *
     * @return InvoiceDetail
     */
    public function setTotTaxExc($totTaxExc)
    {
        $this->totTaxExc = $totTaxExc;

        return $this;
    }

    /**
     * Get totTaxExc
     *
     * @return string
     */
    public function getTotTaxExc()
    {
        return $this->totTaxExc;
    }

    /**
     * Set totTaxInc
     *
     * @param string $totTaxInc
     *
     * @return InvoiceDetail
     */
    public function setTotTaxInc($totTaxInc)
    {
        $this->totTaxInc = $totTaxInc;

        return $this;
    }

    /**
     * Get totTaxInc
     *
     * @return string
     */
    public function getTotTaxInc()
    {
        return $this->totTaxInc;
    }

    /**
     * Set productCode
     *
     * @param string $productCode
     *
     * @return InvoiceDetail
     */
    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;

        return $this;
    }

    /**
     * Get productCode
     *
     * @return string
     */
    public function getProductCode()
    {
        return $this->productCode;
    }

    /**
     * Set productName
     *
     * @param string $productName
     *
     * @return InvoiceDetail
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get productName
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set issuedInvoice
     *
     * @param \AppBundle\Entity\Invoice\IssuedInvoice $issuedInvoice
     *
     * @return InvoiceDetail
     */
    public function setIssuedInvoice(\AppBundle\Entity\Invoice\IssuedInvoice $issuedInvoice = null)
    {
        $this->issuedInvoice = $issuedInvoice;

        return $this;
    }

    /**
     * Get issuedInvoice
     *
     * @return \AppBundle\Entity\Invoice\IssuedInvoice
     */
    public function getIssuedInvoice()
    {
        return $this->issuedInvoice;
    }

    /**
     * Set receivedInvoice
     *
     * @param \AppBundle\Entity\Invoice\ReceivedInvoice $receivedInvoice
     *
     * @return InvoiceDetail
     */
    public function setReceivedInvoice(\AppBundle\Entity\Invoice\ReceivedInvoice $receivedInvoice = null)
    {
        $this->receivedInvoice = $receivedInvoice;

        return $this;
    }

    /**
     * Get receivedInvoice
     *
     * @return \AppBundle\Entity\Invoice\ReceivedInvoice
     */
    public function getReceivedInvoice()
    {
        return $this->receivedInvoice;
    }
}
