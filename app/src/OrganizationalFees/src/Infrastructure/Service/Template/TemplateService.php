<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Service\Template;

use OrganizationalFees\Application\Service\Template\TemplateInterface;
use OrganizationalFees\Application\Service\Template\TemplateServiceInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TemplateService implements TemplateServiceInterface
{
    public function save(UploadedFile $file, TemplateInterface $template): string
    {
        $result = $file->move($template->getPath(), $file->getFilename());

        return $result->getPathname();
    }
}