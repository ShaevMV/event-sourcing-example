<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Service\Template;

interface PdfTemplateInterface
{
    public function validate(string $content): bool;
}