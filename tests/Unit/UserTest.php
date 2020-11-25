<?php

namespace App\Tests\Unit;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp():void
    {
        parent::setUp();

        $this->user = new User();
    }

    public function testGetUsername():void
    {
        $value ="myusername";
        
        $response = $this->user->setUsername($value);

        self::assertInstanceOf(User::class, $response);

        self::assertEquals($value, $this->user->getUsername());
    }

    public function testGetRole():void
    {
        $value =["ROLE_ADMIN", "ROLE_USER", "ROLE_USER", "ROLE_USER"];
        
        $response = $this->user->setRoles($value);

        self::assertInstanceOf(User::class, $response);

        self::assertContains("ROLE_ADMIN", $this->user->getRoles());
        self::assertContains("ROLE_FORMATEUR", $this->user->getRoles());
        self::assertContains("ROLE_CM", $this->user->getRoles());
        self::assertContains("ROLE_APPRENANT", $this->user->getRoles());
    }

}
