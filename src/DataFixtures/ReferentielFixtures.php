<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Referentiel;
use App\Entity\GroupeCompetence;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ReferentielFixtures extends Fixture
{   
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $tab = ['Développement Web et mobile','Data Artisant', 'Referend Digital'];

        for($i= 0; $i< count($tab); $i++){
            $referentiel = new Referentiel();
            
            $referentiel->setLibelle($tab[$i]);
            $referentiel->setPresentation($faker->text);
            $referentiel->setProgramme($faker->imageUrl(640,480,'cats'));
            $referentiel->setcritereEvaluation($faker->text);
            $referentiel->setcritereAdmission($faker->text);
            
            for($j=0; $j< 2; $j++){
            $groupeComp = new GroupeCompetence();

                $groupeComp->setLibelle($faker->sentence);
                $groupeComp->setDescriptif($faker->text);
                $groupeComp->setStatut(true);
                $referentiel->addGroupeCompetence($groupeComp);
                 $manager->persist($groupeComp);
            }
            $manager->persist($referentiel);
        }
        $manager->flush();
    }
}
