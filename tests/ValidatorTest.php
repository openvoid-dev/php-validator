<?php
use PHPUnit\Framework\TestCase;

use OpenVoid\Validator\Validators\Integer;
use OpenVoid\Validator\Validators\NotNull;
use OpenVoid\Validator\Validators\EmailValidator;
use OpenVoid\Validator\Validators\StringValidator;
use OpenVoid\Validator\Validators\ArrayValidator;

class ValidatorTest extends TestCase
{
    public function test_integer_validator()
    {
        $validator = new Integer();

        $this->assertTrue($validator->validate(25));
        $this->assertFalse($validator->validate('string'));
        $this->assertFalse($validator->validate([]));
    }

    public function test_not_null_validator()
    {
        $validator = new NotNull();

        $this->assertTrue($validator->validate('value'));
        $this->assertFalse($validator->validate(null));
    }

    public function test_email_validator()
    {
        $validator = new EmailValidator();

        $this->assertTrue($validator->validate('test@example.com'));
        $this->assertFalse($validator->validate('test@example,co'));
        $this->assertFalse($validator->validate('invalid-email'));
    }

    public function test_string_validator()
    {
        $validator = new StringValidator();

        $this->assertTrue($validator->validate(''));
        $this->assertTrue($validator->validate('string'));
        $this->assertFalse($validator->validate(123));
    }

    public function test_array_validator()
    {
        $validator = new ArrayValidator([new Integer(), new NotNull()]);
        $validator->not_empty();

        $this->assertTrue($validator->validate([1, 2, 3]));
        $this->assertFalse($validator->validate([1, 'string', 3]));
        $this->assertFalse($validator->validate([]));
    }
}
