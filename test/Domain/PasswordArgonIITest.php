<?php 
namespace TheWisePad\Test\Domain;

use PHPUnit\Framework\TestCase;
use TheWisePad\Infraestructure\PasswordArgonII;

class PasswordArgonIITest extends TestCase
{
    public function test_password_valid()
    {
        $password = new PasswordArgonII();
        $encoded = $password->encoded("123456");

        $passwordVerify = $password->verify("123456", $encoded);

        $this->assertTrue($passwordVerify);
        $this->assertNotEmpty($encoded);
    }

    public function test_password_invalid()
    {
        $password = new PasswordArgonII();
        $encoded = $password->encoded("123456");

        $passwordVerify = $password->verify("123456789", $encoded);

        $this->assertFalse($passwordVerify);
    }
}