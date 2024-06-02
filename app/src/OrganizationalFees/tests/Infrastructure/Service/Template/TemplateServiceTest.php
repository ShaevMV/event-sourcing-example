<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Infrastructure\Service\Template;

use OrganizationalFees\Infrastructure\Service\Template\TemplateMail;
use OrganizationalFees\Infrastructure\Service\Template\TemplatePdf;
use OrganizationalFees\Infrastructure\Service\Template\TemplateService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TemplateServiceTest extends KernelTestCase
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
        $file = new UploadedFile(__DIR__.'/File/mail.html.twig', 'mail.html.twig', test: true);
        $path = $this->templateService->save($file, new TemplateMail());

        self::assertEquals(TemplateMail::PATH.'mail.html.twig', $path);

        $file = new UploadedFile($path, 'mail.html.twig', test: true);
        $file->move(__DIR__.'/File/');
    }

    public function testTemplatePdf(): void
    {
        $file = new UploadedFile(__DIR__.'/File/pdf.html.twig', 'pdf.html.twig', test: true);
        $path = $this->templateService->save($file, new TemplatePdf());

        self::assertEquals(TemplatePdf::PATH.'pdf.html.twig', $path);

        $file = new UploadedFile($path, 'pdf.html.twig', test: true);
        $file->move(__DIR__.'/File/');
    }
}