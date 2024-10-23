<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Service\Template;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface TemplateServiceInterface
{
    public function save(UploadedFile $file, TemplateInterface $template): string;
}
