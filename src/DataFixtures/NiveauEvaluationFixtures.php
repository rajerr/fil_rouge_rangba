<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\NiveauEvaluation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\NiveauEvaluationFixtures;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class NiveauEvaluationFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) 
    {

        $this->encoder=$encoder;
    }

    
    public function load(ObjectManager $manager)
    {
 

        $faker = Factory::create('fr_FR');
        

        $tab = ['Niveau 1','Niveau 2','Niveau 3'];

        for($i = 0; $i <  count($tab); $i++){

            $niveauEvaluation = new NiveauEvaluation();
            $niveauEvaluation->setLibelle($tab[$i]);
            $niveauEvaluation->setStatut(1);
            $manager->persist($niveauEvaluation);
        }
        $manager->flush();
    }
}
