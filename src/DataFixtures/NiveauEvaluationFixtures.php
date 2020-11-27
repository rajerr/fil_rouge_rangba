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
        
        // $admin = new NiveauEvaluation();
        // $admin->setLibelle(self::NIVEAU_1_REFERENCE);
        // $admin->setStatut(true);
        // $manager->persist($niveau1);

        // $formateur = new NiveauEvaluation();
        // $formateur->setLibelle(self::NIVEAU_2_REFERENCE);
        // $formateur->setStatut(true);
        // $manager->persist($niveau2);

        // $cm = new NiveauEvaluation();
        // $cm->setLibelle(self::NIVEAU_3_REFERENCE);
        // $cm->setStatut(true);
        // $manager->persist($niveau3);


        // $this->addReference(self::NIVEAU_1_REFERENCE, $niveau1);
        // $this->addReference(self::NIVEAU_2_REFERENCE, $niveau2);
        // $this->addReference(self::NIVEAU_3_REFERENCE, $niveau3);
        // $manager->flush();
    }
}
