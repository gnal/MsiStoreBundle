<?php

namespace Msi\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Msi\CmfBundle\Doctrine\Extension\Timestampable\TimestampableInterface;
use Msi\CmfBundle\Doctrine\Extension\Translatable\TranslatableInterface;

/**
 * @ORM\MappedSuperclass
 */
abstract class Product implements TimestampableInterface, TranslatableInterface
{
    use \Msi\CmfBundle\Doctrine\Extension\Translatable\Traits\TranslatableEntity;
    use \Msi\CmfBundle\Doctrine\Extension\Timestampable\Traits\TimestampableEntity;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $published;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $price;

    public function __construct()
    {
        $this->published = false;
        $this->translations = new ArrayCollection();
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getPublished()
    {
        return $this->published;
    }

    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->getTranslation()->getName();
    }
}
