<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;

/**
 * PDF generation service for Offer Letters.
 */
class OfferLetterPdfService extends PdfService
{
    /**
     * Generate PDF from Offer Letter form data.
     *
     * @param  string  $templateName  The template view name (e.g., 'english-permanent')
     * @param  array<string, mixed>  $data  Form data from OfferLetterForm component
     */
    public function generate(string $templateName, array $data): string
    {
        $html = $this->renderHtml($templateName, $data);
        $headerHtml = $this->renderHeaderHtml($templateName, $data);

        return $this->generatePdfWithHeader($html, $headerHtml);
    }

    /**
     * Render the Offer Letter as HTML for PDF generation.
     *
     * @param  string  $templateName
     * @param  array<string, mixed>  $data
     */
    protected function renderHtml(string $templateName, array $data): string
    {
        return View::make('pdf.offer-letter', [
            'templateName' => $templateName,
            'data' => $data,
        ])->render();
    }

    /**
     * Render the header HTML for PDF pages.
     *
     * @param  string  $templateName
     * @param  array<string, mixed>  $data
     */
    protected function renderHeaderHtml(string $templateName, array $data): string
    {
        // Determine job type label based on template name
        $isTransitional = str_contains($templateName, 'temporary');
        $jobTypeLabel = $isTransitional ? 'Transitional Job Offer' : 'Return to Work Job Offer';

        // Add translations for Spanish and Russian
        if (str_contains($templateName, 'spanish')) {
            $jobTypeLabel = $isTransitional ? 'Oferta de Trabajo Transitorio' : 'Oferta de Trabajo Permanente';
        } elseif (str_contains($templateName, 'russian')) {
            $jobTypeLabel = $isTransitional ? 'Предложение о переходной работе' : 'Предложение о постоянной работе';
        }

        $workerName = ($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '');
        $claimNo = $data['claim_no'] ?? '';

        return <<<HTML
        <div style="font-size: 9px; font-family: 'Times New Roman', Times, serif; width: 100%; padding: 0 0.5in; margin-top: 0.3in;">
            <div style="border-bottom: 1px solid #ccc; padding-bottom: 3px; display: flex; justify-content: space-between;">
                <div>
                    {$jobTypeLabel}<br>
                    Injured Worker: {$workerName}<br>
                    L&I Claim No.: {$claimNo}
                </div>
                <div style="text-align: right;">
                    Page <span class="pageNumber"></span> of <span class="totalPages"></span>
                </div>
            </div>
        </div>
        HTML;
    }

    /**
     * Generate PDF with a header on every page.
     */
    protected function generatePdfWithHeader(string $html, string $headerHtml): string
    {
        $browsershot = Browsershot::html($html)
            ->setChromePath(env('BROWSERSHOT_CHROME_PATH'))
            ->setNodeBinary(env('BROWSERSHOT_NODE_PATH'))
            ->setNpmBinary(env('BROWSERSHOT_NPM_PATH'))
            ->noSandbox()
            ->format('Letter')
            ->margins(30, 10, 10, 10) // Increased top margin for header (30mm)
            ->showBackground()
            ->waitUntilNetworkIdle()
            ->showBrowserHeaderAndFooter()
            ->headerHtml($headerHtml)
            ->footerHtml('<div></div>'); // Empty footer required when using headerHtml

        return $browsershot->pdf();
    }
}
