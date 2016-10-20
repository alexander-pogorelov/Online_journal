<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 01.10.2016
 * Time: 11:56
 */

namespace AppBundle\DataFixtures\ORM\LoadUsers;


use Application\Sonata\UserBundle\Entity\UserTeacher;
use Application\Sonata\UserBundle\Entity\UserMetodist;
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
        $user1 = new UserMetodist();
        $user1->setFirstname('Ivan');
        $user1->setLastname('Ivanov');
        $user1->setUsername('Ivan');
        $user1->setPlainPassword('ivan');
        $user1->setEmail('ivan@gmail.com');
        $user1->setRealRoles(['ROLE_STUDENT']);
        $user1->setEnabled(true);

        $manager->persist($user1);

        $user2 = new UserTeacher();
        $user2->setFirstname('Steven');
        $user2->setLastname('Howking');
        $user2->setUsername('Stev');
        $user2->setPlainPassword('stev');
        $user2->setEmail('stev@gmail.com');
        $user2->setRoles(['ROLE_TEACHER']); // Не работает эта роль!!!!
        $user2->setEnabled(true);

        $manager->persist($user2);

        $manager->flush();
    }
}