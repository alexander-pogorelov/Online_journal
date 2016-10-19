<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 01.10.2016
 * Time: 14:49
 */

namespace AppBundle\DataFixtures\ORM\LoadAdmins;


use Application\Sonata\UserBundle\Entity\UserAdmin;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAdmins implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
        $admin = new UserAdmin();
        $admin->setFirstname('John');
        $admin->setLastname('Silver');
        $admin->setUsername('admin');
        $admin->setPlainPassword('admin');
        $admin->setEmail('ics.price@gmail.com');
        $admin->setRealRoles(['ROLE_SUPER_ADMIN']);
        $admin->setEnabled(true);

        $manager->persist($admin);
        $manager->flush();
    }
}