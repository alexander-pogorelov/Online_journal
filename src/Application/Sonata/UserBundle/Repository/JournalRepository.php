<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 07.12.2016
 * Time: 22:57
 */

namespace Application\Sonata\UserBundle\Repository;


use Doctrine\ORM\EntityRepository;

class JournalRepository extends EntityRepository
{
    public function findAllByGroupAndBySubject($groupId, $subjectId) {

        $qb = $this->createQueryBuilder('j');
        $query = $qb
            ->innerJoin('j.lesson', 'l')
            ->innerJoin('l.teacherSubject', 'ts')
            ->where($qb->expr()->eq('l.group', $groupId))
            ->andWhere($qb->expr()->eq('ts.subject', $subjectId))
            ->getQuery()
        ;

        return $query->getResult();
    }
}