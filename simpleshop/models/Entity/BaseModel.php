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
     * @return  array
     */
    public function toArray()
    {
        $CI =& get_instance();
        $CI->load->helper('inflector');
        
        $this_as_array = array();

        foreach($this as $property => $value)
        {
            $get_method = camelize('get_' . $property);

            // Try and use the getProperty() method
            try
            {
                $value = $this->$get_method();
            }
            catch (Exception $e)
            {
                // Just use the property as it is
            }

            // If we find another instance of BaseModel, convert it to an array
            if ($value instanceof self)
            {
                $value = $value->toArray();
            }

            $this_as_array[$property] = $value;
        }

        return $this_as_array;
    }
	
}