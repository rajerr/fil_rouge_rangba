<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\GroupeCompetence;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PromoFixtures extends Fixture
{   
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i= 0; $i < 3; $i++){
            $promo = new Promo();
            
            $promo->setLibelle("Promo".[$i]);
            $promo->setLangue($faker->language);
            $promo->setLangue($faker->title);
            $promo->setdescription($faker->text);
            $promo->setLieu($faker->country);
            $promo->setReferenceAgate($faker->sentence);
            $promo->setChoixFabrique("Sonatel Academy");
            $promo->setDateDebut($faker->date);
            $promo->setDateFin($faker->date);
            
            $groupe = new Groupe();

                $groupe->setNom();
                $groupe->setDateCreation($faker->date);

                $groupe->setNom();
                $groupe->setNom();
                 $manager->persist($groupeRef);

            $manager->persist($promo);
        }
        $manager->flush();
    }
}
