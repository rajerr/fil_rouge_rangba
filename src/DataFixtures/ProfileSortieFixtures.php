<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\ProfileSortie;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ProfileSortieFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileSortieFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) 
    {

        $this->encoder=$encoder;
    }

    
    public function load(ObjectManager $manager)
    {
 

        $faker = Factory::create('fr_FR');
        

        $tab = ['Frontend','Backend','Fullstack','Integrator'];

        for($i = 0; $i <  count($tab); $i++){

            $profileSortie = new ProfileSortie();
            $profileSortie->setLibelle($faker->$tab[$i]);
            $profileSortie->setStatut(1);
            $manager->persist($profileSortie);
        }
        $manager->flush();
    }
}
