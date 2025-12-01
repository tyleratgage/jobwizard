# EJD Application Rebuild - Work Breakdown Structure (WBS)

**Project:** Essential Job Duties (EJD) Application Rebuild
**Version:** 1.0
**Created:** November 29, 2025
**Based on:** EJD_REBUILD_PLAN.md and Legacy Application Analysis (/var/www/vhosts/gagedesign.com/ejd.gagedesign.com/docs/EJD_REBUILD_PLAN.md)

---

## Executive Summary

This WBS outlines the complete rebuild of the legacy EJD application from a multi-page PHP form system to a modern Laravel 11 single-page application with Livewire components, TailwindCSS styling, and server-side PDF generation.

**Legacy Application Reference:**
```
/var/www/vhosts/smartwa.org/ejd.smartwa.org
```

---

## 🚀 Next Steps (Pick Up Here)

**Last Updated:** November 30, 2025
**Current Status:** M1 ✅ | M2 ✅ | M3 ✅ (Single-page form complete) | M4 🔄 (75% complete) | M5 ☐

**Live URLs:**
- EJD Form (Legacy Wizard): https://ejd.gagedesign.com/ejd
- EJD Form (New Single-Page): https://ejd.gagedesign.com/ejd-new
- Offer Letter: https://ejd.gagedesign.com/offer-letter

**Architecture Change:** Per Change Order #001 (implemented), the EJD form was rebuilt as a single-page reactive form instead of a 5-step wizard. See `docs/legacy_templates/CHANGE_ORDER_001.md` for details.

### Option A: Finalize EJD Form Cutover
The new single-page EJD form at `/ejd-new` is ready for review. Next steps:
1. Review and test at `/ejd-new`
2. Make any final adjustments
3. Switch `/ejd` route to use `EjdForm` component
4. Archive/delete wizard files

### Option B: Complete M4 Offer Letter System
Template migration and form complete (4.1.1-4.1.8, 4.2.1-4.2.12). Next steps:
1. Write component tests (4.2.13)
2. PDF generation service (4.3.1-4.3.10) - shares Browsershot with EJD

### Option C: Install Browsershot (Enables PDF for both forms)
Install Browsershot and enable PDF generation:
1. Install Chromium/Puppeteer (WBS 1.1.7)
2. Install Spatie Browsershot package (WBS 1.2.7)
3. Integrate PDF generation (WBS 3.5.1-3.5.4, 4.3.1-4.3.10)

### Option D: Polish & Testing
- Searchable job dropdown (3.2.2)
- Keyboard navigation enhancements (3.2.6)
- Component tests (3.4.1-3.4.3)
- Analytics tracking (3.4.4-3.4.5)

### Recent Milestones Completed
- ✅ **Change Order #001 Implemented**: Single-page EJD form replaces 5-step wizard
- ✅ Phone number auto-formatting on EJD and Offer Letter forms
- ✅ Accessibility features added to Offer Letter form (4.2.12)
- ✅ Reactive form with location→jobs→tasks→demands cascade

---

## Project Milestones Overview

| Milestone | Description | Dependencies |
|-----------|-------------|--------------|
| **M1** | Environment & Database Setup Complete | None |
| **M2** | Data Migration & Models Complete | M1 |
| **M3** | EJD Multi-Step Form Functional | M2 |
| **M4** | Offer Letter System with PDF Generation | M2 |
| **M5** | Production-Ready Application (Core Complete) | M3, M4 |
| **M6** | Admin Panel Basic CRUD (Optional) | M5 |
| **M7** | Template & Translation Management (Optional) | M6 |
| **M8** | Analytics Dashboard (Optional) | M6 |
| **M9** | Full Admin Panel Complete (Optional) | M7, M8 |

---

## Phase 1: Core Application

---

### 1.0 Environment Setup & Infrastructure

#### 1.1 Server Environment Configuration
| ID | Task | Status |
|----|------|--------|
| 1.1.1 | Verify PHP 8.3+ availability on hosting | ☑ |
| 1.1.2 | Verify MySQL 8.0+ availability | ☑ |
| 1.1.3 | Install/verify Composer availability | ☑ |
| 1.1.4 | Install/verify Node.js 18+ and npm | ☑ |
| 1.1.5 | Configure subdomain (ejd.gagedesign.com) | ☑ |
| 1.1.6 | Set up SSL certificate for new subdomain | ☑ |
| 1.1.7 | Install Chromium/Puppeteer for PDF generation | ☐ |

#### 1.2 Project Initialization
| ID | Task | Status |
|----|------|--------|
| 1.2.1 | Create new Laravel 12 project | ☑ |
| 1.2.2 | Initialize Git repository | ☑ |
| 1.2.3 | Configure .env for development environment | ☑ |
| 1.2.4 | Install TailwindCSS 4.x via Vite | ☑ |
| 1.2.5 | Install Livewire 3.x | ☑ |
| 1.2.6 | Install Alpine.js (bundled with Livewire) | ☑ |
| 1.2.7 | Install Spatie Browsershot package | ☐ |
| 1.2.8 | Configure database connection | ☑ |
| 1.2.9 | Set up basic application layout template | ☑ |

#### 1.3 Development Workflow Setup
| ID | Task | Status |
|----|------|--------|
| 1.3.1 | Configure code style (Laravel Pint) | ☑ |
| 1.3.2 | Set up Pest PHP for testing | ☑ |
| 1.3.3 | Create README with setup instructions | ☐ |
| 1.3.4 | Document local development workflow | ☐ |

**🎯 Milestone M1 Deliverable:** Working Laravel project with all dependencies installed and configured

**✅ MILESTONE M1 COMPLETE** (2025-11-29)
- Laravel 12.40.2 installed
- PHP 8.3.28, MySQL (MariaDB 10.3), Node.js 22, Composer 2.9
- TailwindCSS v4.1.17 with forms/typography plugins
- Livewire 3.7.0 installed
- Pest PHP 3.8.4 with Laravel plugin
- Git repository initialized, initial commit made

---

### 2.0 Database Design & Migration

#### 2.1 Schema Design
| ID | Task | Status |
|----|------|--------|
| 2.1.1 | Design normalized `jobs` table schema | ☑ |
| 2.1.2 | Design normalized `tasks` table schema (with physical demand columns) | ☑ |
| 2.1.3 | Design `job_task` pivot table schema | ☑ |
| 2.1.4 | Document schema changes from legacy system | ☑ |
| 2.1.5 | Create ER diagram for new schema | ☐ |

#### 2.2 Laravel Migrations
| ID | Task | Status |
|----|------|--------|
| 2.2.1 | Create migration for `jobs` table | ☑ |
| 2.2.2 | Create migration for `tasks` table | ☑ |
| 2.2.3 | Create migration for `job_task` pivot table | ☑ |
| 2.2.4 | Create migration for `form_submissions` table (analytics) | ☑ |
| 2.2.5 | Run migrations and verify structure | ☑ |

#### 2.3 Data Migration Scripts
| ID | Task | Status |
|----|------|--------|
| 2.3.1 | Export legacy `job` table data | ☑ |
| 2.3.2 | Create seeder/script to migrate jobs to new schema | ☑ |
| 2.3.3 | Export legacy `task` table data | ☑ |
| 2.3.4 | Create script to deserialize `t_jobs` arrays | ☑ |
| 2.3.5 | Create seeder/script to migrate tasks to new schema | ☑ |
| 2.3.6 | Create seeder/script to populate `job_task` pivot table | ☑ |
| 2.3.7 | Verify all 63 jobs migrated correctly | ☑ |
| 2.3.8 | Verify all tasks and relationships migrated correctly | ☑ |
| 2.3.9 | Run data integrity tests | ☑ |

#### 2.4 Eloquent Models
| ID | Task | Status |
|----|------|--------|
| 2.4.1 | Create `Job` model with relationships | ☑ |
| 2.4.2 | Create `Task` model with relationships | ☑ |
| 2.4.3 | Create `JobTask` pivot model (if needed) | ☑ |
| 2.4.4 | Create `PhysicalDemandFrequency` enum | ☑ |
| 2.4.5 | Create `JobLocation` enum (Office, Yard, Job) | ☑ |
| 2.4.6 | Write model unit tests | ☑ |

**🎯 Milestone M2 Deliverable:** Fully migrated database with tested Eloquent models

**✅ MILESTONE M2 COMPLETE** (2025-11-30)
- Database schema designed and migrations created (ejd_jobs, ejd_tasks, ejd_job_task, analytics tables)
- Legacy data migrated: 55 jobs, 347 tasks, 346 job-task relationships
- Eloquent models created with full relationships and scopes
- PhysicalDemandFrequency and JobLocation enums implemented
- 27 tests passing (unit and feature tests)

---

### 3.0 EJD Single-Page Form

> **Architecture Change (CO #001):** Replaced the 5-step wizard with a single-page reactive form matching the legacy field structure. See `docs/legacy_templates/CHANGE_ORDER_001.md`.

#### 3.1 Single-Page Form Component
| ID | Task | Status |
|----|------|--------|
| 3.1.1 | Create `EjdForm` Livewire component | ☑ |
| 3.1.2 | Implement reactive dependencies (location→jobs→tasks→demands) | ☑ |
| 3.1.3 | Match legacy field structure (12 core fields) | ☑ |
| 3.1.4 | Implement physical demand calculation (ceiling of average) | ☑ |
| 3.1.5 | Create single-page Blade view with all sections | ☑ |
| 3.1.6 | Add honeypot anti-spam field | ☑ |

#### 3.2 Form Sections Implementation
| ID | Task | Status |
|----|------|--------|
| 3.2.1 | Section 1: Basic Info (employer, phone, title, worker, claim#, date) | ☑ |
| 3.2.2 | Section 2: Job Details (location radios, hours/days selects) | ☑ |
| 3.2.3 | Section 3: Job Selection (multi-select, filtered by location) | ☑ |
| 3.2.4 | Section 4: Tasks (multi-select, filtered by jobs, equipment auto-populate) | ☑ |
| 3.2.5 | Section 5: Physical Demands (17 categories + 3 lifting with lbs) | ☑ |
| 3.2.6 | Implement Select All / Clear All for tasks | ☑ |
| 3.2.7 | Phone number auto-formatting (xxx-xxx-xxxx) | ☑ |
| 3.2.8 | Style with TailwindCSS (mobile-responsive) | ☑ |
| 3.2.9 | Add searchable job dropdown | ☐ |
| 3.2.10 | Add keyboard navigation enhancements | ☐ |

#### 3.3 Validation & State
| ID | Task | Status |
|----|------|--------|
| 3.3.1 | Implement real-time validation | ☑ |
| 3.3.2 | Required field validation with custom messages | ☑ |
| 3.3.3 | Conditional lbs validation (required when frequency > Never) | ☑ |
| 3.3.4 | Cascade clearing on dependency change | ☑ |

#### 3.4 Preview & Output
| ID | Task | Status |
|----|------|--------|
| 3.4.1 | Create preview mode toggle | ☑ |
| 3.4.2 | Create printable form layout (matching legacy) | ☑ |
| 3.4.3 | Implement browser print functionality | ☑ |
| 3.4.4 | Create print stylesheet | ☑ |
| 3.4.5 | Add "Edit Form" button from preview | ☑ |

#### 3.5 PDF Generation (Pending Browsershot)
| ID | Task | Status |
|----|------|--------|
| 3.5.1 | Create `EjdPdfService` class | ☐ |
| 3.5.2 | Configure Browsershot for PDF generation | ☐ |
| 3.5.3 | Add "Download PDF" button | ☐ |
| 3.5.4 | Test PDF output quality | ☐ |

#### 3.6 Testing & Analytics
| ID | Task | Status |
|----|------|--------|
| 3.6.1 | Write component tests | ☐ |
| 3.6.2 | Write integration tests | ☐ |
| 3.6.3 | Log form completion for analytics | ☐ |

#### 3.7 Cutover Tasks
| ID | Task | Status |
|----|------|--------|
| 3.7.1 | Final review of `/ejd-new` form | ☐ |
| 3.7.2 | Switch `/ejd` route to `EjdForm` component | ☐ |
| 3.7.3 | Archive wizard files to `docs/legacy_templates/` | ☐ |
| 3.7.4 | Delete `EjdWizard` component and related files | ☐ |
| 3.7.5 | Update tests to use new component | ☐ |

**🎯 Milestone M3 Deliverable:** Fully functional single-page EJD form with validation and PDF output

**✅ MILESTONE M3 CORE COMPLETE** (2025-11-30)
- Single-page reactive form implemented (`EjdForm.php`)
- All 5 sections matching legacy field structure
- Reactive cascade: location → jobs → tasks → equipment → physical demands
- Physical demand calculation using ceiling of average (legacy logic)
- Print functionality working
- PDF generation pending Browsershot installation

---

### 4.0 Offer Letter System

#### 4.1 Template Migration
| ID | Task | Status |
|----|------|--------|
| 4.1.1 | Export 6 offer letter templates from `offerLetter2021` table | ☑ |
| 4.1.2 | Create Blade template for English Permanent letter | ☑ |
| 4.1.3 | Create Blade template for English Temporary letter | ☑ |
| 4.1.4 | Create Blade template for Spanish Permanent letter | ☑ |
| 4.1.5 | Create Blade template for Spanish Temporary letter | ☑ |
| 4.1.6 | Create Blade template for Russian Permanent letter | ☑ |
| 4.1.7 | Create Blade template for Russian Temporary letter | ☑ |
| 4.1.8 | Convert `[[placeholder]]` syntax to Blade `{{ $variable }}` | ☑ |
| 4.1.9 | Verify all templates render correctly | ☐ |

#### 4.2 Offer Letter Form
| ID | Task | Status |
|----|------|--------|
| 4.2.1 | Create `OfferLetterForm` Livewire component | ☑ |
| 4.2.2 | Implement language selector (English, Spanish, Russian) | ☑ |
| 4.2.3 | Implement type selector (Permanent, Temporary) | ☑ |
| 4.2.4 | Implement worker details fields | ☑ |
| 4.2.5 | Implement supervisor/HR fields | ☑ |
| 4.2.6 | Implement date/time fields | ☑ |
| 4.2.7 | Implement schedule fields | ☑ |
| 4.2.8 | Implement compensation fields | ☑ |
| 4.2.9 | Implement CC recipients field | ☑ |
| 4.2.10 | Add real-time validation | ☑ |
| 4.2.11 | Style with TailwindCSS (mobile-responsive) | ☑ |
| 4.2.12 | Add accessibility features | ☑ |
| 4.2.13 | Write component tests | ☐ |

#### 4.3 PDF Generation Service
| ID | Task | Status |
|----|------|--------|
| 4.3.1 | Create `OfferLetterPdfService` class | ☐ |
| 4.3.2 | Configure Browsershot for PDF generation | ☐ |
| 4.3.3 | Set up PDF page size and margins | ☐ |
| 4.3.4 | Implement template rendering with data | ☐ |
| 4.3.5 | Implement PDF download response | ☐ |
| 4.3.6 | Add browser preview functionality | ☐ |
| 4.3.7 | Test PDF output for all 6 template combinations | ☐ |
| 4.3.8 | Verify character encoding for Spanish/Russian | ☐ |
| 4.3.9 | Log offer letter generation for analytics | ☐ |
| 4.3.10 | Write service tests | ☐ |

**🎯 Milestone M4 Deliverable:** Working offer letter system with PDF generation for all languages/types

---

### 5.0 Accessibility & Quality Assurance

#### 5.1 Accessibility Audit
| ID | Task | Status |
|----|------|--------|
| 5.1.1 | Run WAVE accessibility checker on all pages | ☐ |
| 5.1.2 | Run axe DevTools accessibility audit | ☐ |
| 5.1.3 | Run Lighthouse accessibility audit | ☐ |
| 5.1.4 | Verify color contrast ratios (≥4.5:1 for normal text) | ☐ |
| 5.1.5 | Test keyboard navigation (Tab, Shift+Tab, Enter, Space, Arrows) | ☐ |
| 5.1.6 | Test with NVDA screen reader | ☐ |
| 5.1.7 | Test with JAWS screen reader (if available) | ☐ |
| 5.1.8 | Verify ARIA labels are descriptive | ☐ |
| 5.1.9 | Test focus indicators visibility | ☐ |
| 5.1.10 | Document and fix all WCAG 2.1 AA violations | ☐ |

#### 5.2 Cross-Browser Testing
| ID | Task | Status |
|----|------|--------|
| 5.2.1 | Test in Google Chrome (latest) | ☐ |
| 5.2.2 | Test in Mozilla Firefox (latest) | ☐ |
| 5.2.3 | Test in Safari (latest) | ☐ |
| 5.2.4 | Test in Microsoft Edge (latest) | ☐ |
| 5.2.5 | Document and fix browser-specific issues | ☐ |

#### 5.3 Mobile Responsive Testing
| ID | Task | Status |
|----|------|--------|
| 5.3.1 | Test on iPhone (Safari) | ☐ |
| 5.3.2 | Test on Android (Chrome) | ☐ |
| 5.3.3 | Test on tablet devices | ☐ |
| 5.3.4 | Verify touch targets are adequate size (44x44px) | ☐ |
| 5.3.5 | Verify forms are usable on small screens | ☐ |
| 5.3.6 | Document and fix responsive issues | ☐ |

#### 5.4 Print & PDF Testing
| ID | Task | Status |
|----|------|--------|
| 5.4.1 | Test browser print on all major browsers | ☐ |
| 5.4.2 | Verify print stylesheet removes navigation elements | ☐ |
| 5.4.3 | Test PDF generation quality | ☐ |
| 5.4.4 | Verify PDF content matches browser preview | ☐ |
| 5.4.5 | Test PDF on multiple PDF readers | ☐ |

#### 5.5 Security Audit
| ID | Task | Status |
|----|------|--------|
| 5.5.1 | Verify CSRF protection on all forms | ☐ |
| 5.5.2 | Test for XSS vulnerabilities | ☐ |
| 5.5.3 | Verify input sanitization | ☐ |
| 5.5.4 | Test honeypot spam protection | ☐ |
| 5.5.5 | Review Laravel security best practices | ☐ |
| 5.5.6 | Document security measures | ☐ |

#### 5.6 Performance Optimization
| ID | Task | Status |
|----|------|--------|
| 5.6.1 | Run Lighthouse performance audit | ☐ |
| 5.6.2 | Optimize asset loading (Vite bundling) | ☐ |
| 5.6.3 | Implement lazy loading where appropriate | ☐ |
| 5.6.4 | Configure caching headers | ☐ |
| 5.6.5 | Optimize database queries (N+1 prevention) | ☐ |
| 5.6.6 | Document performance benchmarks | ☐ |

#### 5.7 Deployment Preparation
| ID | Task | Status |
|----|------|--------|
| 5.7.1 | Create production .env configuration | ☐ |
| 5.7.2 | Set up production database | ☐ |
| 5.7.3 | Run migrations on production | ☐ |
| 5.7.4 | Seed production data | ☐ |
| 5.7.5 | Configure production Browsershot | ☐ |
| 5.7.6 | Deploy to staging environment | ☐ |
| 5.7.7 | Perform UAT (User Acceptance Testing) | ☐ |
| 5.7.8 | Document deployment procedure | ☐ |
| 5.7.9 | Create rollback plan | ☐ |
| 5.7.10 | Deploy to production | ☐ |
| 5.7.11 | Verify production functionality | ☐ |
| 5.7.12 | Monitor for errors post-deployment | ☐ |

**🎯 Milestone M5 Deliverable:** Production-ready, accessible, tested application deployed

---

## Phase 2: Admin Panel (Optional)

---

### 6.0 Filament Admin Panel Setup

#### 6.1 Filament Installation
| ID | Task | Status |
|----|------|--------|
| 6.1.1 | Install Filament admin panel package | ☐ |
| 6.1.2 | Publish Filament configuration | ☐ |
| 6.1.3 | Configure Filament appearance/branding | ☐ |
| 6.1.4 | Set up admin authentication | ☐ |
| 6.1.5 | Create admin user seeder | ☐ |
| 6.1.6 | Secure admin routes | ☐ |

#### 6.2 Job Management CRUD
| ID | Task | Status |
|----|------|--------|
| 6.2.1 | Create `JobResource` Filament resource | ☐ |
| 6.2.2 | Implement job list view with search/filter | ☐ |
| 6.2.3 | Implement job create form | ☐ |
| 6.2.4 | Implement job edit form | ☐ |
| 6.2.5 | Implement job delete with confirmation | ☐ |
| 6.2.6 | Add bulk actions (delete, export) | ☐ |
| 6.2.7 | Implement CSV/Excel import | ☐ |
| 6.2.8 | Implement CSV/Excel export | ☐ |
| 6.2.9 | Write resource tests | ☐ |

#### 6.3 Task Management CRUD
| ID | Task | Status |
|----|------|--------|
| 6.3.1 | Create `TaskResource` Filament resource | ☐ |
| 6.3.2 | Implement task list view with search/filter | ☐ |
| 6.3.3 | Implement physical demand matrix editor | ☐ |
| 6.3.4 | Implement job association management | ☐ |
| 6.3.5 | Implement equipment field editor | ☐ |
| 6.3.6 | Implement task create form | ☐ |
| 6.3.7 | Implement task edit form | ☐ |
| 6.3.8 | Implement task delete with confirmation | ☐ |
| 6.3.9 | Add bulk actions | ☐ |
| 6.3.10 | Implement CSV/Excel import | ☐ |
| 6.3.11 | Implement CSV/Excel export | ☐ |
| 6.3.12 | Write resource tests | ☐ |

**🎯 Milestone M6 Deliverable:** Admin panel with job and task CRUD functionality

---

### 7.0 Template & Translation Management

#### 7.1 Offer Letter Template Management
| ID | Task | Status |
|----|------|--------|
| 7.1.1 | Create template listing view | ☐ |
| 7.1.2 | Create template editor with code highlighting | ☐ |
| 7.1.3 | Implement live preview functionality | ☐ |
| 7.1.4 | Add placeholder documentation/helper | ☐ |
| 7.1.5 | Implement template versioning (Git integration) | ☐ |
| 7.1.6 | Add template validation | ☐ |
| 7.1.7 | Write management tests | ☐ |

#### 7.2 Translation Management
| ID | Task | Status |
|----|------|--------|
| 7.2.1 | Evaluate/integrate translation management package | ☐ |
| 7.2.2 | Create translation listing view | ☐ |
| 7.2.3 | Implement translation editor by language | ☐ |
| 7.2.4 | Implement missing translation detection | ☐ |
| 7.2.5 | Add new language support capability | ☐ |
| 7.2.6 | Implement translation import/export | ☐ |
| 7.2.7 | Write translation management tests | ☐ |

**🎯 Milestone M7 Deliverable:** Template and translation management system

---

### 8.0 Analytics Dashboard

#### 8.1 Analytics Data Collection
| ID | Task | Status |
|----|------|--------|
| 8.1.1 | Create `form_submissions` table if not exists | ☐ |
| 8.1.2 | Create `analytics_events` table | ☐ |
| 8.1.3 | Implement job selection tracking | ☐ |
| 8.1.4 | Implement task selection tracking | ☐ |
| 8.1.5 | Implement form completion tracking | ☐ |
| 8.1.6 | Implement offer letter generation tracking | ☐ |
| 8.1.7 | Ensure no PII is stored | ☐ |

#### 8.2 Dashboard Widgets
| ID | Task | Status |
|----|------|--------|
| 8.2.1 | Create dashboard layout | ☐ |
| 8.2.2 | Implement "Most Selected Jobs" chart | ☐ |
| 8.2.3 | Implement "Most Selected Tasks" chart | ☐ |
| 8.2.4 | Implement "Form Completions Over Time" chart | ☐ |
| 8.2.5 | Implement "Offer Letters by Type/Language" chart | ☐ |
| 8.2.6 | Add date range filter | ☐ |
| 8.2.7 | Implement comparison periods (this week vs last week) | ☐ |

#### 8.3 Reporting
| ID | Task | Status |
|----|------|--------|
| 8.3.1 | Create analytics report view | ☐ |
| 8.3.2 | Implement CSV export for reports | ☐ |
| 8.3.3 | Implement PDF export for reports | ☐ |
| 8.3.4 | Add scheduled report capability (optional) | ☐ |
| 8.3.5 | Write analytics tests | ☐ |

**🎯 Milestone M8 Deliverable:** Analytics dashboard with charts and reporting

---

### 9.0 Admin Panel Finalization

#### 9.1 Admin Panel Testing
| ID | Task | Status |
|----|------|--------|
| 9.1.1 | Test all CRUD operations | ☐ |
| 9.1.2 | Test import/export functionality | ☐ |
| 9.1.3 | Test template management | ☐ |
| 9.1.4 | Test analytics accuracy | ☐ |
| 9.1.5 | Test admin authentication/authorization | ☐ |
| 9.1.6 | Performance testing | ☐ |

#### 9.2 Documentation
| ID | Task | Status |
|----|------|--------|
| 9.2.1 | Create admin user guide | ☐ |
| 9.2.2 | Create job/task management guide | ☐ |
| 9.2.3 | Create template editing guide | ☐ |
| 9.2.4 | Create analytics interpretation guide | ☐ |
| 9.2.5 | Create troubleshooting guide | ☐ |

#### 9.3 Training
| ID | Task | Status |
|----|------|--------|
| 9.3.1 | Create training materials | ☐ |
| 9.3.2 | Record video walkthroughs (optional) | ☐ |
| 9.3.3 | Conduct admin user training session | ☐ |

**🎯 Milestone M9 Deliverable:** Complete admin panel with documentation and training

---

## Risk Register

| ID | Risk | Probability | Impact | Mitigation |
|----|------|-------------|--------|------------|
| R1 | Data migration corrupts job/task relationships | Medium | High | Extensive testing, backup legacy DB, staged rollout |
| R2 | Browsershot/Chromium fails on hosting | Medium | High | Test early, have fallback print-to-PDF option |
| R3 | Russian/Spanish character encoding issues | Medium | Medium | Test UTF-8 throughout, verify fonts in PDF |
| R4 | Legacy app must remain operational during transition | High | Medium | Deploy to new subdomain, parallel operation |
| R5 | Accessibility requirements not met | Low | High | Automated + manual testing, expert review |
| R6 | Performance issues with Livewire | Low | Medium | Optimize queries, implement caching |

---

## Dependency Graph

```
1.0 Environment Setup
    └── 2.0 Database Design & Migration
            ├── 3.0 EJD Multi-Step Form ──────┐
            │                                  ├── 5.0 QA & Accessibility
            └── 4.0 Offer Letter System ──────┘
                                                      │
                                                      ▼
                                            6.0 Filament Admin (Optional)
                                                      │
                                    ┌─────────────────┼─────────────────┐
                                    ▼                 ▼                 ▼
                        7.0 Template Mgmt    8.0 Analytics    (parallel work)
                                    │                 │
                                    └────────┬────────┘
                                             ▼
                                    9.0 Admin Finalization
```

---

## Summary Statistics

| Category | Count |
|----------|-------|
| **Phase 1 Tasks** | ~95 |
| **Phase 2 Tasks** | 58 |
| **Total Tasks** | ~153 |
| **Milestones** | 9 |

> *Note: Task count updated after Change Order #001 (wizard→single-page form)*

---

## Appendix A: Physical Demand Categories

The following physical demand categories must be tracked for each task:

1. Sitting
2. Standing
3. Walking
4. Foot Driving
5. Lifting
6. Carrying
7. Pushing/Pulling
8. Climbing
9. Bending
10. Twisting
11. Kneeling
12. Crouching
13. Crawling
14. Squatting
15. Reaching Overhead
16. Reaching Outward
17. Repetitive Motions
18. Handling
19. Fine Manipulation
20. Talk/Hear/See
21. Vibratory
22. Other

**Frequency Scale:**
- 0 = Never (not at all)
- 1 = Seldom (1-10% of the time)
- 2 = Occasional (11-33% of the time)
- 3 = Frequent (34-66% of the time)
- 4 = Constant (67-100% of the time)

---

## Appendix B: Technology Stack Reference

| Component | Technology | Version (Actual) |
|-----------|------------|------------------|
| Backend Framework | Laravel | 12.40.2 |
| PHP Version | PHP | 8.3.28 |
| Database | MariaDB | 10.3.39 |
| Frontend CSS | TailwindCSS | 4.1.17 |
| Frontend JS | Alpine.js | 3.x (bundled with Livewire) |
| Reactivity | Livewire | 3.7.0 |
| PDF Generation | Spatie Browsershot | TBD |
| Admin Panel | Filament | 3.x (Phase 2) |
| Testing | Pest PHP | 3.8.4 |
| Asset Bundling | Vite | 7.2.4 |
| Node.js | Node.js | 22.0.0 |
| Package Manager | npm | 10.5.1 |

---

## Appendix C: Legacy Application Reference

The legacy EJD application is preserved at:
```
/var/www/vhosts/smartwa.org/ejd.smartwa.org
```

**Key Legacy Files to Reference:**
| File/Directory | Purpose |
|----------------|---------|
| `z_inc/inc.helper.php` | Central business logic orchestrator |
| `z_inc/inc.controller.php` | Form routing & validation |
| `z_inc/inc.queries.php` | Database queries |
| `z_view/ejd/` | 4-step EJD form templates |
| `z_view/offerLetter/` | Offer letter templates |
| `z_PFBC/` | Legacy form builder library |

---

*Document maintained as part of the EJD Rebuild Project*
