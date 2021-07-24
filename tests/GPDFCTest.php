<?php
use EmmKwami\GPDFC\GPDFC;
use PHPUnit\FrameWork\TestCase;

class GPDFCTest extends TestCase
{
    public function test_validateSetUp() : void
    {
        $PDF = new GPDFC('test-file.pdf','output-test-file.pdf');

        $this->assertTrue($PDF->_validateSetUp());

    }


}
