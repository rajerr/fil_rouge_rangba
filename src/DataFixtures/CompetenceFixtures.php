<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Competence;
use App\Entity\NiveauEvaluation;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\CompetenceFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CompetenceFixtures extends Fixture
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
    for($i=0; $i<= 5; $i++){
        $competence = new Competence();
        $competence->setLibelle($faker->sentence);
        $competence->setDescriptif($faker->text);
        $competence->setStatut(true);
        $manager->persist($competence);
    }

    for($i=0; $i < count($tab) ; $i++)
    { 
            $niveau= new NiveauEvaluation();
            $niveau->setLibelle($tab[$i])
                   ->setCritereEvaluaton($faker->text)
                   ->setGroupeAction($faker->text);
            $manager->persist($niveau);
        }
        $manager->persist($competence);
        
        $manager->flush();
    }
}
