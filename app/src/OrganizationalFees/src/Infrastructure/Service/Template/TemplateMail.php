<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Service\Template;

use OrganizationalFees\Application\Service\Template\TemplateInterface;

class TemplateMail implements TemplateInterface
{
    public const PATH = '/app/src/OrganizationalFees/src/Infrastructure/Resources/Template/Mail/';

    public function getPath(): string
    {
        return self::PATH;
    }
}
