Concrete entities for Doctrine ORM
==================================

The ORM implementation does not provide concrete entities.

Product class
-------------

::

    <?php

    namespace Acme\StoreBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Msi\StoreBundle\Entity\Product as BaseProduct;

    /**
     * @ORM\Entity
     */
    class Product extends BaseProduct
    {
        /**
         * @ORM\Column(type="integer")
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;

        /**
         * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
         */
        protected $category;

        /**
         * @ORM\OneToMany(targetEntity="ProductTranslation", mappedBy="object", cascade={"persist", "remove"})
         */
        protected $translations;
    }

ProductTranslation class
-------------

::

    <?php

    namespace Acme\StoreBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity
     */
    class ProductTranslation
    {
        /**
         * @ORM\Column(type="integer")
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;

        /**
         * @ORM\ManyToOne(targetEntity="Product", inversedBy="translations")
         */
        protected $object;
    }

Order class
-------------

::

    <?php

    namespace Acme\CmfBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Msi\CmfBundle\Entity\Page as BasePage;

    /**
     * @ORM\Entity
     */
    class Page extends BasePage
    {
        /**
         * @ORM\Column(type="integer")
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;

        /**
         * @ORM\ManyToMany(targetEntity="Block", mappedBy="pages")
         */
        protected $blocks;

        /**
         * @ORM\ManyToOne(targetEntity="Site")
         */
        protected $site;

        /**
         * @ORM\OneToMany(targetEntity="PageTranslation", mappedBy="object", cascade={"persist", "remove"})
         */
        protected $translations;
    }

OrderTranslation class
-------------

::

    <?php

    namespace Acme\CmfBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Msi\CmfBundle\Entity\PageTranslation as BasePageTranslation;

    /**
     * @ORM\Entity
     */
    class PageTranslation extends BasePageTranslation
    {
        /**
         * @ORM\Column(type="integer")
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;

        /**
         * @ORM\ManyToOne(targetEntity="Page", inversedBy="translations")
         */
        protected $object;
    }

Category class
-------------

::

    <?php

    namespace Acme\StoreBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Gedmo\Mapping\Annotation as Gedmo;

    /**
     * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
     */
    class Category
    {
        /**
         * @ORM\Column(type="integer")
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;

        /**
         * @Gedmo\TreeParent
         * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
         */
        protected $parent;

        /**
         * @ORM\OneToMany(targetEntity="Category", mappedBy="parent", cascade={"remove"})
         * @ORM\OrderBy({"lft" = "ASC"})
         */
        protected $children;

        /**
         * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
         */
        protected $products;

        /**
         * @ORM\OneToMany(targetEntity="CategoryTranslation", mappedBy="object", cascade={"persist", "remove"})
         */
        protected $translations;
    }

CategoryTranslation class
-------------

::

    <?php

    namespace Acme\StoreBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity
     */
    class CategoryTranslation
    {
        /**
         * @ORM\Column(type="integer")
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;

        /**
         * @ORM\ManyToOne(targetEntity="Category", inversedBy="translations")
         */
        protected $object;
    }

Configure your application::

    msi_store:
        product_class: Acme\StoreBundle\Entity\Product
        order_class: Acme\StoreBundle\Entity\Order
        category_class: Acme\StoreBundle\Entity\Category
