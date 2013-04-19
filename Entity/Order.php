<?php

namespace Msi\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Msi\CmfBundle\Doctrine\Extension\Timestampable\TimestampableInterface;

/**
 * @ORM\MappedSuperclass
 */
abstract class Order implements TimestampableInterface
{
    use \Msi\CmfBundle\Doctrine\Extension\Timestampable\Traits\TimestampableEntity;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $ip;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $frozenAt;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    protected $shipping;

    /**
     * @ORM\Column(type="decimal", scale=3, nullable=true)
     */
    protected $gst;

    /**
     * @ORM\Column(type="decimal", scale=3, nullable=true)
     */
    protected $pst;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $ext;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $shippingCity;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $shippingAddress;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $shippingAddress2;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $shippingProvince;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $shippingCountry;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $shippingZip;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $billingCity;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $billingAddress;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $billingAddress2;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $billingProvince;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $billingCountry;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $billingZip;

    public function __construct()
    {
        $this->details = new ArrayCollection();
    }

    public function count()
    {
        $total = 0;
        foreach ($this->getDetails() as $detail) {
            $total += $detail->getQuantity();
        }

        return $total;
    }

    public function getSubtotal()
    {
        $this->checkFrozenAt();

        $total = 0;
        foreach ($this->getDetails() as $detail) {
            $total += $detail->getTotal();
        }

        return $total;
    }

    public function getGstTotal()
    {
        $this->checkFrozenAt();

        $total = 0;
        foreach ($this->getDetails() as $detail) {
            if ($detail->getTaxable()) {
                $total += $detail->getTotal() * $this->getGst();
            }
        }

        if ($this->shipping) {
            $total += $this->shipping * $this->getGst();
        }

        return $total;
    }

    public function getPstTotal()
    {
        $this->checkFrozenAt();

        $total = 0;
        foreach ($this->getDetails() as $detail) {
            if ($detail->getTaxable()) {
                $total += $detail->getTotal() * $this->getPst();
            }
        }

        if ($this->shipping) {
            $total += $this->shipping * $this->getPst();
        }

        return $total;
    }

    public function getTotal()
    {
        $this->checkFrozenAt();

        $subtotal = $this->getSubtotal();
        $pst = $this->getPst();
        $gst = $this->getGst();

        $total = $subtotal + $gst + $pst;

        return $total;
    }

    public function getShipping()
    {
        return $this->shipping;
    }

    public function setShipping($shipping)
    {
        $this->shipping = $shipping;

        return $this;
    }

    public function getGst()
    {
        return $this->gst;
    }

    public function setGst($gst)
    {
        $this->gst = $gst;

        return $this;
    }

    public function getPst()
    {
        return $this->pst;
    }

    public function setPst($pst)
    {
        $this->pst = $pst;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function getDetails()
    {
        return $this->details;
    }

    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFrozenAt()
    {
        return $this->frozenAt;
    }

    public function setFrozenAt($frozenAt)
    {
        $this->frozenAt = $frozenAt;

        return $this;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    public function getExt()
    {
        return $this->ext;
    }

    public function setExt($ext)
    {
        $this->ext = $ext;

        return $this;
    }

    public function getShippingCity()
    {
        return $this->shippingCity;
    }

    public function setShippingCity($shippingCity)
    {
        $this->shippingCity = $shippingCity;

        return $this;
    }

    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;

        return $this;
    }

    public function getShippingAddress2()
    {
        return $this->shippingAddress2;
    }

    public function setShippingAddress2($shippingAddress2)
    {
        $this->shippingAddress2 = $shippingAddress2;

        return $this;
    }

    public function getShippingProvince()
    {
        return $this->shippingProvince;
    }

    public function setShippingProvince($shippingProvince)
    {
        $this->shippingProvince = $shippingProvince;

        return $this;
    }

    public function getShippingCountry()
    {
        return $this->shippingCountry;
    }

    public function setShippingCountry($shippingCountry)
    {
        $this->shippingCountry = $shippingCountry;

        return $this;
    }

    public function getShippingZip()
    {
        return $this->shippingZip;
    }

    public function setShippingZip($shippingZip)
    {
        $this->shippingZip = $shippingZip;

        return $this;
    }

    public function getBillingCity()
    {
        return $this->billingCity;
    }

    public function setBillingCity($billingCity)
    {
        $this->billingCity = $billingCity;

        return $this;
    }

    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getBillingAddress2()
    {
        return $this->billingAddress2;
    }

    public function setBillingAddress2($billingAddress2)
    {
        $this->billingAddress2 = $billingAddress2;

        return $this;
    }

    public function getBillingProvince()
    {
        return $this->billingProvince;
    }

    public function setBillingProvince($billingProvince)
    {
        $this->billingProvince = $billingProvince;

        return $this;
    }

    public function getBillingCountry()
    {
        return $this->billingCountry;
    }

    public function setBillingCountry($billingCountry)
    {
        $this->billingCountry = $billingCountry;

        return $this;
    }

    public function getBillingZip()
    {
        return $this->billingZip;
    }

    public function setBillingZip($billingZip)
    {
        $this->billingZip = $billingZip;

        return $this;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    private function checkFrozenAt()
    {
        if ($this->frozenAt === null) {
            throw new \Exception('Order isn\'t frozen. Use the Caculator service instead.');
        }
    }
}
