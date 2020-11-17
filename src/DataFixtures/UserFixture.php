<?php

namespace App\DataFixtures;

// use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\User;
use App\Entity\Profile;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder=$encoder;
    }

    
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(User::class, 50, function(User $user) {
            $user->setProfile($this->getReference(Profile::class.'_0'));
            $user->setUsername($this->faker->username);
            $user->setPassword($this->encoder->encodePassword($user, "password"));
            $user->setAvatar($faker->imageUrl(640,480,'cats'));
            $user->setNom($this->faker->name);
            $user->setPrenom($this->faker->firstname);
            $user->setEmail($this->faker->email);
            $user->setStatut(1);

        });
        $manager->flush();
    }
}
