<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\ArrangementFee\Model;

use Shared\Domain\ValueObject\PriceList;
use Shared\Domain\ValueObject\ValidateException;

class ArrangementPriceList extends PriceList
{
    /**
     * @throws ValidateException
     */
    public function getCorrectPrice(?ArrangementPriceTimestamp $timestampNow = null): ?ArrangementPrice
    {
        $timestampNow = null === $timestampNow ? new ArrangementPriceTimestamp(time()) : $timestampNow;
        $priceList = $this->priceList ?? [];
        krsort($priceList);
        foreach ($priceList as $timestamp => $price) {
            if ($timestampNow->lessIsEqual(new ArrangementPriceTimestamp($timestamp))) {
                return new ArrangementPrice($price->value());
            }
        }

        return null;
    }
}
