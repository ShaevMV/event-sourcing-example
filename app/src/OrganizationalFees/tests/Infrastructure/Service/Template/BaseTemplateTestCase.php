<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Infrastructure\Service\Template;

use OrganizationalFees\Infrastructure\Service\Template\TemplateMail;
use OrganizationalFees\Infrastructure\Service\Template\TemplatePdf;
use Tests\OrganizationalFees\BaseKernelTestCase;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BaseTemplateTestCase extends BaseKernelTestCase
{

    protected const TEMPLATE_MAIL = 'mail.html.twig';
    protected const TEMPLATE_PDF = 'pdf.html.twig';

    protected function tearDown(): void
    {
        try {
            $file = new UploadedFile(TemplateMail::PATH . self::TEMPLATE_MAIL, self::TEMPLATE_MAIL, test: true);
            $file->move(__DIR__ . '/File/');
        } catch (FileNotFoundException $exception) {
        }

        try {
            $file = new UploadedFile(TemplatePdf::PATH . self::TEMPLATE_PDF, self::TEMPLATE_PDF, test: true);
            $file->move(__DIR__ . '/File/');
        } catch (FileNotFoundException $exception) {
        }
    }

    protected function getFile(string $name): UploadedFile
    {
        return new UploadedFile(__DIR__ . '/File/' . $name, $name, test: true);
    }
}