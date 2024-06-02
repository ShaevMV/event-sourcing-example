<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Service\Template;

interface TemplateInterface
{
    public function getPath(): string;
}