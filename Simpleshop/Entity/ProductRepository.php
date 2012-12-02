<?php

namespace Simpleshop\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Product Repository
 *
 * @author  Joseph Wynn <joseph@wildlyinaccurate.com>
 */
class ProductRepository extends EntityRepository
{

    /**
     * Retrieve all products that haven't been assigned any categories.
     *
     * @return  \Doctrine\Common\Collections\ArrayCollection
     * @author  Joseph Wynn <joseph@wildlyinaccurate.com>
     */
    public function getProductsWithNoCategory()
    {
        return new ArrayCollection($this->_em->createQueryBuilder()
            ->select('p')
            ->from('Simpleshop\Entity\Product', 'p')
            ->leftJoin('p.categories', 'c')
            ->having('COUNT(c.id) = 0')
            ->groupBy('p.id')
            ->getQuery()
            ->getResult());
    }

}
