<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\View;

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

        return $this->generatePdf($html);
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
}
