<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 28.11.2016
 * Time: 13:10
 */

namespace Application\Sonata\UserBundle\Repository;


use Doctrine\ORM\EntityRepository;


class TeacherSubjectRepository extends EntityRepository
{
    public function findBySubjectByMaxId($subjectId)
    {
        $qb = $this->createQueryBuilder('ts');
        $query1 = $qb
            ->where($qb->expr()->eq('ts.subject', $subjectId))
            ->orderBy('ts.id', 'DESC')
        ;
        $query2 = $this->getEntityManager()->createQuery($query1)
            ->setMaxResults(1)
        ;
        $result = $query2->getResult();

        if ($result === []) {

            return false;
        }

        return $result[0];
    }

}