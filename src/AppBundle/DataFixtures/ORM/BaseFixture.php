<?php
/**
 * Created by PhpStorm.
 * User: Ксения
 * Date: 29.09.2016
 * Time: 13:38
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;



class BaseFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
    }

    public function getOrder()
    {
        // TODO: Implement getOrder() method.
    }

    public function setContainer(ContainerInterface $container = null)
    {
        // TODO: Implement setContainer() method.
    }
}