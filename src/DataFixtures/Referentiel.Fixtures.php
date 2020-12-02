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

        for($i= 0; $i<=count($tab); $i++){
            $referentiel = new Referentiel();
            
            $referentiel->setLibelle($tab[$i]);
            $referentiel->setPresentation($faker->text);
            $referentiel->setProgramme($faker->imageUrl(640,480,'file'));
            $referentiel->setcritereEvaluation($faker->text);
            $referentiel->setcritereAdmission($faker->text);
            
            $groupeRef = new GroupeCompetence();
            $groupeRef = getGroupeCompetence();

            for($i=0; $i<=2; $i++){
                $referentiel->addGroupeCompetence($groupeRef);
            }
            $manager->persist($referentiel);
        }
        $manager->flush();
    }
}
