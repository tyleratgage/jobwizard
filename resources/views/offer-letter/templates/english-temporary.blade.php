{{-- English Temporary/Transitional Offer Letter Template --}}

<p class="offer-letter-header-info print-only">
    Return to Work Job Offer, page 1<br>
    Injured Employee Name: {{ $first_name }} {{ $last_name }}<br>
    L&I Claim No.: {{ $claim_no }}
</p>

<br>

<strong>(On company letterhead; deliver in-person or via certified mail with return receipt)</strong>

<p>&nbsp;</p>

<p>{{ $date }}</p>

<p>
    {{ $first_name }} {{ $last_name }}<br>
    {{ $address_one }}@if($address_two), {{ $address_two }}@endif<br>
    {{ $city }}, {{ $state }}, {{ $zip }}
</p>

<p>
    Re: Return to Work Job Offer<br>
    L &amp; I Claim No. {{ $claim_no }}
</p>

<p>Dear {{ $first_name }},</p>

<p>
    I am pleased to offer you transitional/light duty employment that will accommodate your current physical capacities. Your duties are described in the approved job description and are consistent with all physical limitations established by your attending provider. Your supervisor has also been advised accordingly. A copy has also been sent to your Claim Manager (CM) at The Department of Labor and Industries (L&I).
</p>

<p>The details to report to work are as follows:</p>

<ul>
    <li>You must report on {{ $work_date }} at {{ $start_time }} at {{ $location_address }}, {{ $location_city }}</li>
    <li>Your supervisor is {{ $supervisor_name }} and their phone number is {{ $supervisor_phone }}</li>
    <li>Your work schedule is {{ $start_time }} to {{ $end_time }}, on {{ $days_of_the_week }}, for {{ $hours_per_week }} hours per week</li>
    <li>Your wages will be ${{ $wage }} per {{ $wage_duration }} and applicable benefits are unchanged</li>
</ul>

<p>
    Except when covered by state or local Paid Family & Medical Leave rules, you are expected to schedule any medical and therapy appointments around your work schedule, as you will not be compensated for time absent from work by L&I. You are also expected to comply with all company work rules and attendance policies.
</p>

<p>
    Our goal is to provide all employees with a safe work environment. If you experience trouble performing these duties, please inform your supervisor immediately.
</p>

<p>
    We require that you work within the physical capacities given by your attending provider. If anyone asks you to perform tasks beyond your physical capacities, you should decline and let your supervisor know immediately. Consistent with these expectations, you may be subject to disciplinary action if you choose to work beyond them.
</p>

<p>
    Please review this offer and contact me at {{ $contact_phone }} to discuss arrangements. If you do not report to work, that will be considered as your decision to reject this offer of employment and your time loss benefits may be affected.
</p>

<p>Sincerely,</p>

<p>&nbsp;</p>

<p class="page-break-after">{{ $valediction }}</p>

<br>

<p class="offer-letter-header-info print-only">
    Return to Work Job Offer, page 2<br>
    Injured Employee Name: {{ $first_name }} {{ $last_name }}<br>
    L&I Claim No.: {{ $claim_no }}
</p>

<br><br>

<p>
    Yes ___, I accept the offered position and will report to work.<br>
    No, ___, I do not accept the offered position and will not report to work.
</p>

<br>

<p>
    ____________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ________________________<br>
    Injured Employee Signature&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date
</p>

<p>Enclosure: Approved job description/analysis/release to work</p>

@if($cc_line_1 || $cc_line_2 || $cc_line_3)
<p>Cc:</p>
<ul class="cc-list">
    @if($cc_line_1)<li>{{ $cc_line_1 }}</li>@endif
    @if($cc_line_2)<li>{{ $cc_line_2 }}</li>@endif
    @if($cc_line_3)<li>{{ $cc_line_3 }}</li>@endif
</ul>
@endif
