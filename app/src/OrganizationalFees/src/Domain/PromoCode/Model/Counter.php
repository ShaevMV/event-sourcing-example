<?php


declare(strict_types=1);
namespace OrganizationalFees\Domain\PromoCode\Model;

use Shared\Domain\ValueObject\PositiveNumber;

class Counter extends PositiveNumber
{
    public function nextCount(): void
    {
        if(!isset($this->value)) {
            $this->value = 0;
        }

        ++$this->value;
    }
}