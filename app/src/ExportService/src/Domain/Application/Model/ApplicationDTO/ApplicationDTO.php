<?php

declare(strict_types=1);

namespace ExportService\Domain\Application\Model\ApplicationDTO;

use ExportService\Domain\Application\Model\ApplicationId;
use Shared\Domain\ValueObject\Uuid;

final class ApplicationDTO
{
    private ApplicationId $applicationId;
    private Uuid $cbUuid;
    private Amount $amount;
    private ?ApprovedAt $approvedAt = null;
    private ?RejectedAt $rejectedAt = null;
    private ?PayoutExpiresAt $payoutExpiresAt = null;
}