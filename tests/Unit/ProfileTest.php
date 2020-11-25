<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;

class ProfileTest extends TestCase
{
    private Profile $profile;

    protected function setProfile():void
    {
        parent::setProfile();

        $this->profile = new Profile();
    }

    public function testGetLibelle():void
    {
        $value ="Myprofile";
        
        $response = $this->profile->setLibelle($value);

        self::assertInstanceOf(Profile::class, $response);

        self::assertEquals($value, $this->profile->getLIbelle());
        self::assertEquals($value, $this->profile->getStatut());
    }
}
