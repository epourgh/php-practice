<?php

use App\Test;

class TestTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function unitTesting()
    {
        $test = new Test;
        $result = $test->reverseString('12345');

        $this->assertEquals('54321', $result);
    }

    /** @test */
    public function functionalIntegrationTesting()
    {

        $test = new Test;
        
        $sequence = [
            'enter home page',
            'click to login page'
        ];

        $array = $test->websiteNavigation($sequence);
        $recentActivity = $array[0];

        $this->assertEquals('/login.php', $recentActivity);
    }
}

