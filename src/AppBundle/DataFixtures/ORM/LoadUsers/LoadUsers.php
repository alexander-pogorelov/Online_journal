<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 01.10.2016
 * Time: 11:56
 */

namespace AppBundle\DataFixtures\ORM\LoadUsers;


use Application\Sonata\UserBundle\Entity\User;
use Application\Sonata\UserBundle\Entity\UserPupil;
use Application\Sonata\UserBundle\Entity\UserTeacher;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUsers implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
        $user1 = new UserPupil();
        $user1->setFirstname('Вася');
        $user1->setLastname('Васильев');
        $user1->setUsername('Vasya');
        $user1->setPlainPassword('vasya');
        $user1->setEmail('vasya@gmail.com');
        $user1->setRealRoles(['ROLE_PUPIL']);
        $user1->setEnabled(true);

        $manager->persist($user1);

        $user2 = new UserTeacher();
        $user2->setFirstname('Петя');
        $user2->setLastname('Петров');
        $user2->setUsername('Petya');
        $user2->setPlainPassword('petya');
        $user2->setEmail('petya@gmail.com');
        $user2->setRoles(['ROLE_TEACHER']);
        $user2->setEnabled(true);

        $manager->persist($user2);

        $manager->flush();
    }
}