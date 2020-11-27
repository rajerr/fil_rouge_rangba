<?php

namespace App\DataFixtures;

use App\Entity\NiveauEvaluation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class NiveauEvaluationFixtures extends Fixture
{
    
    public const NIVEAU_1_REFERENCE = "NIVEAU_1";
    public const NIVEAU_2_REFERENCE = "NIVEAU_2";
    public const NIVEAU_3_REFERENCE = "NIVEAU_3";
    
    public function load(ObjectManager $manager)
    {
        
        $faker = Factory::create('fr_FR');

        $niveau = new NiveauEvaluation();

        $niveau->setLibelle(self::NIVEAU_1_REFERENCE);
        $niveau->setCritereEvaluaton($faker->text);
        $niveau->setGroupeAction($faker->text);
        $manager->persist($niveau);

        $niveau->setLibelle(self::NIVEAU_2_REFERENCE);
        $niveau->setCritereEvaluaton($faker->text);
        $niveau->setGroupeAction($faker->text);
        $manager->persist($niveau);

        $niveau->setLibelle(self::NIVEAU_3_REFERENCE);
        $niveau->setCritereEvaluaton($faker->text);
        $niveau->setGroupeAction($faker->text);
        $manager->persist($niveau);


        $this->addReference(self::NIVEAU_1_REFERENCE, $niveau);
        $this->addReference(self::NIVEAU_2_REFERENCE, $niveau);
        $this->addReference(self::NIVEAU_3_REFERENCE, $niveau);
        $manager->flush();
    }
}
