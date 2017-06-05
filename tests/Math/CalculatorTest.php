<?php
namespace Math;

use PHPUnit\Framework\TestCase;  //if not working we can use PHPUnit_Framework_TestCase in the class extends

use Math\Calculator;  // this is equivalent to require_once("./src/Math/Calculator.php");

//require_once("./src/Math/Calculator.php");
//require_once("./tests/bootstrap.php"); // Register class autoloading

class CalculatorTest extends TestCase
{
    /**
     * @var \Math\Calculator
     */

    private $calculator;

    /*
     * Reinstantiate Calculater before each test
     */

    public function setUp()
    {
        $this->calculator = new Calculator();
    }


    public function testAdd()
    {
        $expected = 7;
        $actual = $this->calculator->add(2, 5);
        $this->assertEquals($expected, $actual);
    }

    public function testSubstract()
    {
        $expected = 2;
        $actual = $this->calculator->substract(5, 3);
        $this->assertEquals($expected, $actual);
    }

    public function testMultiply()
    {
        $expected = 20;
        $actual = $this->calculator->multiply(10, 2);
        $this->assertEquals($expected, $actual);
    }

    public function testDivide()
    {
        $expected = 15;
        $actual = $this->calculator->divide(45, 3);
        $this->assertEquals($expected, $actual);
    }

     /**
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionProducedWhileDividingByZero()
    {
        $this->calculator->divide(45, 0);
    }

    
}

?>
