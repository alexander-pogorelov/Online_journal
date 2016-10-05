<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 01.10.2016
 * Time: 11:56
 */

namespace AppBundle\DataFixtures\ORM\LoadUsers;


use Application\Sonata\UserBundle\Entity\User;
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
        $user1 = new User();
        $user1->setFirstname('Вася');
        $user1->setLastname('Васильев');
        $user1->setUsername('Vasya');
        $user1->setPlainPassword('vasya');
        $user1->setEmail('vasya@gmail.com');
        $user1->setRealRoles(['ROLE_USER']);
        $user1->setEnabled(true);

        $manager->persist($user1);

        $user2 = new User();
        $user2->setFirstname('Петя');
        $user2->setLastname('Петров');
        $user2->setUsername('Petya');
        $user2->setPlainPassword('petya');
        $user2->setEmail('petya@gmail.com');
        $user2->setRoles(['ROLE_USER']); // Не работает эта роль!!!!
        $user2->setEnabled(true);

        $manager->persist($user2);

        $manager->flush();
    }
}