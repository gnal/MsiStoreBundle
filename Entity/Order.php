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

    public function getId()
    {
        return $this->id;
    }
}
