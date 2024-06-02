<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Service\Template;

interface MailTemplateInterface
{
    public function validate(string $content): bool;
}