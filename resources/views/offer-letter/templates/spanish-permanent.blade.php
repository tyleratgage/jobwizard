{{-- Spanish Permanent Offer Letter Template --}}

<p class="offer-letter-header-info print-only">
    Oferta de Trabajo/ Retorno al trabajo, página 1<br>
    Nombre del empleado lesionado: {{ $first_name }} {{ $last_name }}<br>
    Número de reclamo L&I.: {{ $claim_no }}
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
    Oferta de trabajo permanente/ Regresar al trabajo<br>
    Número de reclamo L&I.: {{ $claim_no }}
</p>

<p>Estimado {{ $first_name }},</p>

<p>
    Me complace ofrecerle un empleo de trabajo que se adapte a sus capacidades físicas actuales. Sus deberes se explican en la descripción del trabajo que ha sido aprobado y va de acuerdo con las limitaciones y/o restricciones físicas establecidas por su proveedor actual. Su supervisor también ha sido informado como corresponde. Además, se ha enviado una copia a su Gerente de Reclamos asignado en el Departamento de Labor e Industrias (L&I, por sus siglas en Ingles). Se espera que este trabajo razonablemente continúe en el futuro y cumple con el patrón de trabajo al momento de la lesión.
</p>

<p>Los detalles para presentarse al trabajo son los siguientes:</p>

<ul>
    <li>Se debe reportar a trabajar el {{ $work_date }} {{ $start_time }} en la siguiente ubicación {{ $location_address }}, {{ $location_city }}</li>
    <li>Su supervisor es {{ $supervisor_name }} y su número de teléfono es {{ $supervisor_phone }}</li>
    <li>Su horario de trabajo empieza a las {{ $start_time }} hasta {{ $end_time }}, de ____(día) a ____ (día)</li>
    <li>Su salario será de ${{ $wage }} por {{ $wage_duration }} y los beneficios que aplican no cambian.</li>
</ul>

<p>
    Se espera que programe cualquier cita médica y/o terapia fuera de su horario de trabajo, ya que L&I no le compensará por el tiempo que no esté trabajando, excepto cuando esté cubierto por las reglas estatales o locales de licencia familiar y/o médica. También se espera que Ud. cumpla con todas las reglas del trabajo y las normas de asistencia de la empresa.
</p>

<p>
    Nuestro objetivo es proporcionar a todos los empleados un lugar de trabajo seguro. Si experimenta alguna dificultad en el desempeño de sus deberes, debe reportarlas a su supervisor inmediatamente.
</p>

<p>
    Requerimos que trabaje dentro de todas las limitaciones y/o restricciones físicas aprobadas por su proveedor médico. Si alguien le pide que realice tareas más allá de sus capacidades físicas, debe rechazar esta petición e informar a su supervisor inmediatamente. De acuerdo con estas expectativas usted puede estar sujeto a medidas disciplinarias si Ud. escoge trabajar más allá de sus limitaciones físicas.
</p>

<p>
    Por favor revise esta oferta de trabajo y póngase en contacto conmigo al siguiente número de teléfono {{ $contact_phone }} para conversar de los detalles de esta oferta. Si no se presenta al trabajo, eso se considerará como su decisión de rechazar esta oferta de empleo y sus beneficios de tiempo perdido pueden verse afectados.
</p>

<p>Sinceramente</p>

<p>&nbsp;</p>

<p class="page-break-after">{{ $valediction }}</p>

<br>

<p class="offer-letter-header-info print-only">
    Oferta de Trabajo/ Retorno al trabajo, página 2<br>
    Nombre del empleado lesionado: {{ $first_name }} {{ $last_name }}<br>
    Número de reclamo L&I.: {{ $claim_no }}
</p>

<br><br>

<p>
    Sí, ____, acepto la posición ofrecida y me presentaré a trabajar.<br>
    No, ___, no acepto la posición ofrecida y no me presentaré a trabajar.
</p>

<br>

<p>
    ____________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ________________________<br>
    Fecha de la Firma&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Firma del empleado lesionado
</p>

<p>Archivos adjuntos. Descripción del trabajo aprobado del empleado/análisis/alta para regresar al trabajo.</p>

@if($cc_line_1 || $cc_line_2 || $cc_line_3)
<p>Copia de cortesía:</p>
<ul class="cc-list">
    @if($cc_line_1)<li>{{ $cc_line_1 }}</li>@endif
    @if($cc_line_2)<li>{{ $cc_line_2 }}</li>@endif
    @if($cc_line_3)<li>{{ $cc_line_3 }}</li>@endif
</ul>
@endif
