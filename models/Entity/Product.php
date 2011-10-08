<?php

namespace Entity;

/**
 * Product
 *
 * @Entity
 * @Table(name="simpleshop_product",
 * 		uniqueConstraints={
 * 			@uniqueConstraint(name="product_title_unique", columns={"title"}),
 * 			@uniqueConstraint(name="product_slug_unique", columns={"slug"})
 * 		},
 * 		indexes={
 * 			@Index(name="product_title_idx", columns={"title"}),
 * 			@Index(name="product_slug_idx", columns={"slug"})
 * 		}
 * )
 * @author	Joseph Wynn <joseph@wildlyinaccurate.com>
 */
class Product extends TimestampedModel {

	/**
	 * @var	int
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="IDENTITY")
	 */
	protected $id;

	/**
	 * @var	string
	 * @Column(type="string", length=255, nullable=false)
	 */
	protected $title;

	/**
	 * @var	string
	 * @Column(type="string", length=255, nullable=false)
	 */
	protected $slug;

	/**
	 * @var	string
	 * @Column(type="text", length=2000, nullable=true)
	 */
	protected $description;

	/**
	 * @var float
	 * @Column(type="decimal", precision=12, scale=2, nullable=false)
	 */
	protected $price;

	/**
	 * @var int
	 * @Column(type="integer", nullable=false)
	 */
	protected $stock;

	/**
	 * @var bool
	 * @Column(type="boolean", nullable=false)
	 */
	protected $unlimited_stock;

	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection
	 * @ManyToMany(targetEntity="Category", inversedBy="products", cascade={"persist"})
	 * @JoinTable(name="product_categories")
	 */
	protected $categories;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

		$this->categories = new \Doctrine\Common\Collections\ArrayCollection;
    }

	/**
	 * Add a category
	 *
	 * @param   \Entity\Category
	 * @return  Product
	 */
	public function addCategory($category)
	{
		$this->categories[] = $category;
		return $this;
	}

	/**
	 * Get Categories
	 *
	 * @return  \Doctrine\Common\Collections\ArrayCollection
	 */
	public function getCategories()
	{
		return $this->categories;
	}

	/**
	 * Set description
	 *
	 * @param   string  $description
	 * @return  Product
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
	 * Set price
	 *
	 * @param   float  $price
	 * @return  Product
	 */
	public function setPrice($price)
	{
		$this->price = $price;
		return $this;
	}

	/**
	 * Get Price
	 *
	 * @return  float
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * Set slug
	 *
	 * @param   string  $slug
	 * @return  Product
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
	 * Set stock
	 *
	 * @param   int  $stock
	 * @return  Product
	 */
	public function setStock($stock)
	{
		$this->stock = $stock;
		return $this;
	}

	/**
	 * Get Stock
	 *
	 * @return  int
	 */
	public function getStock()
	{
		return $this->stock;
	}

	/**
	 * Set title
	 *
	 * @param   string  $title
	 * @return  Product
	 */
	public function setTitle($title)
	{
		$this->title = $title;
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

	/**
	 * Set unlimited_stock
	 *
	 * @param   boolean  $unlimited_stock
	 * @return  Product
	 */
	public function setUnlimitedStock($unlimited_stock)
	{
		$this->unlimited_stock = $unlimited_stock;
		return $this;
	}

	/**
	 * Get UnlimitedStock
	 *
	 * @return  boolean
	 */
	public function getUnlimitedStock()
	{
		return $this->unlimited_stock;
	}

}