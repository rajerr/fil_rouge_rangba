<?php

namespace App\DataFixtures;

use Lcobucci\JWT\Claim\Factory;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Doctrine\Bundle\FixturesBundle\Fixture;

abstract class BaseFixture extends Fixture
{


    // /** @var ObjectManager */
    private $manager;

    // /** @var Generator */
    protected $faker;

    abstract protected function loadData(ObjectManager $manager);
    
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create('fr_FR');
        $this->loadData($manager);
    }


    protected function createMany(string $className, int $count, callable $factory)
    {
        for ($i = 0; $i < $count; $i++) {
            $entity = new $className();
            $factory($entity, $i);
            $this->manager->persist($entity);
            // store for usage later as App\Entity\ClassName_#COUNT#
            $this->addReference($className . '_' . $i, $entity);
        }
    }
}
