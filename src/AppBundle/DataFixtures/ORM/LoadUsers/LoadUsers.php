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
use Application\Sonata\UserBundle\Entity\User;
use Application\Sonata\UserBundle\Entity\UserParent;
use Application\Sonata\UserBundle\Entity\UserPupil;
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

        $user3 = new UserMetodist();
        $user3->setFirstname('Иван');
        $user3->setLastname('Иванов');
        $user3->setUsername('Vanya');
        $user3->setPlainPassword('vanya');
        $user3->setEmail('vanya@gmail.com');
        $user3->setRoles(['ROLE_METODIST']);
        $user3->setEnabled(true);

        $manager->persist($user3);

        $user4 = new UserParent();
        $user4->setFirstname('Елена');
        $user4->setLastname('Иванова');
        $user4->setUsername('Elena');
        $user4->setPlainPassword('elena');
        $user4->setEmail('elena@gmail.com');
        $user4->setRoles(['ROLE_PARENT']);
        $user4->setEnabled(true);

        $manager->persist($user4);

        $user5 = new UserParent();
        $user5->setFirstname('Федор');
        $user5->setLastname('Федоров');
        $user5->setUsername('Fedor');
        $user5->setPlainPassword('fedor');
        $user5->setEmail('fedor@gmail.com');
        $user5->setRoles(['ROLE_PARENT']);
        $user5->setEnabled(true);

        $manager->persist($user5);

        $user1 = new UserParent();
        $user1->setFirstname('Вася');
        $user1->setLastname('Васильев');
        $user1->setUsername('Vasya');
        $user1->setPlainPassword('vasya');
        $user1->setEmail('vasya@gmail.com');
        $user1->setRealRoles(['ROLE_PARENT']);
        $user1->setEnabled(true);

        $manager->persist($user1);


        $manager->flush();

    }

}