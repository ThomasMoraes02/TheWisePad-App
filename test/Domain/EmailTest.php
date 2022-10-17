<?php 
namespace TheWisePad\Test\Domain;

use TheWisePad\Domain\Email;
use PHPUnit\Framework\TestCase;
use TheWisePad\Domain\Exceptions\EmailException;

class EmailTest extends TestCase
{
    public function test_email_valid()
    {
        $email = new Email("thomas@gmail.com");
        $this->assertEquals("thomas@gmail.com", $email);
    }

    public function test_email_invalid()
    {
        $this->expectException(EmailException::class);
        new Email("invalid e-mail");
    }
}