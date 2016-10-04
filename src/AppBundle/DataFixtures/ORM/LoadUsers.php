<?php
/**
 * Created by PhpStorm.
 * User: Ксения
 * Date: 29.09.2016
 * Time: 13:33
 */

namespace AppBundle\DataFixtures\ORM;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;


class LoadUsers extends BaseFixture
{
    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@test.com');
        $admin->setEmailCanonical('admin@test.com');
        $admin->setPlainPassword('admin');
        $admin->setRoles(['ROLE_SUPER_ADMIN']);
        $admin->setEnabled(true);

        $manager->persist($admin);
        $manager->flush();
    }
}