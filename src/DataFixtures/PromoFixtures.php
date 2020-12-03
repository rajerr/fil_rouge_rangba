<?php

namespace App\DataFixtures;

use DateTime;
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
            $promo->setTitre($faker->sentence);
            $promo->setdescription($faker->text);
            $promo->setLieu($faker->country);
            $promo->setReferenceAgate($faker->sentence);
            $promo->setChoixFabrique("Sonatel Academy");
            $promo->setDateDebut(new \DateTime('now'));
            $promo->setDateFin(new \DateTime('2015-01-01'));
            $promo->setAvatar($faker->imageUrl(640,480,'cats'));

            
            $groupe = new Groupe();

                $groupe->setNom("Groupe_Principal".$i);
                $groupe->setDateCreation(new \DateTime('now'));
                $manager->persist($groupe);

            $promo->addGroupe($groupe); 

            $manager->persist($promo);
        }
        $manager->flush();
    }
}
