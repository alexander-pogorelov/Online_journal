<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 17.12.2016
 * Time: 17:16
 */

namespace AppBundle\Validator;


class Validator
{
    public static function duplicateEmailValidator($object, $modelManager) {
        $UserClassWithEmails = [
            'Application\Sonata\UserBundle\Entity\UserAdmin',
            'Application\Sonata\UserBundle\Entity\UserParent',
            'Application\Sonata\UserBundle\Entity\UserMetodist',
            'Application\Sonata\UserBundle\Entity\UserTeacher',
        ];
        foreach ($UserClassWithEmails as $UserClassWithEmail) {
            $otherObject = $modelManager->findOneBy($UserClassWithEmail, array('email' => $object->getEmail()));
            if($otherObject) break;
        }
        if ($otherObject !== null && $otherObject !== $object) {
            return true;
        } else {
            return false;
        }
    }
}