<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProfileFixtures extends Fixture
{
    
    public const ADMIN_REFERENCE = "ADMIN";
    public const FORMATEUR_REFERENCE = "FORMATEUR";
    public const CM_REFERENCE = "CM";
    public const APPRENANT_REFERENCE = "APPRENANT";
    
    public function load(ObjectManager $manager)
    {
        $admin = new Profile();
        $admin->setLibelle(self::ADMIN_REFERENCE);
        $manager->persist($admin);

        $formateur = new Profile();
        $formateur->setLibelle(self::FORMATEUR_REFERENCE);
        $manager->persist($formateur);

        $cm = new Profile();
        $cm->setLibelle(self::CM_REFERENCE);
        $manager->persist($cm);

        $apprenant = new Profile();
        $apprenant->setLibelle(self::APPRENANT_REFERENCE);
        $manager->persist($apprenant);

        $this->addReference(self::ADMIN_REFERENCE, $admin);
        $this->addReference(self::FORMATEUR_REFERENCE, $formateur);
        $this->addReference(self::CM_REFERENCE, $cm);
        $this->addReference(self::APPRENANT_REFERENCE, $apprenant);

        $manager->flush();
    }
}
