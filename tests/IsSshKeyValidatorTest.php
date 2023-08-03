<?php

declare(strict_types = 1);

namespace Tests;

use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use TroiaStudio\SshKeyValidator\IsSshKey;
use TroiaStudio\SshKeyValidator\IsSshKeyValidator;

class IsSshKeyValidatorTest extends ConstraintValidatorTestCase
{

    public function testNullIsValid(): void
    {
        $this->validator->validate(null, new IsSshKey());

        $this->assertNoViolation();
    }

    public function testBlankIsValid(): void
    {
        $this->validator->validate('', new IsSshKey());

        $this->assertNoViolation();
    }

    public function testKeyIsValid(): void
    {
        $this->validator->validate('ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAINCqSM/QRXfw4xbJo+DIW4k9Ehks9hpxMyN/SoFvJHNZ test ed25519', new IsSshKey());

        $this->assertNoViolation();
    }

    public function testKeyIsInValid(): void
    {
        $key = 'sshed25519 AAAAC3NzaC1lZDI1NTE5AAAAINCqSM/QRXfw4xbJo+DIW4k9Ehks9hpxMyN/SoFvJHNZ test ed25519';
        $isSshKey = new IsSshKey();
        $this->validator->validate($key, $isSshKey);

        $this->buildViolation($isSshKey->message)
            ->setParameter('{{ string }}', $key)
            ->setCode(IsSshKey::NOT_SSH_KEY_ERROR)
            ->assertRaised();
    }

    protected function createValidator(): IsSshKeyValidator
    {
        return new IsSshKeyValidator();
    }

}
