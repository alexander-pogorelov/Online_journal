<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 24.11.2016
 * Time: 11:52
 */

namespace Application\Sonata\UserBundle\Repository;


use Doctrine\ORM\EntityRepository;

class GroupIteenRepository extends EntityRepository
{
    public function findByActual()
    {
        $now = new \DateTime();

        $qb = $this->createQueryBuilder('g');
        $query = $qb
            ->where($qb->expr()->orX(
                $qb->expr()->gte('g.expirationDate', ':now'),
                $qb->expr()->isNull('g.expirationDate')
            ))
            ->setParameter('now', $now, \Doctrine\DBAL\Types\Type::DATETIME)
            ->getQuery()
        ;

        return $query->getResult();
    }
}