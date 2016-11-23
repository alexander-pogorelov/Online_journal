<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 22.11.2016
 * Time: 19:02
 */

namespace Application\Sonata\UserBundle\Repository;


use Doctrine\ORM\EntityRepository;

class LessonRepository extends EntityRepository
{
    public function findBySubjectAndGroup($subjectId, $groupId)
    {
        $qb = $this->createQueryBuilder('l');
        $query = $qb
            ->leftJoin('l.teacherSubject', 'ts')
            ->where($qb->expr()->eq('ts.subject', $subjectId))
            ->andWhere($qb->expr()->isNotNull('l.topic')) // запрашиваем только проведенные уроки
            ->andWhere($qb->expr()->eq('l.group', $groupId))
            ->getQuery()
        ;

        return $query->getResult();
    }
}