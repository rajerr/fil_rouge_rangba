<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ReferentielFixtures extends Fixture
{   
    public function load(ObjectManager $manager)
    {
        for($i= 0; $i<=3; $i++){
            $referentiel = new Referentiel();
            
        }
       
    }
}
