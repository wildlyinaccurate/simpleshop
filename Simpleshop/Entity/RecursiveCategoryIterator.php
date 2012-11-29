<?php

namespace Simpleshop\Entity;

/**
 * Recursive Category Iterator
 *
 * Recursively iterates over an array of \Simpleshop\Entity\Category objects.
 */
class RecursiveCategoryIterator implements \RecursiveIterator {

	/** @var \Doctrine\Common\Collections\Collection */
	private $_data;
	private $_postition = 0;

	/**
	 * Constructor
	 *
	 * @param   array   $data
	 */
	public function __construct(\Doctrine\Common\Collections\Collection $data)
	{
		$this->_data = $data;
	}

	/**
	 * Returns if an iterator can be created fot the current entry.
	 * @link http://php.net/manual/en/recursiveiterator.haschildren.php
	 * @return bool true if the current entry can be iterated over, otherwise returns false.
	 */
	public function hasChildren()
	{
		/** @var $current_category \Simpleshop\Entity\Category */
		$current_category = $this->_data->current();

		return ( ! $current_category->getChildCategories()->isEmpty());
	}

	/**
	 * Returns an iterator for the current entry.
	 * @link http://php.net/manual/en/recursiveiterator.getchildren.php
	 * @return RecursiveIterator An iterator for the current entry.
	 */
	public function getChildren()
	{
		/** @var $current_category \Simpleshop\Entity\Category */
		$current_category = $this->_data->current();

		return new RecursiveCategoryIterator($current_category->getChildCategories());
	}

	/**
	 * Return the current element
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 */
	public function current()
	{
		return $this->_data->current();
	}

	/**
	 * Move forward to next element
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void Any returned value is ignored.
	 */
	public function next()
	{
		$this->_data->next();
	}

	/**
	 * Return the key of the current element
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return scalar scalar on success, integer
	 * 0 on failure.
	 */
	public function key()
	{
		return $this->_data->key();
	}

	/**
	 * Checks if current position is valid
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 */
	public function valid()
	{
		return $this->_data->current() instanceof \Simpleshop\Entity\Category;
	}

	/**
	 * Rewind the Iterator to the first element
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 */
	public function rewind()
	{
		$this->_data->first();
	}

}

/* End of file RecursiveCategoryIterator.php */
