<?php

namespace Entity;

/**
 * BaseModel Class
 *
 * @author	Joseph Wynn <joseph@wildlyinaccurate.com>
 */
class BaseModel {

	/**
	 * Constructor
	 *
	 * @access	public
	 */
	public function __construct()
	{
		// Nothing here yet!
	}

    /**
     * Convert the model to an array
     *
     * Please note that this method can be very slow and should be avoided where possible.
     *
     * @access  public
     * @param   bool    $ignore_collections
     * @return  array
     */
    public function toArray($ignore_collections = false)
    {
        $CI =& get_instance();
        $CI->load->helper('inflector');
        
        $this_as_array = array();

        foreach ($this as $property => $value)
        {
            $get_method = camelize('get_' . $property);

            // Use the getProperty() method if it exists
	        if (method_exists($this, $get_method))
	        {
                $value = $this->$get_method();
            }

            // If we find another instance of BaseModel, convert it to an array
            if ($value instanceof self)
            {
                $value = $value->toArray();
            }

	        // Ignore collections
	        if ($ignore_collections && $value instanceof \Doctrine\Common\Collections\Collection)
	        {
		        continue;
	        }

            $this_as_array[$property] = $value;
        }

        return $this_as_array;
    }
	
}