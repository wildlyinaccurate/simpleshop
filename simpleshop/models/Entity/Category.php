<?php

namespace Entity;

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
class Category extends TimestampedModel implements \DoctrineExtensions\NestedSet\Node {

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
	 * @var \Entity\Category
     * @ManyToOne(targetEntity="Category", inversedBy="child_categories")
	 * @JoinColumn(name="parent_category_id", referencedColumnName="id")
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
	 * @var int
	 * @Column(type="integer")
	 */
	protected $lft;

	/**
	 * @var int
	 * @Column(type="integer")
	 */
	protected $rgt;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

		$this->products = new \Doctrine\Common\Collections\ArrayCollection;
    }

	/** NestedSet methods */
	public function getLeftValue() { return $this->lft; }
	public function setLeftValue($lft) { $this->lft = $lft; }
	public function getRightValue() { return $this->rgt; }
	public function setRightValue($rgt) { $this->rgt = $rgt; }
	public function __toString() { return $this->title; }

	/**
	 * Set description
	 *
	 * @param   string  $description
	 * @return  Category
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * Get Description
	 *
	 * @return  string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Get Id
	 *
	 * @return  int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set image_id
	 *
	 * @param   int  $image_id
	 * @return  Category
	 */
	public function setImageId($image_id)
	{
		$this->image_id = $image_id;
		return $this;
	}

	/**
	 * Get ImageId
	 *
	 * @return  int
	 */
	public function getImageId()
	{
		return $this->image_id;
	}

	/**
	 * Add product
	 *
	 * @param	\Entity\Product	$product
	 * @return	Category
	 */
	public function addProduct($product)
	{
		$this->products[] = $product;
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
	 * @param   string  $slug
	 * @return  Category
	 */
	public function setSlug($slug)
	{
		$this->slug = $slug;
		return $this;
	}

	/**
	 * Get Slug
	 *
	 * @return  string
	 */
	public function getSlug()
	{
		return $this->slug;
	}

	/**
	 * Set the title and slug
	 *
	 * @param   string  $title
	 * @return  Category
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
	 * @return  string
	 */
	public function getTitle()
	{
		return $this->title;
	}

}