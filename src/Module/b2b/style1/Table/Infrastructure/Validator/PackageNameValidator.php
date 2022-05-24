<?php

declare(strict_types=1);

namespace App\Module\b2b\style1\Table\Validator;

use App\Module\b2b\style1\Table\Infrastructure\Repository\PackageRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\CallbackValidator;

final class PackageNameValidator extends CallbackValidator
{
    public function __construct(private PackageRepository $packageRepository)
    {
    }

    public function validate($name, Constraint $constraint): void
    {
        $samePackage = $this->packageRepository->findOneBy(['name' => $name]);
        if ($samePackage) {
            $this->context->buildViolation($constraint->message)
                ->setParameter("{{ packageNameValue }}", $name)
                ->addViolation();
        }
    }

}