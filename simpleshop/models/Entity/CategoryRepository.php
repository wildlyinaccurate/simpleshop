<?php

namespace Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 */
class CategoryRepository extends EntityRepository
{

	/**
	 * Retrieves only the title and ID of all categories. Used to generate
	 * a dropdown (select element) of categories.
	 *
	 * @return  array
	 */
	public function getForDropdown()
	{
		$query = $this->_em->createQuery('SELECT c.id, c.title FROM \Entity\Category c ORDER BY c.title ASC');
		$results = $query->getArrayResult();

		$categories = array();

		// Convert the result array to [id] => [title]
		foreach ($results as $result)
		{
			$categories[$result['id']] = $result['title'];
		}

		// Little bit of clean-up
		unset($results);

		// Return the id => title array
		return $categories;
	}

}