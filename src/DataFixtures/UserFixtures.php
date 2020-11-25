<?php

namespace App\DataFixtures;

use App\Entity\Cm;
use Faker\Factory;
use App\Entity\Admin;
use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\DataFixtures\ProfileFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) 
    {

        $this->encoder=$encoder;
    }

    
    public function load(ObjectManager $manager)
    {
 

        $faker = Factory::create('fr_FR');
        

        $tab = ['ADMIN','FORMATEUR','CM','APPRENANT'];

        for($i = 0; $i <  count($tab); $i++){

            for($j = 0; $j < 3; $j++ ){

                if($tab[$i]=='ADMIN'){
                    $user = new Admin();

                $user->setProfile($this->getReference(ProfileFixtures::ADMIN_REFERENCE));
                $user->setUsername('admin'.($j));

                
                }
                elseif($tab[$i]=='FORMATEUR'){
                    $user = new Formateur();

                $user->setProfile($this->getReference(ProfileFixtures::FORMATEUR_REFERENCE));
                $user->setUsername('formateur'.($j));


                }
                elseif($tab[$i]=='CM'){
                    $user = new Cm();

                $user->setProfile($this->getReference(ProfileFixtures:: CM_REFERENCE));
                $user->setUsername('cm'.($j));

                
                }
                else{ 
                    $user = new Apprenant();
                    $user->setProfile($this->getReference(ProfileFixtures::APPRENANT_REFERENCE));
                    $user->setUsername('apprenant'.($j));
                    $user->setGenre($faker->randomElement(['F','M']));

                }
            
            //$user->setUsername($faker->username);
            $user->setPassword($this->encoder->encodePassword($user, "password"));
            $user->setAvatar($faker->imageUrl(640,480,'cats'));
            $user->setNom($faker->lastName);
            $user->setPrenom($faker->firstname);
            $user->setEmail($faker->email);
            $user->setStatut(true);
            $user->setTelephone($faker->e164PhoneNumber);
            $manager->persist($user);
            }
            
        }
        $manager->flush();
    }
}
