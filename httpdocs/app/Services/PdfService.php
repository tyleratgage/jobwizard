<?php

declare(strict_types=1);

namespace App\Services;

use Spatie\Browsershot\Browsershot;

/**
 * Base PDF generation service using Browsershot.
 *
 * Provides common configuration for PDF generation across the application.
 */
class PdfService
{
    /**
     * Create a configured Browsershot instance from HTML content.
     */
    protected function createBrowsershot(string $html): Browsershot
    {
        $browsershot = Browsershot::html($html)
            ->setChromePath(env('BROWSERSHOT_CHROME_PATH'))
            ->setNodeBinary(env('BROWSERSHOT_NODE_PATH'))
            ->setNpmBinary(env('BROWSERSHOT_NPM_PATH'))
            ->noSandbox()
            ->format('Letter')
            ->margins(10, 10, 10, 10)
            ->showBackground()
            ->waitUntilNetworkIdle();

        return $browsershot;
    }

    /**
     * Generate PDF from HTML and return as string.
     */
    public function generatePdf(string $html): string
    {
        return $this->createBrowsershot($html)->pdf();
    }

    /**
     * Generate PDF from HTML and save to file.
     */
    public function savePdf(string $html, string $path): void
    {
        $this->createBrowsershot($html)->save($path);
    }
}
