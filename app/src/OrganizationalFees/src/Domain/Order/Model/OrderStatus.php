<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Order\Model;

use Exception;
use Shared\Domain\ValueObject\Status;

class OrderStatus extends Status
{
    public const PAID = 'paid';
    public const NEW = 'new';
    public const CANCEL = 'cancel';

    /**
     * @throws Exception
     */
    public function isCorrectNextStatus(Status $status): bool
    {
        return match ($status->value()) {
            self::NEW =>  $status->value() === self::PAID,
            self::PAID => $status->value() === self::CANCEL,
            default => throw new Exception('Unexpected match value'),
        };
    }
}