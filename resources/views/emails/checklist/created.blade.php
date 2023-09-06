<x-mail::message>
<h1>Checklist Created</h1>
<p>Greetings Team,</p>


<p>Your Checklist has been created on <b>{{ $date_created }}</b>.
    Please have a look below for more information.
</p>
@component('mail::table')
|                   |                                      |
| ----------------- | ------------------------------------ |
| **Building name** | {{ $building_name }}                  |
| **Class Name**    | {{ implode(',' ,$class_name) }}        |
| **Faults Identified** | {{ implode(', ', $faults_identified) }}          |
| **Message**       | {{ $message }}                         |
| **Status**        | {{ $status }}                          |
| **Date Created**  | {{ $date_created }}                    |
@endcomponent


<x-mail::button :url=$link>
View Checklist
</x-mail::button>

Best Regards,<br>
<i>ICT CheckList Team</i>
<!-- {{ config('app.name') }} -->
</x-mail::message>
