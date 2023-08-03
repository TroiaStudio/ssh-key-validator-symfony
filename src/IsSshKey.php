<?php

declare(strict_types = 1);

namespace TroiaStudio\SshKeyValidator;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
class IsSshKey extends Constraint
{

    public const NOT_SSH_KEY_ERROR = '99a2ab41-3180-4c25-821b-ef403acd1c2d';

    protected const ERROR_NAMES = [
        self::NOT_SSH_KEY_ERROR => 'NOT_SSH_KEY_ERROR',
    ];

    public string $message = 'This value should be valid ssh key.';

    public function __construct(mixed $options = null, ?string $message = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct($options ?? [], $groups, $payload);

        $this->message = $message ?? $this->message;
    }

}
