# EJD Application

Essential Job Description form generator for Washington State Department of Labor and Industries.

## Routes

- `/` - Home page
- `/ejd` - Essential Job Description form (main application)
- `/offer-letter` - Offer Letter form
- `/privacy` - Privacy policy

## Architecture

### EJD Form (`/ejd`)

Single-page reactive form built with Livewire. Located at:
- Component: `app/Livewire/Ejd/EjdForm.php`
- Views: `resources/views/livewire/ejd/`
- PDF Template: `resources/views/pdf/ejd.blade.php`

### Key Features

- Multi-select job positions filtered by location (Office, Yard, Job Site)
- Task selection with auto-calculated physical demands
- PDF generation via Browsershot
- Preset system for saving/sharing form configurations via URL tokens

### Form Fields

| Field | Required | Notes |
|-------|----------|-------|
| Employer Name | Yes | |
| Phone | Yes | Auto-formatted xxx-xxx-xxxx |
| Fax | No | For provider to return completed form |
| Title | Yes | Position of person filling form |
| Worker Name | Yes | |
| Claim # | No | |
| Date | Yes | |
| Location | Yes | Office/Yard/Job Site |
| Hours/Days | Yes | |
| Job Title(s) | Yes | Multi-select |
| Tasks | Yes | Multi-select |

## Tech Stack

- Laravel 11, Livewire 3, Alpine.js, Tailwind CSS
- PDF: Spatie Browsershot

## Database

- `ejd_jobs` - Job positions with DOT codes
- `ejd_tasks` - Tasks with physical demand ratings
- `ejd_job_task` - Pivot table
- `form_completions` - Usage tracking

## Deprecation Notes

The multi-step wizard form has been removed. Only the single-page form at `/ejd` is maintained.
