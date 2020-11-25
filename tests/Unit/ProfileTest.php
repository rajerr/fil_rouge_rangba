<?php

namespace App\Tests\Unit;

use App\Entity\Profile;
use PHPUnit\Framework\TestCase;

class ProfileTest extends TestCase
{
    private Profile $profile;

    protected function setUp():void
    {
        parent::setUp();

        $this->profile = new Profile();
    }

    public function testGetLibelle():void
    {
        $value ="Myprofile";
        
        $response = $this->profile->setLibelle($value);

        self::assertInstanceOf(Profile::class, $response);

        self::assertEquals($value, $this->profile->getLIbelle());
    }

    public function testGetStatut():void
    {
        $value =true;
        
        $response = $this->profile->setStatut($value);

        self::assertInstanceOf(Profile::class, $response);

        self::assertEquals($value, $this->profile->getStatut());
    }   
}
