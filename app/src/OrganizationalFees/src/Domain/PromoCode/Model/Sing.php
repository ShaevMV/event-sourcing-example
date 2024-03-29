<?php


declare(strict_types=1);


namespace OrganizationalFees\Domain\PromoCode\Model;

use OrganizationalFees\Domain\PromoCode\Exception\PromoCodeSingDontCorrectException;
use Shared\Domain\ValueObject\Keyword;

class Sing extends Keyword
{
    public const PERCENT = '%',
        FIX = '-';

    public function isPercent(): bool
    {
        return $this->value === self::PERCENT;
    }

    /**
     * @throws PromoCodeSingDontCorrectException
     */
    public static function fromString(string $value): static
    {
        if(!in_array($value, [self::FIX, self::PERCENT])) {
            throw new PromoCodeSingDontCorrectException(sprintf('Не известный тип знака для промокода %s', $value));
        }

        return new static($value);
    }
}