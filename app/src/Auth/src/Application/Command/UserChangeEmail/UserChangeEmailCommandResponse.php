<?php

declare(strict_types=1);

namespace Auth\Application\Command\UserChangeEmail;

use Shared\Domain\Bus\Command\CommandResponse;

class UserChangeEmailCommandResponse implements CommandResponse
{
    public function __construct(
        public readonly string $userId,
    ) {
    }
}
