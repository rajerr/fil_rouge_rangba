<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Promo;
use App\Entity\Groupe;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PromoFixtures extends Fixture
{   
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i= 0; $i < 3; $i++){
            $promo = new Promo();
            
            $promo->setLangue(('french'));
            $promo->setTitre($faker->title);
            $promo->setdescription($faker->text);
            $promo->setLieu($faker->country);
            $promo->setReferenceAgate($faker->sentence);
            $promo->setChoixFabrique("Sonatel Academy");
            $promo->setDateDebut($faker->datetime);
            $promo->setDateFin($faker->datetime);
            
            $groupe = new Groupe();

                $groupe->setNom("Groupe_Principal");
                $groupe->setDateCreation($faker->date);
                $manager->persist($groupe);

            $promo->addGroupe($groupe);

            $manager->persist($promo);
        }
        $manager->flush();
    }
}
