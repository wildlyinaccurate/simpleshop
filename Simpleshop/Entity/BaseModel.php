<?php

namespace Simpleshop\Entity;

/**
 * Base Model Class
 *
 * @MappedSuperclass
 * @HasLifecycleCallbacks
 * @author	Joseph Wynn <joseph@wildlyinaccurate.com>
 */
class BaseModel
{

    /**
     * @var	\DateTime
     *
     * @column(type="datetime")
     */
    protected $created_date;

    /**
     * @var	\DateTime
     *
     * @column(type="datetime", nullable=true)
     */
    protected $modified_date;

    /**
     * Set created_date to the current date/time before persisting an object
     *
     * @PrePersist
     * @return null
     */
    public function setCreatedDate()
    {
        $this->created_date = new \DateTime;
    }

    /**
     * Get created_date
     *
     * @return DateTime
     */
    public function getCreatedDate()
    {
        return $this->created_date;
    }

    /**
     * Set created_date to the current date/time before persisting an object
     *
     * @PreUpdate
     * @return null
     */
    public function setModifiedDate()
    {
        $this->modified_date = new \DateTime;
    }

    /**
     * Get modified_date
     *
     * @return DateTime
     */
    public function getModifiedDate()
    {
        return $this->modified_date;
    }

}
