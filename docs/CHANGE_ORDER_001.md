# Change Order #001 - EJD Form Simplification

**Date:** November 30, 2025
**Status:** PENDING APPROVAL
**Priority:** HIGH - Core Functionality Issue
**Affects:** Milestone M3 (EJD Multi-Step Form)

---

## Summary

The current 5-step wizard implementation deviates significantly from the legacy application and over-engineers what is essentially a simple dependent form. This change order proposes replacing the multi-step wizard with a single-page reactive form that matches the legacy field structure exactly.

---

## Current State vs Proposed State

| Aspect | Current (New App) | Proposed | Legacy |
|--------|-------------------|----------|--------|
| Form structure | 5-step wizard | Single page | 4 pages |
| Field count | 20+ fields | 12 fields | 12 fields |
| Dependencies | Step-based | AJAX/Livewire reactive | Page refresh |
| State management | Session persistence | Simple component state | Session |
| Code complexity | High (5 views, wizard logic) | Low (1 view, reactive) | Medium |

---

## Proposed Single-Page Form Layout

```
┌─────────────────────────────────────────────────────────────────┐
│  EMPLOYER'S JOB DESCRIPTION - Light Duty/Transitional          │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  SECTION 1: Basic Information                                   │
│  ───────────────────────────────────────────────────────────    │
│  Employer Name: [__________________]  Phone #: [__________]     │
│  Title: [__________________]                                    │
│  Worker Name: [__________________]   Claim #: [__________]      │
│  Date: [__________]                                             │
│                                                                 │
│  SECTION 2: Job Details                                         │
│  ───────────────────────────────────────────────────────────    │
│  Location:  ○ Office   ○ Yard/Warehouse   ○ Job Site           │
│  Hours per day: [▼ 0-10]     Days per week: [▼ 0-5]            │
│                                                                 │
│  SECTION 3: Job Title  [shows when location selected]          │
│  ───────────────────────────────────────────────────────────    │
│  Select job title(s):                                           │
│  ☐ Accountant (ACC)          ☐ Admin Assistant (ADM)           │
│  ☐ ... [filtered by location]                                   │
│                                                                 │
│  SECTION 4: Tasks  [shows when job selected]                   │
│  ───────────────────────────────────────────────────────────    │
│  Check or uncheck tasks as needed:                              │
│  ☑ Task 1 (T001)    ☑ Task 2 (T002)    ☐ Task 3 (T003)         │
│  ...                                                            │
│  Additional Task: [__________________] (optional)               │
│                                                                 │
│  Equipment & Tools:                                             │
│  [textarea - pre-populated from selected tasks, editable]       │
│                                                                 │
│  SECTION 5: Physical Demands  [calculates when tasks change]   │
│  ───────────────────────────────────────────────────────────    │
│  N=Never  S=Seldom  O=Occasional  F=Frequent  C=Constant       │
│                                                                 │
│  Sitting            ○N ○S ●O ○F ○C  [________________]          │
│  Standing           ○N ●S ○O ○F ○C  [________________]          │
│  Walking            ○N ○S ●O ○F ○C  [________________]          │
│  Climbing           ○N ●S ○O ○F ○C  [________________]          │
│  Twisting           ○N ○S ○O ●F ○C  [________________]          │
│  Bending/Stooping   ○N ○S ●O ○F ○C  [________________]          │
│  Squatting/Kneeling ○N ●S ○O ○F ○C  [________________]          │
│  Crawling           ●N ○S ○O ○F ○C  [________________]          │
│  Reaching Out       ○N ○S ●O ○F ○C  [________________]          │
│  Above Shoulders    ○N ●S ○O ○F ○C  [________________]          │
│  Handling/Grasping  ○N ○S ○O ●F ○C  [________________]          │
│  Fine Manipulation  ○N ○S ●O ○F ○C  [________________]          │
│  Foot Controls      ○N ●S ○O ○F ○C  [________________]          │
│  Repetitive Motion  ○N ○S ●O ○F ○C  [________________]          │
│  Talk/Hear/See      ○N ○S ○O ○F ●C  [________________]          │
│  Vibratory Tasks    ●N ○S ○O ○F ○C  [________________]          │
│  Comments/Other     ○N ○S ○O ○F ○C  [________________]          │
│  [Additional Task]  ○N ○S ○O ○F ○C  [________________]          │
│  ───────────────────────────────────────────────────────────    │
│  LIFTING/PUSHING                                                │
│  Lifting      [___] lbs  ○N ○S ○O ○F ○C  [________________]     │
│  Carrying     [___] lbs  ○N ○S ○O ○F ○C  [________________]     │
│  Pushing      [___] lbs  ○N ○S ○O ○F ○C  [________________]     │
│                                                                 │
│                    [ Generate Form ]                            │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

---

## Field Specification (Matching Legacy Exactly)

### Section 1: Basic Information

| Field | Name | Type | Required | Validation |
|-------|------|------|----------|------------|
| Employer Name | `employer` | text | Yes | max:255 |
| Phone # | `phone` | tel | Yes | phone format |
| Title | `title` | text | Yes | max:255 |
| Worker Name | `workerName` | text | Yes | max:255 |
| Claim # | `claimNo` | text | No | max:50 |
| Date | `date` | date | Yes | valid date |

### Section 2: Job Details

| Field | Name | Type | Required | Options |
|-------|------|------|----------|---------|
| Location | `location` | radio | Yes | office, yard, job |
| Hours per day | `hrPerDay` | select | Yes | 0-10 |
| Days per week | `daysWkPerShift` | select | Yes | 0-5 |

### Section 3: Job Title

| Field | Name | Type | Required | Notes |
|-------|------|------|----------|-------|
| Job Title(s) | `jobTitle` | checkbox[] | Yes | Filtered by location, multi-select |

### Section 4: Tasks

| Field | Name | Type | Required | Notes |
|-------|------|------|----------|-------|
| Tasks | `tasks` | checkbox[] | Yes | Filtered by selected jobs |
| Additional Task | `newTask` | text | No | Custom task name |
| Equipment | `toolsEquipment` | textarea | Yes | Pre-populated, editable |

### Section 5: Physical Demands

| Field Pattern | Type | Required | Notes |
|---------------|------|----------|-------|
| `freq{Category}` | radio (1-5) | Yes | N/S/O/F/C, pre-calculated |
| `desc{Category}` | text | No | Description per category |
| `lbs{Lift\|Carry\|Push}` | text | Conditional | Required if frequency > N |
| `freqLift`, `freqCarry`, `freqPush` | radio (1-5) | Yes | Separate from main demands |
| `descLift`, `descCarry`, `descPush` | text | No | Description |

**Physical Demand Categories (17 + 3):**
```
sit, stand, walk, climb, twist, bend, knee, crawl,
reachOut, aboveShoulders, handle, manipulation,
footDrive, repetitive, talkHearSee, vibratory, other
---
lift, carry, push (with lbs field)
```

---

## Reactive Dependencies (Livewire)

```
┌──────────────┐
│   Location   │
│   (radio)    │
└──────┬───────┘
       │ wire:model.live
       ▼
┌──────────────┐
│  Job Titles  │◄─── Filtered by location
│ (checkboxes) │
└──────┬───────┘
       │ wire:model.live
       ▼
┌──────────────┐
│    Tasks     │◄─── Filtered by selected job(s)
│ (checkboxes) │
└──────┬───────┘
       │ wire:model.live
       ▼
┌──────────────┐     ┌──────────────┐
│  Equipment   │◄────│ Pre-populate │
│  (textarea)  │     │ from tasks   │
└──────────────┘     └──────────────┘
       │
       ▼
┌──────────────┐     ┌──────────────┐
│   Physical   │◄────│   Calculate  │
│   Demands    │     │   averages   │
│   (radios)   │     └──────────────┘
└──────────────┘
```

---

## Implementation Plan

### Files to Create/Modify

| Action | File | Description |
|--------|------|-------------|
| REPLACE | `app/Livewire/Ejd/EjdWizard.php` | Rename to `EjdForm.php`, simplify |
| DELETE | `app/Services/EjdFormStateService.php` | No longer needed |
| REPLACE | `resources/views/livewire/ejd/ejd-wizard.blade.php` | Single form view |
| DELETE | `resources/views/livewire/ejd/steps/*.blade.php` | Remove all step files |
| DELETE | `resources/views/livewire/ejd/partials/progress-indicator.blade.php` | Not needed |
| CREATE | `resources/views/livewire/ejd/printable.blade.php` | Print/PDF layout |
| MODIFY | `routes/web.php` | Update route if component renamed |

### New Component Structure

```php
// app/Livewire/Ejd/EjdForm.php

class EjdForm extends Component
{
    // Section 1: Basic Info
    public string $employer = '';
    public string $phone = '';
    public string $title = '';
    public string $workerName = '';
    public string $claimNo = '';
    public string $date = '';

    // Section 2: Job Details
    public string $location = '';
    public int $hrPerDay = 0;
    public int $daysWkPerShift = 0;

    // Section 3: Job Selection
    public array $jobTitle = [];

    // Section 4: Tasks
    public array $tasks = [];
    public string $newTask = '';
    public string $toolsEquipment = '';

    // Section 5: Physical Demands (frequencies)
    public array $frequencies = []; // freq{Category} => 1-5
    public array $descriptions = []; // desc{Category} => string

    // Lifting/Carrying/Pushing
    public string $lbsLift = '';
    public string $lbsCarry = '';
    public string $lbsPush = '';

    // Honeypot
    public string $mycompany = '';

    // Computed properties
    #[Computed]
    public function availableJobs() { /* filter by location */ }

    #[Computed]
    public function availableTasks() { /* filter by jobTitle */ }

    // Reactive hooks
    public function updatedLocation() { $this->jobTitle = []; }
    public function updatedJobTitle() { $this->tasks = []; $this->updateEquipment(); }
    public function updatedTasks() { $this->calculatePhysicalDemands(); }
}
```

---

## Physical Demand Calculation

**Legacy Logic (from page_4.php):**
```php
// Sum frequencies across selected tasks, then AVERAGE (ceiling)
foreach ($physicalDemands as $k => $v) {
    for ($x = 0; $x < count($arrTasks); $x++) {
        $physicalDemands[$k]['freq'] += $arrTasks[$x]['t_' . $k];
    }
}
$numTask = count($arrTasks);
foreach ($physicalDemands as $k => $v) {
    $physicalDemands[$k]['freq'] = ceil($physicalDemands[$k]['freq'] / $numTask);
    $physicalDemands[$k]['freq'] += 1; // Adjust for 1-based radio
}
```

**New Implementation:**
```php
public function calculatePhysicalDemands(): void
{
    $tasks = Task::whereIn('id', $this->tasks)->get();
    $count = $tasks->count();

    if ($count === 0) {
        $this->frequencies = array_fill_keys(self::PHYSICAL_DEMANDS, 1);
        return;
    }

    foreach (self::PHYSICAL_DEMANDS as $demand) {
        $sum = $tasks->sum($demand);
        $avg = (int) ceil($sum / $count);
        $this->frequencies[$demand] = $avg + 1; // 1-based for radio (1=N, 2=S, etc.)
    }
}
```

---

## Print/PDF Output

The final generated form must match the legacy layout:

1. **Header:** L&I billing codes, WA seal
2. **Job type checkboxes:** Job of Injury / Permanent Modified / Light duty (pre-checked)
3. **General info grid:** Worker, Claim#, Company, Job Title, Phone, Days/Hours, etc.
4. **Essential Job Duties:** Comma-separated task list
5. **Equipment section:** Tools/equipment text
6. **Frequency legend:** N/S/O/F/C definitions
7. **Physical Demands table:** 3 columns (Demand, Frequency, Description)
8. **Lifting/Pushing section:** With lbs values
9. **Health Provider section:** Approval checkboxes, signature lines

---

## Migration Path

### Step 1: Create new component (preserve old)
- Create `EjdForm.php` alongside `EjdWizard.php`
- Create new view `ejd-form.blade.php`
- Add temporary route `/ejd-new` for testing

### Step 2: Test thoroughly
- Compare output with legacy form
- Verify all field mappings
- Test print layout

### Step 3: Switch over
- Update `/ejd` route to use new component
- Archive or delete wizard files

### Step 4: Clean up
- Remove wizard-related code
- Remove `EjdFormStateService`
- Update WBS document

---

## Benefits of This Approach

| Benefit | Description |
|---------|-------------|
| **Parity with legacy** | Exact same fields, same behavior |
| **Simpler code** | ~200 lines vs ~500+ lines |
| **Better UX** | No artificial page breaks, instant feedback |
| **Easier maintenance** | One file to understand |
| **Faster performance** | No session round-trips between steps |
| **Mobile friendly** | Scrollable form works on all devices |

---

## Questions for Stakeholder

1. **Multi-job selection:** Legacy allows multiple jobs. Keep this behavior? (Recommended: Yes, match legacy)

2. **Print vs PDF:** Is browser print sufficient for initial release, or is PDF generation required before go-live?

3. **Validation timing:** Validate on blur, on submit, or both?

---

## Approval

| Role | Name | Date | Signature |
|------|------|------|-----------|
| Project Owner | | | |
| Developer | | | |

---

## Revision History

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0 | 2025-11-30 | Claude | Initial change order - single page approach |
