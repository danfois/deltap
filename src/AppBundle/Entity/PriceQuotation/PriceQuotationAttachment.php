<?php

namespace AppBundle\Entity\PriceQuotation;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PriceQuotationAttachmentRepository")
 * @ORM\Table(name="price_quotation_attachments")
 */
class PriceQuotationAttachment
{
    /**
     * @ORM\Column(type="integer", name="attachmentId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $attachmentId;

    /**
     * @ORM\Column(type="string", name="financial_flow")
     * @Assert\NotBlank(message="Devi caricare il file del flusso finanziario")
     */
    protected $financialFlow;

    /**
     * @ORM\Column(type="string", name="questionary")
     * @Assert\NotBlank(message="Devi caricare il file del questionario")
     */
    protected $questionary;

    /**
     * @ORM\Column(type="string", name="responsibility_declaration")
     * @Assert\NotBlank(message="Devi caricare il file della dichiarazione di responsabilità")
     */
    protected $responsibilityDeclaration;


    /**
     * Get attachmentId
     *
     * @return integer
     */
    public function getAttachmentId()
    {
        return $this->attachmentId;
    }

    /**
     * Set financialFlow
     *
     * @param string $financialFlow
     *
     * @return PriceQuotationAttachment
     */
    public function setFinancialFlow($financialFlow)
    {
        $this->financialFlow = $financialFlow;

        return $this;
    }

    /**
     * Get financialFlow
     *
     * @return string
     */
    public function getFinancialFlow()
    {
        return $this->financialFlow;
    }

    /**
     * Set questionary
     *
     * @param string $questionary
     *
     * @return PriceQuotationAttachment
     */
    public function setQuestionary($questionary)
    {
        $this->questionary = $questionary;

        return $this;
    }

    /**
     * Get questionary
     *
     * @return string
     */
    public function getQuestionary()
    {
        return $this->questionary;
    }

    /**
     * Set responsibilityDeclaration
     *
     * @param string $responsibilityDeclaration
     *
     * @return PriceQuotationAttachment
     */
    public function setResponsibilityDeclaration($responsibilityDeclaration)
    {
        $this->responsibilityDeclaration = $responsibilityDeclaration;

        return $this;
    }

    /**
     * Get responsibilityDeclaration
     *
     * @return string
     */
    public function getResponsibilityDeclaration()
    {
        return $this->responsibilityDeclaration;
    }
}
