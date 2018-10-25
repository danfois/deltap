<?php

namespace AppBundle\Entity\PurchaseOrder;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="purchase_order_details")
 */
class PurchaseOrderDetail
{
    /**
     * @ORM\Column(type="integer", name="purchaseOrderDetailId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $purchaseOrderDetailId;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PurchaseOrder\PurchaseOrder", inversedBy="purchaseOrderDetails", cascade={"persist"})
     * @ORM\JoinColumn(name="purchaseOrderId", referencedColumnName="purchaseOrderId")
     */
    protected $purchaseOrder;

    /**
     * @ORM\Column(type="integer", nullable=false, name="quantity")
     * @Assert\NotBlank()
     */
    protected $quantity;

    /**
     * @ORM\Column(type="string", nullable=false, name="description")
     * @Assert\NotBlank()
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle\Vehicle")
     * @ORM\JoinColumn(name="vehicleId", referencedColumnName="vehicleId")
     */
    protected $vehicle;

    /**
     * Get purchaseOrderDetailId
     *
     * @return integer
     */
    public function getPurchaseOrderDetailId()
    {
        return $this->purchaseOrderDetailId;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return PurchaseOrderDetail
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return PurchaseOrderDetail
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set purchaseOrder
     *
     * @param \AppBundle\Entity\PurchaseOrder\PurchaseOrder $purchaseOrder
     *
     * @return PurchaseOrderDetail
     */
    public function setPurchaseOrder(\AppBundle\Entity\PurchaseOrder\PurchaseOrder $purchaseOrder = null)
    {
        $this->purchaseOrder = $purchaseOrder;

        return $this;
    }

    /**
     * Get purchaseOrder
     *
     * @return \AppBundle\Entity\PurchaseOrder\PurchaseOrder
     */
    public function getPurchaseOrder()
    {
        return $this->purchaseOrder;
    }

    /**
     * Set vehicle
     *
     * @param \AppBundle\Entity\Vehicle\Vehicle $vehicle
     *
     * @return PurchaseOrderDetail
     */
    public function setVehicle(\AppBundle\Entity\Vehicle\Vehicle $vehicle = null)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * Get vehicle
     *
     * @return \AppBundle\Entity\Vehicle\Vehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }
}
