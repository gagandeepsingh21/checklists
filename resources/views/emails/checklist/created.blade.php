<x-mail::message>
<h1>Checklist Created</h1>
<p>Greetings {{ Auth::user()->name}},</p>


<p>Your Checklist has been created on <b>{{ $date_created }}</b>.
    Please have a look below for more information.
</p>
<!-- <table style="border 1px solid black; width:100%;">
<tr>
<th>
Building name
</th>
<th>
Class Name
</th>
<th>
Faults Identified
</th>
<th>
Message
</th>
<th>
Status
</th>
<th>
Date Checked
</th>
</tr>
<tr>
<td>{{ $building_name }}</td>
<td>{{ $class_name }}</td>
<td>{{ $faults_identified }}</td>
<td>{{ $message }}</td>
<td>{{ $status }}</td>
<td>{{ $date_created }}</td>
</tr>
</table><br> -->
@component('mail::table')
|                   |                                      |
| ----------------- | ------------------------------------ |
| **Building name** | {{ $building_name }}                  |
| **Class Name**    | {{ $class_name }}                     |
| **Faults Identified** | {{ $faults_identified }}          |
| **Message**       | {{ $message }}                         |
| **Status**        | {{ $status }}                          |
| **Date Created**  | {{ $date_created }}                    |
@endcomponent


<!-- <x-mail::button :url="''">
Button Text
</x-mail::button> -->

Best Regards,<br>
<i>ICT CheckList Team</i>
<!-- {{ config('app.name') }} -->
</x-mail::message>
