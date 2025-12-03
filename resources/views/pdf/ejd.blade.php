<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer's Job Description</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.3;
            color: #000;
        }
        .container {
            padding: 0.25in;
            max-width: 8.5in;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .header-left {
            font-size: 9pt;
            line-height: 1.4;
        }
        .header-left .bold {
            font-weight: bold;
        }
        .header-right {
            text-align: right;
        }
        .header-right .title {
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 8px;
        }
        .header-right .checkbox {
            font-size: 9pt;
            margin: 2px 0;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }
        .info-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: top;
        }
        .info-table .label {
            font-weight: bold;
            font-size: 9pt;
        }
        .info-table .value {
            font-size: 10pt;
            margin-left: 8px;
        }
        .section {
            border: 1px solid #000;
            border-top: none;
            padding: 10px;
        }
        .section-title {
            font-weight: bold;
            font-size: 9pt;
            margin-bottom: 4px;
        }
        .section-content {
            font-size: 10pt;
        }
        .frequency-guide {
            border: 1px solid #000;
            border-top: none;
            padding: 8px;
            font-size: 9pt;
        }
        .frequency-guide .row {
            display: flex;
            flex-wrap: wrap;
        }
        .frequency-guide .item {
            width: 33.33%;
        }
        .demands-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        .demands-table th,
        .demands-table td {
            border: 1px solid #000;
            padding: 4px 6px;
        }
        .demands-table th {
            background-color: #f0f0f0;
            text-align: left;
            font-weight: bold;
        }
        .demands-table .freq {
            text-align: center;
            font-weight: bold;
            width: 60px;
        }
        .demands-table .demand-name {
            width: 25%;
        }
        .provider-section {
            border: 1px solid #000;
            border-top: none;
        }
        .provider-header {
            background-color: #e0e0e0;
            padding: 8px;
            font-weight: bold;
            text-align: center;
            font-size: 10pt;
            border-bottom: 1px solid #000;
        }
        .provider-content {
            padding: 12px;
        }
        .provider-row {
            display: flex;
            margin-bottom: 10px;
        }
        .provider-col {
            width: 50%;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            height: 20px;
            margin-top: 15px;
        }
        .signature-section {
            border: 1px solid #000;
            border-top: none;
            padding: 12px;
        }
        .signature-row {
            display: flex;
        }
        .signature-col {
            flex: 1;
            padding: 0 10px;
        }
        .signature-col:first-child {
            padding-left: 0;
        }
        .signature-col:last-child {
            padding-right: 0;
        }
        .signature-label {
            font-size: 9pt;
            margin-bottom: 4px;
        }
        .signature-label .italic {
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header --}}
        <div class="header">
            <div class="header-left">
                <div>Department of Labor and Industries</div>
                <div class="bold">Physician Billing codes</div>
                <div class="bold">Review of Job Analysis and Job Description</div>
                <div>1038M-Limit one per day</div>
                <div>1028M-Each additional review, up to five per worker per day</div>
            </div>
            <div class="header-right">
                <div class="title">EMPLOYER'S JOB DESCRIPTION</div>
                <div class="checkbox">[&nbsp;&nbsp;&nbsp;&nbsp;] Job of Injury</div>
                <div class="checkbox">[&nbsp;&nbsp;&nbsp;&nbsp;] Permanent Modified Job</div>
                <div class="checkbox">[&nbsp;X&nbsp;] Light duty/Transitional</div>
            </div>
        </div>

        {{-- General Information Grid --}}
        <table class="info-table">
            <tr>
                <td style="width: 50%; border-right: 1px solid #000;">
                    <span class="label">Worker:</span>
                    <span class="value">{{ $workerName }}</span>
                </td>
                <td style="width: 50%;">
                    <span class="label">Claim #:</span>
                    <span class="value">{{ $claimNo ?: 'Unknown' }}</span>
                </td>
            </tr>
            <tr>
                <td style="border-right: 1px solid #000;">
                    <span class="label">Company:</span>
                    <span class="value">{{ $employer }}</span>
                </td>
                <td>
                    <span class="label">Job Title:</span>
                    <span class="value">{{ $jobTitleDisplay }}</span>
                </td>
            </tr>
            <tr>
                <td style="border-right: 1px solid #000;">
                    <span class="label">Phone #:</span>
                    <span class="value">{{ $phone }}</span>
                </td>
                <td>
                    <span class="label">Hours per day:</span>
                    <span class="value">{{ $hrPerDay }}</span>
                    &nbsp;&nbsp;&nbsp;
                    <span class="label">Days per week:</span>
                    <span class="value">{{ $daysWkPerShift }}</span>
                </td>
            </tr>
            <tr>
                <td style="border-right: 1px solid #000;">
                    <span class="label">Employer Name (Please print):</span>
                    <div class="signature-line"></div>
                </td>
                <td>
                    <span class="label">Title:</span>
                    <span class="value">{{ $title }}</span>
                </td>
            </tr>
            <tr>
                <td style="border-right: 1px solid #000;">
                    <span class="label">Employer Signature:</span>
                    <div class="signature-line"></div>
                </td>
                <td>
                    <span class="label">Date:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($date)->format('m/d/Y') }}</span>
                </td>
            </tr>
        </table>

        {{-- Essential Job Duties --}}
        <div class="section">
            <div class="section-title">Essential Job Duties</div>
            <div class="section-content">{{ $tasksDisplay }}</div>
        </div>

        {{-- Equipment --}}
        <div class="section">
            <div class="section-title">Machinery, tools, equipment and personal protective equipment. (Please submit MSDS if appropriate.)</div>
            <div class="section-content">{{ $toolsEquipment }}</div>
        </div>

        {{-- Frequency Guidelines --}}
        <div class="frequency-guide">
            <div class="row">
                <div class="item"><strong>Frequency Guidelines</strong></div>
                <div class="item"><strong>N:</strong> Never (not at all)</div>
                <div class="item"><strong>S:</strong> Seldom (1-10% of the time)</div>
                <div class="item"><strong>O:</strong> Occasional (11-33% of the time)</div>
                <div class="item"><strong>F:</strong> Frequent (34%-66% of the time)</div>
                <div class="item"><strong>C:</strong> Constant (67%-100% of the time)</div>
            </div>
        </div>

        {{-- Physical Demands Table --}}
        <table class="demands-table">
            <thead>
                <tr>
                    <th class="demand-name">Physical Demands</th>
                    <th class="freq">Frequency</th>
                    <th>Description of Task <span style="font-weight: normal; font-style: italic;">(Please limit to 80 characters)</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach($physicalDemands as $key => $label)
                    @if($key === 'other' && !empty($newTask))
                        <tr>
                            <td>{{ $newTask }}</td>
                            <td class="freq">{{ $frequencyLetters['newTask'] ?? 'N' }}</td>
                            <td>{{ $descriptions['newTask'] ?? '' }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td>{{ $label }}</td>
                        <td class="freq">{{ $frequencyLetters[$key] ?? 'N' }}</td>
                        <td>{{ $descriptions[$key] ?? '' }}</td>
                    </tr>
                @endforeach

                @foreach($liftingDemands as $key => $label)
                    <tr>
                        <td>
                            {{ $label }}
                            @if(!empty($lbsValues[$key]))
                                ({{ $lbsValues[$key] }}) lbs
                            @else
                                (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) lbs
                            @endif
                        </td>
                        <td class="freq">{{ $frequencyLetters[$key] ?? 'N' }}</td>
                        <td>{{ $descriptions[$key] ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- For Health Provider's Use Only --}}
        <div class="provider-section">
            <div class="provider-header">FOR HEALTH PROVIDER'S USE ONLY</div>
            <div class="provider-content">
                <div class="provider-row">
                    <div class="provider-col">
                        <div style="font-weight: bold; font-size: 9pt; margin-bottom: 8px;">Provider Approval</div>
                        <div style="font-size: 9pt;">
                            <div>[&nbsp;&nbsp;&nbsp;&nbsp;] Yes</div>
                            <div>[&nbsp;&nbsp;&nbsp;&nbsp;] No</div>
                        </div>
                    </div>
                    <div class="provider-col" style="font-size: 9pt;">
                        <div><strong>Hours per day</strong> ______</div>
                        <div><strong>Days per week</strong> ______</div>
                        <div><strong>Effective date</strong> ____________</div>
                    </div>
                </div>
                <div style="font-size: 9pt; margin-top: 10px;">
                    If no, please provide objective medical documentation to support your decision:
                </div>
                <div class="signature-line" style="height: 30px;"></div>
            </div>
        </div>

        {{-- Signature Section --}}
        <div class="signature-section">
            <div class="signature-row">
                <div class="signature-col">
                    <div class="signature-label">Provider Signature</div>
                    <div class="signature-line"></div>
                </div>
                <div class="signature-col">
                    <div class="signature-label">Provider Name <span class="italic">(Please print)</span></div>
                    <div class="signature-line"></div>
                </div>
                <div class="signature-col">
                    <div class="signature-label">Date</div>
                    <div class="signature-line"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
