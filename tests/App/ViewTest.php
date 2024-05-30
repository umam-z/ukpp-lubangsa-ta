<?php 

namespace UmamZ\UkppLubangsa\App;

use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
    public function testRender()
    {
        View::render('/Home/login', [
            "title" =>"PHP Login Management"
        ]);

        $this->expectOutputRegex('[PHP Login Management]');
    }
}