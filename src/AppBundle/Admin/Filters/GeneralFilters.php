<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 10.11.2016
 * Time: 15:04
 */

namespace AppBundle\Admin\Filters;


class GeneralFilters
{
    public static function getFullNameFilter($queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $queryBuilder->andWhere($queryBuilder->expr()->orX(
            $queryBuilder->expr()->like($alias.'.lastname', $queryBuilder->expr()->literal('%' . $value['value'] . '%')),
            $queryBuilder->expr()->like($alias.'.firstname', $queryBuilder->expr()->literal('%' . $value['value'] . '%')),
            $queryBuilder->expr()->like($alias.'.patronymic', $queryBuilder->expr()->literal('%' . $value['value'] . '%'))
        ));

        return true;
    }
}