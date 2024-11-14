<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Symfony\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorService
{
    public function __construct(
        private readonly ValidatorInterface $validator,
    ) {
    }

    public function validate(mixed $value): array|null
    {
        $errors = $this->validator->validate($value);
        $errorArray = [];

        foreach ($errors as $error) {
            $errorArray[$error->getPropertyPath()] = $error->getMessage();
        }

        return count($errorArray) > 0 ? $errorArray : null;
    }
}