<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Infrastructure\Service\Template;

use OrganizationalFees\Infrastructure\Service\Template\TemplateMail;
use OrganizationalFees\Infrastructure\Service\Template\TemplatePdf;
use OrganizationalFees\Infrastructure\Service\Template\TemplateService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TemplateServiceTest extends BaseTemplateTestCase
{

    private TemplateService $templateService;

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();

        /** @var TemplateService $templateService */
        $templateService = $kernel->getContainer()->get(TemplateService::class);
        $this->templateService = $templateService;

    }

    public function testTemplateMail(): void
    {
        $file = new UploadedFile(__DIR__.'/File/'.self::TEMPLATE_MAIL, self::TEMPLATE_MAIL, test: true);
        $path = $this->templateService->save($file, new TemplateMail());

        self::assertEquals(TemplateMail::PATH.self::TEMPLATE_MAIL, $path);
    }

    public function testTemplatePdf(): void
    {
        $file = new UploadedFile(__DIR__.'/File/'.self::TEMPLATE_PDF, self::TEMPLATE_PDF, test: true);
        $path = $this->templateService->save($file, new TemplatePdf());

        self::assertEquals(TemplatePdf::PATH.self::TEMPLATE_PDF, $path);
    }
}