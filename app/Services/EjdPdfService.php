<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\View;

/**
 * PDF generation service for EJD forms.
 */
class EjdPdfService extends PdfService
{
    /**
     * Generate PDF from EJD form data.
     *
     * @param  array<string, mixed>  $data  Form data from EjdForm component
     */
    public function generate(array $data): string
    {
        $html = $this->renderHtml($data);

        return $this->generatePdf($html);
    }

    /**
     * Render the EJD form as HTML for PDF generation.
     *
     * @param  array<string, mixed>  $data
     */
    protected function renderHtml(array $data): string
    {
        return View::make('pdf.ejd', $data)->render();
    }
}
