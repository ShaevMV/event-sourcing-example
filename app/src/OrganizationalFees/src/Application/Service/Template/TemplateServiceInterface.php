<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Service\Template;

use Symfony\Component\HttpFoundation\File\File;

interface TemplateServiceInterface
{
    public function save(File $file): string;
}