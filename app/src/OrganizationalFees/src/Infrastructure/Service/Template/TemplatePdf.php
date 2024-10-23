<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Service\Template;

use OrganizationalFees\Application\Service\Template\TemplateInterface;

class TemplatePdf implements TemplateInterface
{
    public const PATH = '/app/src/OrganizationalFees/src/Infrastructure/Resources/Template/Pdf/';

    public function getPath(): string
    {
        return self::PATH;
    }
}
