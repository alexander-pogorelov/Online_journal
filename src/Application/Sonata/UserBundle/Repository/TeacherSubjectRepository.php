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
        /*
        ПОЧЕМУ ЭТО НЕ РАБОТАЕТ?
        $qb = $this->createQueryBuilder('ts');
        $qb2 = $qb->getEntityManager()->createQueryBuilder();
        $subquery = $qb2
            ->select($qb->expr()->max('ts.id'))
            ->from('ApplicationSonataUserBundle:TeacherSubject', 'ts')
            ->where($qb->expr()->eq('ts.subject', $subjectId))
        ;
        $query = $qb
            ->where($qb->expr()->eq('ts.id', $subquery->getDQL()))
            ->getQuery()
        ;
        return $query->getResult();
        */

        $qb = $this->createQueryBuilder('ts');
        $query1 = $qb
            ->where($qb->expr()->eq('ts.subject', $subjectId))
            ->orderBy('ts.id', 'DESC')
        ;
        $query2 = $this->getEntityManager()->createQuery($query1)
            ->setMaxResults(1)
        ;

        return $query2->getResult();
    }

}