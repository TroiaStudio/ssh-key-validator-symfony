<?php

declare(strict_types = 1);

namespace TroiaStudio\SshKeyValidator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IsSshKeyValidator extends ConstraintValidator
{

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof IsSshKey) {
            throw new UnexpectedTypeException($constraint, IsSshKey::class);
        }

        if ($value === null || $value === '') {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $validator = KeyValidator::createAll();

        if ($validator->validate($value)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ string }}', $value)
            ->setCode(IsSshKey::NOT_SSH_KEY_ERROR)
            ->addViolation();
    }

}
