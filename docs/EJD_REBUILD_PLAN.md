# EJD Application Rebuild Plan

## Executive Summary

This document outlines the plan to rebuild the Employer's Job Description (EJD) application from a legacy PHP application into a modern Laravel 11 application with improved accessibility, user experience, and maintainability.

**Current State:** Legacy PHP application with Bootstrap 2.x, jQuery 1.5.1, session-based multi-page forms, and database-stored templates.

**Target State:** Modern Laravel 11 application with Livewire, single-page multi-step forms, file-based templates, WCAG 2.1 AA accessibility compliance, and improved UX.

**Timeline:** 4-5 weeks for Phase 1 (Core Application)

---

## Table of Contents

1. [Objectives](#objectives)
2. [Current Application Analysis](#current-application-analysis)
3. [Technology Stack](#technology-stack)
4. [Architecture Overview](#architecture-overview)
5. [Database Refactoring](#database-refactoring)
6. [Configuration & Templates Strategy](#configuration--templates-strategy)
7. [Feature Requirements](#feature-requirements)
8. [Accessibility Requirements](#accessibility-requirements)
9. [Analytics Requirements](#analytics-requirements)
10. [Migration Strategy](#migration-strategy)
11. [Development Timeline](#development-timeline)
12. [Deployment Plan](#deployment-plan)
13. [Phase 2: Admin Panel (Optional)](#phase-2-admin-panel-optional)

---

## Objectives

### Primary Goals

1. **Modernize User Experience**
   - Single-page multi-step forms with instant validation
   - Mobile-responsive design
   - Intuitive, clean interface
   - Reduced cognitive load

2. **Improve Accessibility**
   - WCAG 2.1 AA compliance
   - Screen reader support
   - Keyboard navigation
   - Proper ARIA labels and landmarks

3. **Enhance Maintainability**
   - Modern framework (Laravel 11)
   - Clean, testable code
   - File-based templates (version controlled)
   - Proper separation of concerns

4. **Simplify Template Management**
   - Move templates from database to Blade files
   - Easier editing without database access
   - Native PHP templating with IDE support

5. **Add Basic Analytics**
   - Track job selection frequency
   - Track task selection frequency
   - Track form completion rates

---

## Current Application Analysis

### Application Flow

**EJD Form (4-step process):**
1. Page 1: Employer/worker information
2. Page 2: Job title selection
3. Page 3: Task selection (AJAX-driven equipment list)
4. Page 4: Physical demand assessment
5. Final: Printable form output

**Offer Letter:**
- Single form with all required fields
- Template selection based on language + type (permanent/temporary)
- Printable letter output

### Current Tech Stack

- **Backend:** PHP 7.x with custom MVC pattern
- **Frontend:** Bootstrap 2.x, jQuery 1.5.1
- **Form Builder:** PFBC (PHP Form Builder Class)
- **Database:** MySQL with MysqliDb wrapper
- **Session Management:** PHP sessions storing form data
- **Template System:** String replacement with `[[placeholder]]` tags

### Pain Points

1. **User Experience:**
   - Multi-page reloads lose context
   - No draft saving
   - Validation only on submission
   - Not mobile-friendly

2. **Accessibility:**
   - No ARIA labels
   - Poor keyboard navigation
   - Inadequate screen reader support
   - Color contrast issues

3. **Maintainability:**
   - Legacy dependencies
   - Templates stored in database (hard to edit)
   - Serialized PHP arrays in database
   - No version control for content

4. **PDF Generation:**
   - No server-side PDF generation
   - Relies on browser "Print to PDF" functionality
   - Inconsistent output across different browsers
   - No control over headers, footers, or page formatting
   - Users may not know how to save as PDF

5. **Security:**
   - Older PHP version
   - Potential XSS vulnerabilities in template output
   - Legacy form validation

---

## Technology Stack

### Backend

- **Framework:** Laravel 11.x
- **PHP Version:** 8.3+
- **Database:** MySQL 8.0+
- **ORM:** Eloquent
- **Validation:** Laravel Form Requests
- **PDF Generation:** Spatie Browsershot (headless Chrome/Chromium)

### Frontend

- **CSS Framework:** TailwindCSS 3.x
- **JavaScript:** Alpine.js (via Livewire)
- **Reactive Components:** Livewire 3.x
- **Icons:** Heroicons or Lucide
- **Forms:** Livewire with real-time validation

### Development Tools

- **Code Style:** Laravel Pint
- **Testing:** Pest PHP
- **Package Manager:** Composer
- **Asset Bundling:** Vite
- **Version Control:** Git

### Hosting Requirements

- PHP 8.3+
- Composer
- MySQL 8.0+
- Node.js (for build process)
- SSL certificate

---

## Architecture Overview

### Directory Structure

```
app/
├── Enums/
│   ├── PhysicalDemandFrequency.php    # Physical demand frequency levels
│   ├── JobLocation.php                 # Office, yard, job
│   └── OfferLetterType.php            # Permanent, temporary
├── Models/
│   ├── Job.php                         # Job titles
│   ├── Task.php                        # Tasks with physical demands
│   ├── EjdSubmission.php              # Form submissions (optional logging)
│   ├── OfferLetterSubmission.php      # Offer letter submissions
│   └── Analytics/
│       ├── JobSelection.php            # Job selection tracking
│       └── TaskSelection.php           # Task selection tracking
├── Http/
│   ├── Controllers/
│   │   ├── EjdController.php          # EJD form controller
│   │   └── OfferLetterController.php  # Offer letter controller
│   ├── Livewire/
│   │   ├── EjdWizard.php              # Multi-step form component
│   │   └── TaskSelector.php           # Dynamic task selection
│   └── Requests/
│       ├── EjdFormRequest.php         # EJD validation
│       └── OfferLetterRequest.php     # Offer letter validation
└── Services/
    ├── PdfGenerator.php                # PDF generation service
    └── AnalyticsService.php            # Analytics tracking

resources/
├── views/
│   ├── layouts/
│   │   └── app.blade.php              # Main layout
│   ├── components/
│   │   ├── form-step.blade.php        # Reusable form step wrapper
│   │   └── progress-indicator.blade.php
│   ├── templates/
│   │   └── offer-letters/
│   │       ├── permanent/
│   │       │   ├── en.blade.php       # English permanent letter
│   │       │   ├── es.blade.php       # Spanish permanent letter
│   │       │   └── ru.blade.php       # Russian permanent letter
│   │       └── temporary/
│   │           ├── en.blade.php       # English temporary letter
│   │           ├── es.blade.php       # Spanish temporary letter
│   │           └── ru.blade.php       # Russian temporary letter
│   ├── ejd/
│   │   ├── index.blade.php            # Main EJD form page
│   │   ├── preview.blade.php          # EJD browser preview
│   │   └── pdf.blade.php              # EJD PDF template
│   └── offer-letter/
│       ├── index.blade.php            # Offer letter form
│       └── preview.blade.php          # Letter browser preview
└── lang/
    ├── en/
    │   └── time.php                   # English time translations
    ├── es/
    │   └── time.php                   # Spanish time translations
    └── ru/
        └── time.php                   # Russian time translations

config/
└── ejd.php                            # Application configuration

public/
└── images/
    └── blue-header-bg.png            # Header background image
```

### Routing

```php
// Simple, RESTful routes
GET  /                                  → redirect to /ejd
GET  /ejd                               → EJD form
POST /ejd                               → Store EJD submission
GET  /ejd/preview                       → Preview EJD output
GET  /ejd/pdf                           → Download PDF

GET  /offer-letter                      → Offer letter form
POST /offer-letter                      → Store offer letter
GET  /offer-letter/preview              → Preview letter
GET  /offer-letter/pdf                  → Download PDF
```

---

## Database Refactoring

### Legacy Database Issues

1. **Serialized PHP arrays** in `task.t_jobs` column
2. **8 tables** for relatively simple data
3. **Static data in database** (translations, frequency scales, config)
4. **HTML templates in database** (hard to version control)

### New Database Schema

**Three core tables:**

```sql
-- Jobs table (simplified from legacy 'job' table)
CREATE TABLE jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    location ENUM('office', 'yard', 'job') NOT NULL,
    sort_order INT UNSIGNED NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX idx_location (location),
    INDEX idx_sort_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tasks table (normalized from legacy 'task' table)
CREATE TABLE tasks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    equipment TEXT NULL,
    sort_order INT UNSIGNED NOT NULL,

    -- Physical demand columns (0-4 scale, maps to PhysicalDemandFrequency enum)
    sitting TINYINT UNSIGNED DEFAULT 0,
    standing TINYINT UNSIGNED DEFAULT 0,
    walking TINYINT UNSIGNED DEFAULT 0,
    foot_driving TINYINT UNSIGNED DEFAULT 0,
    lifting TINYINT UNSIGNED DEFAULT 0,
    carrying TINYINT UNSIGNED DEFAULT 0,
    pushing_pulling TINYINT UNSIGNED DEFAULT 0,
    climbing TINYINT UNSIGNED DEFAULT 0,
    bending TINYINT UNSIGNED DEFAULT 0,
    twisting TINYINT UNSIGNED DEFAULT 0,
    kneeling TINYINT UNSIGNED DEFAULT 0,
    crouching TINYINT UNSIGNED DEFAULT 0,
    crawling TINYINT UNSIGNED DEFAULT 0,
    squatting TINYINT UNSIGNED DEFAULT 0,
    reaching_overhead TINYINT UNSIGNED DEFAULT 0,
    reaching_outward TINYINT UNSIGNED DEFAULT 0,
    repetitive_motions TINYINT UNSIGNED DEFAULT 0,
    handling TINYINT UNSIGNED DEFAULT 0,
    fine_manipulation TINYINT UNSIGNED DEFAULT 0,
    talk_hear_see TINYINT UNSIGNED DEFAULT 0,
    vibratory TINYINT UNSIGNED DEFAULT 0,
    other TINYINT UNSIGNED DEFAULT 0,

    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX idx_sort_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Job-Task pivot table (replaces serialized arrays)
CREATE TABLE job_task (
    job_id BIGINT UNSIGNED NOT NULL,
    task_id BIGINT UNSIGNED NOT NULL,

    PRIMARY KEY (job_id, task_id),
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE,
    INDEX idx_job_id (job_id),
    INDEX idx_task_id (task_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- EJD form submissions (optional, for record keeping)
CREATE TABLE ejd_submissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NULL,
    job_id BIGINT UNSIGNED NULL,
    form_data JSON NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX idx_session (session_id),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Offer letter submissions (optional, for record keeping)
CREATE TABLE offer_letter_submissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NULL,
    template_type VARCHAR(50) NOT NULL,  -- 'permanent' or 'temporary'
    language VARCHAR(10) NOT NULL,        -- 'en', 'es', 'ru'
    form_data JSON NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX idx_session (session_id),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Analytics: Job selection tracking
CREATE TABLE job_selections (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_id BIGINT UNSIGNED NOT NULL,
    selected_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    INDEX idx_job_id (job_id),
    INDEX idx_selected_at (selected_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Analytics: Task selection tracking
CREATE TABLE task_selections (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    task_id BIGINT UNSIGNED NOT NULL,
    job_id BIGINT UNSIGNED NULL,
    selected_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE SET NULL,
    INDEX idx_task_id (task_id),
    INDEX idx_job_id (job_id),
    INDEX idx_selected_at (selected_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Data Migration Strategy

**From Legacy Tables:**

| Legacy Table | New Location | Migration Method |
|--------------|--------------|------------------|
| `job` | `jobs` table | Direct SQL migration with column mapping |
| `task` | `tasks` table | SQL migration + deserialize `t_jobs` array into pivot |
| `task.t_jobs` (serialized) | `job_task` pivot | Deserialize and insert relationships |
| `offerLetter2021` | Blade templates | Export HTML, convert to Blade syntax |
| `translations` | Lang files | Export to PHP arrays in `resources/lang` |
| `pd_freq` | PHP Enum | Hard-coded in `PhysicalDemandFrequency` enum |
| `site_config` | `.env` + config | Move to environment variables |
| `uploads` | File storage | Keep existing files, track in storage |

**Migration Script Example:**

```php
// database/migrations/xxxx_migrate_legacy_ejd_data.php

public function up()
{
    // 1. Migrate jobs
    DB::table('job')->orderBy('j_seq')->each(function ($oldJob) {
        DB::table('jobs')->insert([
            'code' => $oldJob->j_code,
            'name' => $oldJob->j_name,
            'location' => $oldJob->j_location,
            'sort_order' => $oldJob->j_seq,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    });

    // 2. Migrate tasks
    DB::table('task')->each(function ($oldTask) {
        $taskId = DB::table('tasks')->insertGetId([
            'code' => $oldTask->t_code,
            'name' => $oldTask->t_name,
            'equipment' => $oldTask->t_equipment,
            'sort_order' => $oldTask->t_seq,
            'sitting' => $oldTask->t_sit,
            'standing' => $oldTask->t_stand,
            'walking' => $oldTask->t_walk,
            'foot_driving' => $oldTask->t_footDrive,
            'lifting' => $oldTask->t_lift,
            'carrying' => $oldTask->t_carry,
            'pushing_pulling' => $oldTask->t_push,
            'climbing' => $oldTask->t_climb,
            'bending' => $oldTask->t_bend,
            'twisting' => $oldTask->t_twist,
            'kneeling' => $oldTask->t_knee,
            'crouching' => $oldTask->t_crouch,
            'crawling' => $oldTask->t_crawl,
            'squatting' => $oldTask->t_squat,
            'reaching_overhead' => $oldTask->t_aboveShoulders,
            'reaching_outward' => $oldTask->t_reachOut,
            'repetitive_motions' => $oldTask->t_repetitive,
            'handling' => $oldTask->t_handle,
            'fine_manipulation' => $oldTask->t_manipulation,
            'talk_hear_see' => $oldTask->t_talkHearSee,
            'vibratory' => $oldTask->t_vibratory,
            'other' => $oldTask->t_other,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Deserialize job relationships and create pivot records
        if (!empty($oldTask->t_jobs)) {
            $jobCodes = @unserialize($oldTask->t_jobs);
            if (is_array($jobCodes)) {
                foreach ($jobCodes as $jobCode) {
                    $job = DB::table('jobs')->where('code', $jobCode)->first();
                    if ($job) {
                        DB::table('job_task')->insert([
                            'job_id' => $job->id,
                            'task_id' => $taskId,
                        ]);
                    }
                }
            }
        }
    });
}
```

---

## Configuration & Templates Strategy

### Move Static Data Out of Database

**1. Physical Demand Frequency → Enum**

```php
// app/Enums/PhysicalDemandFrequency.php
namespace App\Enums;

enum PhysicalDemandFrequency: int
{
    case NEVER = 0;
    case SELDOM = 1;
    case OCCASIONAL = 2;
    case FREQUENT = 3;
    case CONSTANT = 4;

    public function label(): string
    {
        return match($this) {
            self::NEVER => 'Never (not at all)',
            self::SELDOM => 'Seldom (1-10% of the time)',
            self::OCCASIONAL => 'Occasional (11-33% of the time)',
            self::FREQUENT => 'Frequent (34-66% of the time)',
            self::CONSTANT => 'Constant (67-100% of the time)',
        };
    }

    public function percentage(): string
    {
        return match($this) {
            self::NEVER => '0%',
            self::SELDOM => '1-10%',
            self::OCCASIONAL => '11-33%',
            self::FREQUENT => '34-66%',
            self::CONSTANT => '67-100%',
        };
    }
}
```

**2. Translations → Lang Files**

```php
// resources/lang/en/time.php
return [
    'AM' => 'AM',
    'PM' => 'PM',
    'hour' => 'Hour',
    'day' => 'Day',
    'week' => 'Week',
    'weekend' => 'Weekend',
    'days' => [
        'sunday' => 'Sunday',
        'monday' => 'Monday',
        'tuesday' => 'Tuesday',
        'wednesday' => 'Wednesday',
        'thursday' => 'Thursday',
        'friday' => 'Friday',
        'saturday' => 'Saturday',
    ],
    'and' => 'and',
];

// resources/lang/es/time.php
return [
    'AM' => 'AM',
    'PM' => 'PM',
    'hour' => 'Hora',
    'day' => 'Día',
    'week' => 'Semana',
    'weekend' => 'Fin de Semana',
    'days' => [
        'sunday' => 'Domingo',
        'monday' => 'Lunes',
        'tuesday' => 'Martes',
        'wednesday' => 'Miércoles',
        'thursday' => 'Jueves',
        'friday' => 'Viernes',
        'saturday' => 'Sábado',
    ],
    'and' => 'y',
];

// resources/lang/ru/time.php
return [
    'AM' => null,  // Russia uses 24-hour format
    'PM' => null,
    'hour' => 'час',
    'day' => 'день',
    'week' => 'неделя',
    'weekend' => 'уик-энд',
    'days' => [
        'sunday' => 'воскресенье',
        'monday' => 'понедельник',
        'tuesday' => 'вторник',
        'wednesday' => 'среда',
        'thursday' => 'четверг',
        'friday' => 'пятница',
        'saturday' => 'суббота',
    ],
    'and' => 'и',
];
```

**3. Site Configuration → .env + Config**

```bash
# .env
APP_NAME="Employer's Job Description"
COMPANY_NAME="EMPLOYER'S JOB DESCRIPTION"
HEADER_BG_PATH="/images/blue-header-bg.png"
```

```php
// config/ejd.php
return [
    'company_name' => env('COMPANY_NAME', "Employer's Job Description"),
    'header_bg' => env('HEADER_BG_PATH', '/images/blue-header-bg.png'),

    'offer_letter' => [
        'types' => ['permanent', 'temporary'],
        'languages' => ['en', 'es', 'ru'],
    ],

    'analytics' => [
        'enabled' => env('ANALYTICS_ENABLED', true),
    ],
];
```

**4. Offer Letter Templates → Blade Files**

**Old System:**
```
Database → offerLetter2021 table → HTML with [[placeholders]]
```

**New System:**
```
Blade files → resources/views/templates/offer-letters/{type}/{lang}.blade.php
```

**Template Example:**

```blade
{{-- resources/views/templates/offer-letters/permanent/en.blade.php --}}
<div class="max-w-4xl mx-auto bg-white">
    {{-- Page 1 --}}
    <div class="p-8">
        <div class="text-sm text-gray-600 mb-6 print:mb-4">
            Return to Work Job Offer, page 1<br>
            Injured Employee Name: {{ $firstName }} {{ $lastName }}<br>
            L&I Claim No.: {{ $claimNo }}
        </div>

        <p class="mb-4">{{ $date }}</p>

        <address class="not-italic mb-6">
            {{ $firstName }} {{ $lastName }}<br>
            {{ $addressOne }}@if($addressTwo), {{ $addressTwo }}@endif<br>
            {{ $city }}, {{ $state }} {{ $zip }}
        </address>

        <div class="mb-6">
            <strong>Re: Return to Work Job Offer</strong><br>
            L&I Claim No. {{ $claimNo }}
        </div>

        <p class="mb-4">Dear {{ $firstName }},</p>

        <p class="mb-4">
            I am pleased to offer you employment that will accommodate your current physical
            capacities. Your duties are described in the approved job description and are
            consistent with all physical limitations established by your attending provider...
        </p>

        <p class="mb-2">The details to report to work are as follows:</p>

        <ul class="list-disc pl-6 mb-6 space-y-2">
            <li>You must report on {{ $workDate }} at {{ $startTime }} at {{ $locationAddress }}, {{ $locationCity }}</li>
            <li>Your supervisor is {{ $supervisorName }} and their phone number is {{ $supervisorPhone }}</li>
            <li>Your work schedule is {{ $startTime }} to {{ $endTime }}, {{ $daysOfTheWeek }}</li>
            <li>Your wages will be ${{ $wage }} per {{ $wageDuration }} and applicable benefits are unchanged</li>
        </ul>

        <p class="mb-4">
            Except when covered by state or local Paid Family & Medical Leave rules, you are
            expected to schedule any medical and therapy appointments around your work schedule...
        </p>

        <div class="mt-12">
            <p>Sincerely,</p>
            <div class="mt-16 whitespace-pre-line">{{ $valediction }}</div>
        </div>
    </div>

    {{-- Page Break --}}
    <div class="page-break"></div>

    {{-- Page 2 --}}
    <div class="p-8">
        <div class="text-sm text-gray-600 mb-8">
            Return to Work Job Offer, page 2<br>
            Injured Employee Name: {{ $firstName }} {{ $lastName }}<br>
            L&I Claim No.: {{ $claimNo }}
        </div>

        <div class="mb-12 space-y-2">
            <p>☐ Yes, I accept the offered position and will report to work.</p>
            <p>☐ No, I do not accept the offered position and will not report to work.</p>
        </div>

        <div class="mt-16 flex justify-between border-t border-gray-800 pt-2">
            <span>Injured Employee Signature</span>
            <span>Date</span>
        </div>

        <p class="mt-12">Enclosure: Approved job description/analysis/release to work</p>

        @if($ccLine1 || $ccLine2 || $ccLine3)
            <div class="mt-8">
                <ul class="list-none space-y-1">
                    @if($ccLine1)<li>{{ $ccLine1 }}</li>@endif
                    @if($ccLine2)<li>{{ $ccLine2 }}</li>@endif
                    @if($ccLine3)<li>{{ $ccLine3 }}</li>@endif
                </ul>
            </div>
        @endif
    </div>
</div>
```

---

## PDF Generation Strategy

### Current System Limitations

The legacy application relies on browser-based printing:
- Renders HTML output to browser
- Uses CSS `@media print` styles
- Depends on users knowing to use "Print to PDF"
- No server-side PDF generation
- Inconsistent output across browsers
- No control over headers, footers, or page formatting

### New Approach: Spatie Browsershot

**Why Browsershot?**

Browsershot uses headless Chrome/Chromium to render HTML/CSS to PDF with perfect fidelity. It's the most stable and widely-used PDF solution in the Laravel ecosystem.

**Advantages:**
- ✅ **Perfect rendering** - Uses Chromium's rendering engine (same as Chrome browser)
- ✅ **Modern CSS support** - Flexbox, Grid, custom fonts, TailwindCSS
- ✅ **Consistent output** - Same result every time, regardless of user's browser
- ✅ **Full control** - Headers, footers, page numbers, margins, page breaks
- ✅ **Active maintenance** - Maintained by Spatie (trusted Laravel vendor)
- ✅ **Easy debugging** - Can save HTML snapshot for troubleshooting

**Installation:**

```bash
composer require spatie/browsershot

# Server requires Node.js and Puppeteer
npm install puppeteer

# Or use system Chromium
apt-get install chromium-browser
```

### PDF Service Implementation

```php
// app/Services/PdfGenerator.php
namespace App\Services;

use Spatie\Browsershot\Browsershot;

class PdfGenerator
{
    /**
     * Generate Offer Letter PDF
     */
    public function generateOfferLetter(array $data, string $type, string $lang): string
    {
        // Render Blade template to HTML
        $html = view("templates.offer-letters.{$type}.{$lang}", $data)->render();

        return Browsershot::html($html)
            ->format('Letter')                     // US Letter size (8.5" x 11")
            ->margins(20, 15, 20, 15)             // top, right, bottom, left (mm)
            ->showBackground()                     // Include background colors/images
            ->waitUntilNetworkIdle()              // Ensure fonts/images loaded
            ->setOption('printBackground', true)   // Print backgrounds
            ->pdf();
    }

    /**
     * Generate EJD Form PDF
     */
    public function generateEjdForm(array $data): string
    {
        $html = view('ejd.pdf', $data)->render();

        return Browsershot::html($html)
            ->format('Letter')
            ->margins(15, 10, 15, 10)
            ->showBackground()
            ->footerHtml('
                <div style="text-align: center; font-size: 10px; width: 100%;">
                    Page <span class="pageNumber"></span> of <span class="totalPages"></span>
                </div>
            ')
            ->pdf();
    }

    /**
     * Save PDF to storage (optional)
     */
    public function savePdf(string $pdf, string $filename): string
    {
        $path = storage_path("app/pdfs/{$filename}");
        file_put_contents($path, $pdf);
        return $path;
    }
}
```

### Controller Implementation

```php
// app/Http/Controllers/OfferLetterController.php
namespace App\Http\Controllers;

use App\Services\PdfGenerator;
use Illuminate\Http\Request;

class OfferLetterController extends Controller
{
    public function __construct(
        private PdfGenerator $pdfGenerator
    ) {}

    /**
     * Show HTML preview in browser
     */
    public function preview(Request $request)
    {
        $data = $request->session()->get('offer_letter_data');

        if (!$data) {
            return redirect()->route('offer-letter.index')
                ->with('error', 'Please complete the form first.');
        }

        return view(
            "templates.offer-letters.{$data['letterType']}.{$data['language']}",
            $data
        );
    }

    /**
     * Download PDF
     */
    public function downloadPdf(Request $request)
    {
        $data = $request->session()->get('offer_letter_data');

        if (!$data) {
            return redirect()->route('offer-letter.index')
                ->with('error', 'Please complete the form first.');
        }

        // Track analytics
        event(new OfferLetterGenerated($data));

        $pdf = $this->pdfGenerator->generateOfferLetter(
            $data,
            $data['letterType'],
            $data['language']
        );

        $filename = sprintf(
            'offer_letter_%s_%s.pdf',
            $data['claimNo'],
            now()->format('Y-m-d')
        );

        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }
}
```

### User Interface Flow

```blade
{{-- After form submission --}}
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold mb-4">Your offer letter is ready!</h2>

    <div class="flex gap-4">
        {{-- Preview in browser first --}}
        <a href="{{ route('offer-letter.preview') }}"
           class="btn btn-secondary"
           target="_blank">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            Preview in Browser
        </a>

        {{-- Download PDF --}}
        <a href="{{ route('offer-letter.pdf') }}"
           class="btn btn-primary"
           download>
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Download PDF
        </a>

        {{-- Start over --}}
        <a href="{{ route('offer-letter.index') }}"
           class="btn btn-outline">
            Create Another Letter
        </a>
    </div>
</div>
```

### Advanced PDF Features

**Custom Headers and Footers:**

```php
Browsershot::html($html)
    ->headerHtml('
        <div style="text-align: right; font-size: 9px; padding-right: 20px;">
            Confidential - For Official Use Only
        </div>
    ')
    ->footerHtml('
        <div style="display: flex; justify-content: space-between; font-size: 9px; padding: 0 20px;">
            <span>L&I Claim #: {{ $claimNo }}</span>
            <span>Page <span class="pageNumber"></span> of <span class="totalPages"></span></span>
            <span>Generated: {{ date("m/d/Y") }}</span>
        </div>
    ')
    ->pdf();
```

**Page-Specific Styling:**

```blade
<style>
    @page {
        size: letter;
        margin: 0;
    }

    @page :first {
        margin-top: 1in; /* Extra space on first page for letterhead */
    }

    .page-break {
        page-break-after: always;
    }

    /* Avoid breaking inside these elements */
    .no-break {
        page-break-inside: avoid;
    }

    /* Hide in print */
    .screen-only {
        display: none;
    }
</style>
```

**Watermarks (if needed):**

```php
Browsershot::html($html)
    ->setOption('watermark', [
        'text' => 'DRAFT',
        'opacity' => 0.3,
        'fontSize' => 72,
    ])
    ->pdf();
```

### Error Handling

```php
public function downloadPdf(Request $request)
{
    try {
        $pdf = $this->pdfGenerator->generateOfferLetter(...);

        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");

    } catch (\Exception $e) {
        Log::error('PDF Generation Failed', [
            'error' => $e->getMessage(),
            'data' => $request->session()->get('offer_letter_data'),
        ]);

        return redirect()
            ->route('offer-letter.preview')
            ->with('error', 'Unable to generate PDF. Please try the print button in the preview.');
    }
}
```

### Testing PDF Generation

```php
// tests/Feature/PdfGenerationTest.php
use App\Services\PdfGenerator;

test('can generate offer letter pdf', function () {
    $data = [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'claimNo' => '12345',
        // ... more data
    ];

    $pdf = app(PdfGenerator::class)->generateOfferLetter($data, 'permanent', 'en');

    expect($pdf)->toBeString();
    expect(strlen($pdf))->toBeGreaterThan(1000); // PDF should have content
    expect(substr($pdf, 0, 4))->toBe('%PDF'); // PDF magic number
});
```

### Server Requirements

**For Production:**

```bash
# Install Node.js (if not already installed)
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Install Puppeteer globally
npm install -g puppeteer

# Or install Chromium system-wide
sudo apt-get update
sudo apt-get install -y chromium-browser

# Required system libraries
sudo apt-get install -y \
    libx11-xcb1 \
    libxcomposite1 \
    libxcursor1 \
    libxdamage1 \
    libxi6 \
    libxtst6 \
    libnss3 \
    libcups2 \
    libxss1 \
    libxrandr2 \
    libasound2 \
    libatk1.0-0 \
    libatk-bridge2.0-0 \
    libpangocairo-1.0-0 \
    libgtk-3-0
```

**Configure Browsershot:**

```php
// config/browsershot.php (create this file)
return [
    'node_binary' => env('BROWSERSHOT_NODE_BINARY', '/usr/bin/node'),
    'npm_binary' => env('BROWSERSHOT_NPM_BINARY', '/usr/bin/npm'),
    'chrome_binary' => env('BROWSERSHOT_CHROME_BINARY', '/usr/bin/chromium-browser'),
    'timeout' => env('BROWSERSHOT_TIMEOUT', 60),
];
```

### Performance Optimization

**Cache rendered PDFs (optional):**

```php
public function downloadPdf(Request $request)
{
    $data = $request->session()->get('offer_letter_data');
    $cacheKey = md5(json_encode($data));

    // Cache for 1 hour
    $pdf = Cache::remember("pdf.{$cacheKey}", 3600, function () use ($data) {
        return $this->pdfGenerator->generateOfferLetter(
            $data,
            $data['letterType'],
            $data['language']
        );
    });

    return response($pdf)->header('Content-Type', 'application/pdf');
}
```

**Queue PDF generation for large documents:**

```php
// For future enhancement if PDFs become complex
dispatch(new GeneratePdfJob($data))->onQueue('pdfs');
```

### Fallback Strategy

If PDF generation fails, users can still print from browser preview:

```blade
{{-- In preview.blade.php --}}
<div class="no-print bg-yellow-50 border border-yellow-200 p-4 mb-4">
    <p class="font-semibold">PDF download not working?</p>
    <p>You can still print this page using your browser's print function (Ctrl+P or Cmd+P)</p>
    <button onclick="window.print()" class="btn btn-sm btn-secondary mt-2">
        Print Page
    </button>
</div>

<style>
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>
```

---

## Feature Requirements

### EJD Form Features

**Step 1: Employer & Worker Information**
- Employer details (name, address, contact)
- Worker details (name, address, claim number)
- Injury date
- Return to work date
- Honeypot anti-spam field

**Step 2: Job Selection**
- Searchable/filterable job list
- Grouped by location (Office, Yard, Job)
- Display job code and name
- Single selection

**Step 3: Task Selection**
- Checkboxes for multiple task selection
- Filtered by selected job
- Display task name and equipment
- Dynamic equipment list generation
- Select all/none functionality

**Step 4: Physical Demand Assessment**
- Auto-populated from selected tasks
- Display frequency for each physical demand category
- Show highest frequency from all selected tasks
- Categories:
  - Sitting, Standing, Walking
  - Lifting, Carrying, Pushing/Pulling
  - Bending, Twisting, Kneeling, Crouching, Crawling, Squatting
  - Reaching (overhead, outward)
  - Hand manipulation
  - Other demands

**Step 5: Preview & Generate**
- Review all entered information
- Edit capability for each section
- Print view
- PDF download
- Email option (future enhancement)

### Offer Letter Features

**Form Fields:**
- Letter type (Permanent/Temporary)
- Language (English/Spanish/Russian)
- Worker information
- Job details
- Supervisor information
- Work schedule
- Compensation
- Additional notes
- CC recipients (up to 3)

**Output:**
- Template selection based on type + language
- Preview before printing
- Print view
- PDF download
- Proper formatting for mailing

### General Features

- **Session Management:** Store form progress in session
- **Validation:** Real-time validation with clear error messages
- **Accessibility:** Full keyboard navigation, ARIA labels
- **Responsive:** Mobile, tablet, desktop optimized
- **Print Optimization:** Special print stylesheets
- **Analytics Tracking:** Log job/task selections

---

## Accessibility Requirements

### WCAG 2.1 Level AA Compliance

**Perceivable:**
- ✅ Color contrast ratio ≥ 4.5:1 for normal text
- ✅ Color contrast ratio ≥ 3:1 for large text
- ✅ Images have alt text
- ✅ Form inputs have visible labels
- ✅ Error messages clearly associated with inputs

**Operable:**
- ✅ Full keyboard navigation (Tab, Shift+Tab, Enter, Space, Arrow keys)
- ✅ No keyboard traps
- ✅ Skip to main content link
- ✅ Focus indicators visible
- ✅ Touch targets ≥ 44x44 pixels
- ✅ No time limits on form completion

**Understandable:**
- ✅ Clear, simple language
- ✅ Consistent navigation
- ✅ Input error identification and suggestions
- ✅ Labels and instructions provided
- ✅ Progress indicator for multi-step form

**Robust:**
- ✅ Valid HTML5 markup
- ✅ ARIA landmarks (`<main>`, `<nav>`, `<form>`)
- ✅ ARIA live regions for dynamic content
- ✅ Proper heading hierarchy (`<h1>` → `<h6>`)
- ✅ Form field associations (`<label for="">`)

### Specific Implementations

**Multi-Step Form Navigation:**
```html
<nav aria-label="Form progress" role="navigation">
    <ol class="flex items-center">
        <li aria-current="step">
            <a href="#step-1" class="font-bold">1. Worker Info</a>
        </li>
        <li>
            <a href="#step-2" aria-disabled="true">2. Job Selection</a>
        </li>
        <!-- ... -->
    </ol>
</nav>
```

**Live Validation Feedback:**
```html
<div class="form-group">
    <label for="firstName" class="required">First Name</label>
    <input
        type="text"
        id="firstName"
        name="firstName"
        aria-required="true"
        aria-invalid="true"
        aria-describedby="firstName-error"
    >
    <span id="firstName-error" role="alert" class="text-red-600">
        First name is required
    </span>
</div>
```

**Screen Reader Announcements:**
```html
<div aria-live="polite" aria-atomic="true" class="sr-only">
    Step 2 of 5: Job Selection. Choose the job title that best matches the position.
</div>
```

---

## Analytics Requirements

### Metrics to Track

**Job Selection Analytics:**
- Count of times each job is selected
- Most popular jobs
- Least popular jobs
- Selection trends over time

**Task Selection Analytics:**
- Count of times each task is selected
- Most frequently combined tasks
- Tasks per job type
- Selection trends over time

**Form Completion:**
- Total form submissions
- Completion rate by step
- Average time to complete
- Abandonment points

### Implementation

**Simple Counter Tables:**

```sql
-- Track each job selection
INSERT INTO job_selections (job_id, selected_at)
VALUES (?, NOW());

-- Track each task selection
INSERT INTO task_selections (task_id, job_id, selected_at)
VALUES (?, ?, NOW());
```

**Query Examples:**

```php
// Most popular jobs (last 30 days)
JobSelection::where('selected_at', '>=', now()->subDays(30))
    ->select('job_id', DB::raw('COUNT(*) as count'))
    ->groupBy('job_id')
    ->orderByDesc('count')
    ->limit(10)
    ->get();

// Most popular tasks for a specific job
TaskSelection::where('job_id', $jobId)
    ->select('task_id', DB::raw('COUNT(*) as count'))
    ->groupBy('task_id')
    ->orderByDesc('count')
    ->get();
```

**Privacy Considerations:**
- No personally identifiable information (PII) stored
- Only aggregate counts
- No tracking of individual users
- Session IDs are optional and anonymized

---

## Migration Strategy

### Phase 1: Preparation

**Week 1: Environment Setup**
1. Provision PHP 8.3 hosting environment
2. Set up database (MySQL 8.0+)
3. Configure domain/subdomain (e.g., `new.ejd.smartwa.org`)
4. Install Composer, Node.js
5. Set up Git repository
6. Configure CI/CD (optional)

**Week 2: Data Migration**
1. Export legacy database
2. Create Laravel migrations
3. Run migration scripts
4. Verify data integrity
5. Export templates from database
6. Convert templates to Blade syntax
7. Extract translations to lang files

### Phase 2: Development

**Week 1-2: Core Setup**
- [ ] Laravel 11 installation
- [ ] Database migrations
- [ ] Eloquent models
- [ ] Seeders for migrated data
- [ ] Basic routing
- [ ] Layout/template structure

**Week 3: EJD Form**
- [ ] Livewire wizard component
- [ ] Step 1: Worker information form
- [ ] Step 2: Job selection
- [ ] Step 3: Task selection with equipment
- [ ] Step 4: Physical demands display
- [ ] Step 5: Preview/generate
- [ ] Form validation
- [ ] Session management
- [ ] Analytics tracking

**Week 4: Offer Letter**
- [ ] Offer letter form
- [ ] Template rendering service
- [ ] Language/type selection
- [ ] Preview functionality
- [ ] PDF generation
- [ ] Analytics tracking

**Week 5: Polish & Testing**
- [ ] Accessibility audit (WAVE, axe DevTools)
- [ ] Keyboard navigation testing
- [ ] Screen reader testing (NVDA, JAWS)
- [ ] Mobile responsive testing
- [ ] Cross-browser testing
- [ ] Print stylesheet testing
- [ ] PDF output testing
- [ ] Performance optimization
- [ ] Bug fixes

### Phase 3: Deployment

**Week 6: Staging Deployment**
1. Deploy to staging subdomain
2. Run end-to-end tests
3. User acceptance testing (UAT)
4. Gather feedback
5. Make final adjustments

**Week 7: Production Deployment**
1. Final data sync
2. DNS cutover
3. SSL certificate setup
4. Monitor for issues
5. Archive legacy application

### Rollback Plan

- Keep legacy application running on backup subdomain
- Database backup before migration
- Ability to revert DNS if critical issues arise
- Document all configuration changes

---

## Development Timeline

### Phase 1: Core Application (5 weeks)

| Week | Tasks | Deliverables |
|------|-------|--------------|
| **1** | Environment setup, Laravel installation, database design | Working Laravel app, migrations created |
| **2** | Data migration, models, seeders | Data successfully migrated, models tested |
| **3** | EJD form wizard (steps 1-5), validation | Functional multi-step form |
| **4** | Offer letter form, template rendering, PDF generation | Functional offer letter generator |
| **5** | Accessibility audit, testing, bug fixes, polish | Production-ready application |

### Phase 2: Admin Panel (Optional, 4 weeks)

| Week | Tasks | Deliverables |
|------|-------|--------------|
| **6** | Filament installation, basic CRUD for jobs/tasks | Admin can manage jobs and tasks |
| **7** | Translation management, analytics dashboard | Admin can view analytics |
| **8** | Template editor with live preview | Admin can edit letter templates |
| **9** | Testing, refinement, documentation | Admin panel ready for use |

---

## Deployment Plan

### Hosting Requirements

**Server Specifications:**
- PHP 8.3+ with extensions:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - BCMath
  - GD or Imagick
  - Process Control (for Browsershot)
- MySQL 8.0+
- Composer
- Node.js 18+ (required for Vite build process and Browsershot/Puppeteer)
- Chromium browser or Puppeteer (for PDF generation)
- SSL certificate
- Min 1GB RAM (recommended 2GB for PDF generation)

### Deployment Steps

**Initial Deployment:**

```bash
# 1. Clone repository
git clone <repository-url> /var/www/vhosts/smartwa.org/ejd-new.smartwa.org
cd /var/www/vhosts/smartwa.org/ejd-new.smartwa.org

# 2. Install dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# 2a. Install Puppeteer for PDF generation
npm install puppeteer
# Or install system Chromium
sudo apt-get install chromium-browser

# 3. Environment configuration
cp .env.example .env
php artisan key:generate

# 4. Database setup
php artisan migrate --force
php artisan db:seed --force

# 5. Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Set permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### Environment Variables

```bash
APP_NAME="Employer's Job Description"
APP_ENV=production
APP_KEY=base64:... # Generated by php artisan key:generate
APP_DEBUG=false
APP_URL=https://ejd.smartwa.org

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smaejd_db_new
DB_USERNAME=smaejd_u
DB_PASSWORD=***

SESSION_DRIVER=file
SESSION_LIFETIME=120

ANALYTICS_ENABLED=true
COMPANY_NAME="EMPLOYER'S JOB DESCRIPTION"
HEADER_BG_PATH="/images/blue-header-bg.png"

# Browsershot configuration (optional overrides)
BROWSERSHOT_NODE_BINARY=/usr/bin/node
BROWSERSHOT_NPM_BINARY=/usr/bin/npm
BROWSERSHOT_CHROME_BINARY=/usr/bin/chromium-browser
BROWSERSHOT_TIMEOUT=60
```

### Web Server Configuration

**Apache (.htaccess in public/):**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

**Nginx:**
```nginx
server {
    listen 80;
    server_name ejd.smartwa.org;
    root /var/www/vhosts/smartwa.org/ejd.smartwa.org/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Post-Deployment Checklist

- [ ] Test all form submissions
- [ ] Verify PDF generation works
- [ ] Test all language variants
- [ ] Check analytics tracking
- [ ] Run accessibility audit
- [ ] Test on multiple browsers
- [ ] Test on mobile devices
- [ ] Verify SSL certificate
- [ ] Set up monitoring/logging
- [ ] Document admin procedures

---

## Phase 2: Admin Panel (Optional)

### Overview

Filament-based admin panel for managing jobs, tasks, templates, and viewing analytics.

### Features

**Dashboard:**
- Analytics overview
- Recent submissions
- Popular jobs/tasks charts
- Quick actions

**Job Management:**
- Create/Read/Update/Delete jobs
- Bulk actions
- Search and filter
- Sort by location

**Task Management:**
- CRUD for tasks
- Physical demand matrix editor
- Equipment list management
- Job relationship manager
- Bulk import/export

**Template Management:**
- Edit Blade templates in-browser
- Syntax highlighting
- Live preview with sample data
- Version history (using Git integration)
- Template validation

**Translation Management:**
- Edit language files
- Add new languages
- Import/export translations

**Analytics Dashboard:**
- Job selection charts
- Task selection charts
- Completion rates
- Date range filters
- Export reports (CSV, PDF)

**User Management:**
- Admin user accounts
- Role-based access control
- Activity logs

### Technology

- **Filament 3.x** - Admin panel framework
- **Filament Tables** - Data tables with filtering/sorting
- **Filament Forms** - Dynamic form builder
- **Filament Widgets** - Dashboard charts and stats
- **Spatie Laravel-permission** - Role/permission management

### Timeline

4 weeks for full admin panel implementation (see Development Timeline section)

---

## Testing Strategy

### Unit Tests

- Model relationships
- Enum functionality
- Service classes
- Helper functions

### Feature Tests

- Form submissions
- Validation rules
- PDF generation
- Template rendering
- Analytics tracking

### Browser Tests (Laravel Dusk)

- Multi-step form navigation
- Job/task selection
- Form validation errors
- PDF download
- Print functionality

### Accessibility Tests

- WAVE browser extension
- axe DevTools
- Lighthouse accessibility audit
- Manual keyboard navigation testing
- Screen reader testing (NVDA, JAWS)

### Testing Commands

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run Dusk browser tests
php artisan dusk

# Code coverage
php artisan test --coverage
```

---

## Maintenance & Support

### Ongoing Tasks

**Weekly:**
- Monitor error logs
- Check analytics for anomalies
- Review form submissions for issues

**Monthly:**
- Database cleanup (old sessions)
- Review and update content as needed
- Check for Laravel/dependency updates

**Quarterly:**
- Security audit
- Performance review
- Accessibility audit
- User feedback review

### Update Process

```bash
# 1. Backup database
php artisan backup:run

# 2. Update dependencies
composer update
npm update && npm run build

# 3. Run migrations (if any)
php artisan migrate

# 4. Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 5. Re-optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Success Metrics

### User Experience

- ✅ Form completion rate > 90%
- ✅ Average completion time < 10 minutes
- ✅ Mobile usage > 30%
- ✅ Bounce rate < 10%

### Accessibility

- ✅ WCAG 2.1 AA compliance (100%)
- ✅ Lighthouse accessibility score > 95
- ✅ Keyboard navigation coverage (100%)
- ✅ Screen reader compatibility verified

### Performance

- ✅ Page load time < 2 seconds
- ✅ Time to Interactive < 3 seconds
- ✅ Core Web Vitals passing
- ✅ PDF generation < 5 seconds

### Technical

- ✅ Zero critical security vulnerabilities
- ✅ Code coverage > 80%
- ✅ Zero accessibility violations
- ✅ Browser compatibility (Chrome, Firefox, Safari, Edge)

---

## Risks & Mitigation

| Risk | Impact | Probability | Mitigation |
|------|--------|-------------|------------|
| Data migration issues | High | Medium | Extensive testing, backup plan, staged rollout |
| Template conversion errors | Medium | Medium | Manual review, diff checking, UAT |
| Hosting environment incompatibility | High | Low | Verify requirements early, test on staging |
| User resistance to new UI | Medium | Medium | Training materials, familiar workflow, feedback loop |
| PDF generation issues | Medium | Low | Test multiple libraries, fallback to print |
| Accessibility gaps | Medium | Low | Automated testing, manual audits, expert review |
| Timeline delays | Medium | Medium | Buffer time built in, prioritize core features |

---

## Conclusion

This rebuild will modernize the EJD application with:

1. **Better User Experience** - Single-page forms, instant validation, mobile-friendly
2. **Improved Accessibility** - WCAG 2.1 AA compliant, keyboard navigation, screen reader support
3. **Enhanced Maintainability** - Modern framework, file-based templates, clean architecture
4. **Simplified Management** - Templates in version control, easy configuration
5. **Basic Analytics** - Track popular jobs/tasks for continuous improvement

**Total Timeline:** 5 weeks for core application + 4 weeks for optional admin panel

**Next Steps:**
1. Approve plan and timeline
2. Provision hosting environment (PHP 8.3)
3. Begin Week 1: Laravel setup and data migration
4. Schedule regular check-ins for progress updates

---

## Appendix

### Legacy Application Reference

The legacy EJD application code is preserved at:
```
/var/www/vhosts/smartwa.org/ejd.smartwa.org
```

Refer to this codebase as needed during the rebuild for:
- Understanding existing business logic and workflows
- Reviewing database queries and data relationships
- Extracting template content and placeholder patterns
- Verifying form field requirements and validation rules

### Glossary

- **EJD** - Employer's Job Description
- **L&I** - Labor & Industries (Washington State Department)
- **WCAG** - Web Content Accessibility Guidelines
- **ARIA** - Accessible Rich Internet Applications
- **Livewire** - Laravel framework for dynamic components without JavaScript
- **Blade** - Laravel's templating engine
- **Eloquent** - Laravel's ORM (Object-Relational Mapping)
- **Filament** - Laravel admin panel framework

### References

- [Laravel Documentation](https://laravel.com/docs/11.x)
- [Livewire Documentation](https://livewire.laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [TailwindCSS Documentation](https://tailwindcss.com/docs)

### Contact

For questions about this rebuild plan, please contact the development team.

---

**Document Version:** 1.0
**Last Updated:** 2025-11-13
**Status:** Draft - Pending Approval
