<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 24.12.2016
 * Time: 14:20
 */

namespace Application\Sonata\UserBundle\Repository;


use Doctrine\ORM\EntityRepository;

class UserPupilRepository extends EntityRepository
{
    public function findAnyByParent($parentId) {

        $result = $this->findAllByParent($parentId);

        if($result === []) {
            return false;
        } else {
            return $result[0];
        }
    }

    public function findAllIdByParent($parentId) {

        $result = $this->findAllByParent($parentId);

        $idArray = array_map(function ($result) {
            return $result->getId();
        }, $result);

        return $idArray;
    }

    private function findAllByParent($parentId) {
        $qb = $this->createQueryBuilder('pupil');
        $query = $qb
            ->innerJoin('pupil.parents', 'parent')
            ->where($qb->expr()->eq('parent.id', $parentId))
            ->getQuery()
        ;
        $result = $query->getResult();

        return $result;
    }
}