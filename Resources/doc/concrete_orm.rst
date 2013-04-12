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
    use Msi\StoreBundle\Entity\ProductTranslation as BaseProductTranslation;

    /**
     * @ORM\Entity
     */
    class ProductTranslation extends BaseProductTranslation
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

    namespace Acme\StoreBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Msi\StoreBundle\Entity\Order as BaseOrder;

    /**
     * @ORM\Entity
     */
    class Order extends BaseOrder
    {
        /**
         * @ORM\Column(type="integer")
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;

        /**
         * @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User", inversedBy="orders")
         */
        protected $user;

        /**
         * @ORM\OneToMany(targetEntity="Detail", mappedBy="order", cascade={"persist", "remove"})
         */
        protected $details;
    }

Category class
-------------

::

    <?php

    namespace Acme\StoreBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Gedmo\Mapping\Annotation as Gedmo;
    use Msi\StoreBundle\Entity\Category as BaseCategory;

    /**
     * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
     */
    class Category extends BaseCategory
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
         * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
         */
        protected $parent;

        /**
         * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
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
    use Msi\StoreBundle\Entity\CategoryTranslation as BaseCategoryTranslation;

    /**
     * @ORM\Entity
     */
    class CategoryTranslation extends BaseCategoryTranslation
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
