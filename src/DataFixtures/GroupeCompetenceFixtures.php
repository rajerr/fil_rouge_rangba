<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Competence;
use App\Entity\GroupeCompetence;
use App\Entity\NiveauEvaluation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\GroupeCompetenceFixtures;

class GroupeCompetenceFixtures extends Fixture
{

    
    public function load(ObjectManager $manager)
    {
 

        $faker = Factory::create('fr_FR');
        
        $niveaux = ['Niveau_1','Niveau_2','Niveau_3'];
        $competences = ['Creer une BD','Connexion user','accès aux données', 'generer token'];
        // $groupeCompetences = ['Développer le back-end d’une application web','Développer le front-end d’une application web','faire le prototypage d’une application web'];
       

        for($i=0; $i<= 5; $i++){

            $groupeComp = new GroupeCompetence();
            $groupeComp->setLibelle($faker->sentence);
            $groupeComp->setDescriptif($faker->text);
            $groupeComp->setStatut(true);


            for($j=0; $j < count($competences); $j++){

                $competence = new Competence();
                $competence->setLibelle($competences[$j]);
                $competence->setDescriptif($faker->text);
                $competence->setStatut(true);

                for($k=0; $k < count($niveaux); $k++){

                    $niveau= new NiveauEvaluation();
                    $niveau->setLibelle($niveaux[$k]);
                    $niveau->setCritereEvaluaton($faker->text);
                    $niveau->setGroupeAction($faker->text);
                $manager->persist($niveau);
                $competence->addNiveauEvaluation($niveau);
                }
                $manager->persist($competence);
            }

            $groupeComp->addCompetence($competence);
            // dd($groupeComp);
            $manager->persist($groupeComp);

        }
        $manager->flush();
    }
}
