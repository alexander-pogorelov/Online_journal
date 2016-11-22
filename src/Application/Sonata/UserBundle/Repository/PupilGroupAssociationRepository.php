<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 22.11.2016
 * Time: 23:10
 */

namespace Application\Sonata\UserBundle\Repository;


use Doctrine\ORM\EntityRepository;

class PupilGroupAssociationRepository extends EntityRepository
{
    public function findAllJournals($groupId)
    {
        $qb = $this->createQueryBuilder('pga');
        $query = $qb
            ->leftJoin('pga.journal', 'j')
            ->leftJoin('j.lesson', 'l')
            ->addSelect('j')
            ->addSelect('l')
            ->where($qb->expr()->eq('pga.group', $groupId))
            ->getQuery()
        ;

        return $query->getResult();
    }
}