<?php

namespace AppBundle\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BankAccountRepository")
 * @ORM\Table(name="bank_accounts")
 */
class BankAccount
{
    /**
     * @ORM\Column(type="integer", name="bankAccountId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $bankAccountId;

    /**
     * @ORM\Column(type="string", length=128, nullable=false, name="bankName")
     * @Assert\NotBlank(message="Bank name cannot be null")
     * @Assert\Length(max=128, maxMessage="Bank name is too long. Max 128 chars")
     */
    protected $bankName;

    /**
     * @ORM\Column(type="string", length=64, nullable=false, name="owner")
     * @Assert\NotBlank(message="Account owner cannot be null")
     * @Assert\Length(max=64, maxMessage="Owner name is too long. Max 64 chars")
     */
    protected $owner;

    /**
     * @ORM\Column(type="string", nullable=false, length=2, name="country")
     * @Assert\NotBlank()
     * @Assert\Length(max=2, maxMessage="IBAN Country is too long. Max 2 chars")
     */
    protected $country;

    /**
     * @ORM\Column(type="string", nullable=false, length=2, name="checkIban")
     * @Assert\NotBlank()
     * @Assert\Length(max=2, maxMessage="IBAN Check is too long. Max 2 chars")
     */
    protected $check;

    /**
     * @ORM\Column(type="string", nullable=false, length=1, name="CIN")
     * @Assert\NotBlank()
     */
    protected $cin;

    /**
     * @ORM\Column(type="string", nullable=false, length=5, name="ABI")
     * @Assert\NotBlank()
     * @Assert\Length(max=5, maxMessage="IBAN ABI is too long. Max 5 chars")
     */
    protected $abi;

    /**
     * @ORM\Column(type="string", nullable=false, length=5, name="CAB")
     * @Assert\NotBlank()
     * @Assert\Length(max=5, maxMessage="IBAN CAB is too long. Max 5 chars")
     */
    protected $cab;

    /**
     * @ORM\Column(type="string", nullable=false, length=12, name="accountNumber")
     * @Assert\NotBlank()
     * @Assert\Length(max=12, maxMessage="IBAN Account Number is too long. Max 12 chars")
     */
    protected $accountNumber;

    /**
     * Get bankAccountId
     *
     * @return integer
     */
    public function getBankAccountId()
    {
        return $this->bankAccountId;
    }

    /**
     * Set bankName
     *
     * @param string $bankName
     *
     * @return BankAccount
     */
    public function setBankName($bankName)
    {
        $this->bankName = $bankName;

        return $this;
    }

    /**
     * Get bankName
     *
     * @return string
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * Set owner
     *
     * @param string $owner
     *
     * @return BankAccount
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return BankAccount
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set check
     *
     * @param string $check
     *
     * @return BankAccount
     */
    public function setCheck($check)
    {
        $this->check = $check;

        return $this;
    }

    /**
     * Get check
     *
     * @return string
     */
    public function getCheck()
    {
        return $this->check;
    }

    /**
     * Set cin
     *
     * @param string $cin
     *
     * @return BankAccount
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin
     *
     * @return string
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set abi
     *
     * @param string $abi
     *
     * @return BankAccount
     */
    public function setAbi($abi)
    {
        $this->abi = $abi;

        return $this;
    }

    /**
     * Get abi
     *
     * @return string
     */
    public function getAbi()
    {
        return $this->abi;
    }

    /**
     * Set cab
     *
     * @param string $cab
     *
     * @return BankAccount
     */
    public function setCab($cab)
    {
        $this->cab = $cab;

        return $this;
    }

    /**
     * Get cab
     *
     * @return string
     */
    public function getCab()
    {
        return $this->cab;
    }

    /**
     * Set accountNumber
     *
     * @param string $accountNumber
     *
     * @return BankAccount
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * Get accountNumber
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }
}
