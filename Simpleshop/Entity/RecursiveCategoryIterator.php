<?php

namespace Simpleshop\Entity;

/**
 * Recursive Category Iterator
 *
 * Recursively iterates over an array of \Simpleshop\Entity\Category objects.
 */
class RecursiveCategoryIterator implements \RecursiveIterator
{

    private $_data;

    private $_postition = 0;

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct(\Doctrine\Common\Collections\Collection $data)
    {
        $this->_data = $data;
    }

    /**
     * Returns true if an iterator can be created for the current entry.
     *
     * @return bool
     */
    public function hasChildren()
    {
        return ( ! $this->_data->current()->getChildCategories()->isEmpty());
    }

    /**
     * Returns an iterator for the current entry.
     *
     * @return RecursiveIterator An iterator for the current entry.
     */
    public function getChildren()
    {
        return new RecursiveCategoryIterator($this->_data->current()->getChildCategories());
    }

    /**
     * Return the current element
     *
     * @return mixed
     */
    public function current()
    {
        return $this->_data->current();
    }

    /**
     * Move forward to next element
     *
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->_data->next();
    }

    /**
     * Return the key of the current element
     *
     * @return scalar|0
     */
    public function key()
    {
        return $this->_data->key();
    }

    /**
     * Checks if current position is valid
     *
     * @return bool
     */
    public function valid()
    {
        return $this->_data->current() instanceof \Simpleshop\Entity\Category;
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->_data->first();
    }

}
