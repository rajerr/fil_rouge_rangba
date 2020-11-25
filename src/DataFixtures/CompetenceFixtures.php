<?php

namespace App\DataFixtures;

use Faker\Factory;
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

        $competence = new Competence();
            $competence->setLibelle($faker->libelle);
            $user->setDescriptif($faker->comment);
            $user->setStatut(true);
            $manager->persist($competence);

            for ($i=1; $i <= count($tab) ; $i++) { 
                $niveau= new NiveauEvaluation();
                $niveau->setLibelle($tab[$i])
                       ->setCritereEvaluaton($tab_compet["niveauEvaluations"][$i]["critereEvaluation"])
                       ->setGroupeAction($tab_compet["niveauEvaluations"][$i]["critereEvaluation"]);
                $manager->persist($niveau);
                $new_compet->addNiveauEvaluation($niveau);
            }
            $manager->persist($new_compet);
        $manager->flush();
    }
}
