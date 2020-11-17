<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use Doctrine\Persistence\ObjectManager;

class ProfileFixture extends BaseFixture
{
    
    private static $libelle = [
        'ADMIN',
        'CM',
        'FORMATEUR',
        'APPRENANT'
    ];
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Profile::class, 4, function(Profile $profile, $count) use ($manager) {
            $profile->setLibelle($this->faker->randomElement(self::$libelle));
        });
        $manager->flush();
    }
}
