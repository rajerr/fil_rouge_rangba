<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;

class ProfileTest extends TestCase
{
    private Profile $profile;

    protected function testProfile()
    {
        parent::testProfile();
        $this->profile = new Profile();
    }
}
