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
        
        $response = $this->profile->setUsername($value);

        self::assertInstanceOf(User::class, $response);

        self::assertEquals($value, $this->profile->getUsername());
    }

}
