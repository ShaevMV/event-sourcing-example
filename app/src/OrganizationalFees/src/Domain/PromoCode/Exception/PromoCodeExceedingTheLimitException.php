<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\PromoCode\Exception;

use DomainException;

class PromoCodeExceedingTheLimitException extends DomainException
{
    public function __construct(string $promoCodeTitle)
    {
        parent::__construct(
            sprintf(
                'Превышен лимит промо кода %s',
                $promoCodeTitle,
            )
        );
    }
}