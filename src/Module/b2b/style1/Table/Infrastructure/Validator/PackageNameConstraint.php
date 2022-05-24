<?php

declare(strict_types=1);

namespace App\Module\b2b\style1\Table\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
final class PackageNameConstraint extends Constraint
{
    public string $message = 'Пакет с названием "{{ packageNameValue }}" уже существует';

    public function validatedBy(): string
    {
        return PackageNameValidator::class;
    }
}