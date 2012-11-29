<?php

namespace Simpleshop\Entity;

use DoctrineExtensions\NestedSet\MultipleRootNode;

/**
 * Category
 *
 * @Entity
 * @Table(name="simpleshop_category",
 * 		uniqueConstraints={
 * 			@uniqueConstraint(name="category_title_unique", columns={"title"}),
 * 			@uniqueConstraint(name="category_slug_unique", columns={"slug"})
 * 		},
 * 		indexes={
 * 			@Index(name="category_title_idx", columns={"title"}),
 * 			@Index(name="category_slug_idx", columns={"slug"})
 * 		}
 * )
 * @author	Joseph Wynn <joseph@wildlyinaccurate.com>
 */
class Category extends TimestampedModel implements MultipleRootNode
{

    /**
     * @var	int
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var	string
     * @Column(type="string", length=130, nullable=false)
     */
    protected $title;

    /**
     * @var	string
     * @Column(type="string", length=130, nullable=false)
     */
    protected $slug;

    /**
     * @var	string
     * @Column(type="text", length=2000, nullable=true)
     */
    protected $description;

    /**
     * Foreign key for a PyroCMS `files` record
     *
     * @var	int
     * @Column(type="integer", nullable=true)
     */
    protected $image_id;

    /**
     * @var	\Doctrine\Common\Collections\ArrayCollection
     * @ManyToMany(targetEntity="Product", mappedBy="categories", cascade={"persist"})
     * @JoinTable(name="product_categories")
     * @OrderBy({"title" = "ASC"})
     */
    protected $products;

    /**
     * Parent category
     *
     * @var \Simpleshop\Entity\Category
     * @ManyToOne(targetEntity="Category", inversedBy="child_categories")
     * @JoinColumn(name="parent_category_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $parent_category;

    /**
     * Child categories
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="Category", mappedBy="parent_category")
     * @OrderBy({"title" = "ASC"})
     */
    protected $child_categories;

    /**
     * @Column(type="integer")
     */
    private $lft;

    /**
     * @Column(type="integer")
     */
    private $rgt;

    /**
     * @Column(type="integer")
     */
    private $root;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->products = new \Doctrine\Common\Collections\ArrayCollection;
        $this->child_categories = new \Doctrine\Common\Collections\ArrayCollection;
    }

    /**
     * Set description
     *
     * @param  string   $description
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set image_id
     *
     * @param  int      $image_id
     * @return Category
     */
    public function setImageId($image_id)
    {
        $this->image_id = $image_id;

        return $this;
    }

    /**
     * Get ImageId
     *
     * @return int
     */
    public function getImageId()
    {
        return $this->image_id;
    }

    /**
     * Add product
     *
     * @param  Product  $product
     * @return Category
     */
    public function addProduct(Product $product)
    {
        if ( ! $this->products->contains($product)) {
            $this->products[] = $product;
            $product->addCategory($this);
        }

        return $this;
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set slug
     *
     * @param  string   $slug
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get Slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the title and slug
     *
     * @param  string   $title
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->slug = url_title($title, 'dash', TRUE);

        return $this;
    }

    /**
     * Get Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get ChildCategories
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getChildCategories()
    {
        return $this->child_categories;
    }

    /**
     * Set parent_category
     *
     * @param  \Simpleshop\Entity\Category $parent_category
     * @return Category
     */
    public function setParentCategory($parent_category)
    {
        $this->parent_category = $parent_category;

        return $this;
    }

    /**
     * Get ParentCategory
     *
     * @return \Simpleshop\Entity\Category
     */
    public function getParentCategory()
    {
        return $this->parent_category;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    public function getLeftValue()
    {
        return $this->lft;
    }

    public function setLeftValue($lft)
    {
        $this->lft = $lft;
    }

    public function getRightValue()
    {
        return $this->rgt;
    }

    public function setRightValue($rgt)
    {
        $this->rgt = $rgt;
    }

    public function getRootValue()
    {
        return $this->root;
    }

    public function setRootValue($root)
    {
        $this->root = $root;
    }

}
