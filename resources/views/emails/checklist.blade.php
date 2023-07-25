<x-mail::message>
<h1>Checklist Pending Reminder</h1>
<p>Greetings,</p>


<p>I hope this email finds you well. This is a kind reminder on the pending checklists. Below is a list of pending checklists, Please do ensure completing them in order to ensure efficiency.
</p>

<x-mail::table>
| **Building name**| **Class Name** |**Faults Identified**|**Message**|**Status**|**Date Created**|
| ------------- |:-------------:| --------:| ------------- |:-------------:| --------:|
@foreach($date_created as $date )
|{{ implode(', ',$date->building_name) }}|{{ implode(', ',$date->class_name) }}| {{ implode(', ', $date->faults_identified) }} |{{ $date->message }}|{{ $date->status }}|{{ $date->created_at }}|
@endforeach
</x-mail::table>


<x-mail::button :url=$link>
View Checklist
</x-mail::button>

Best Regards,<br>
<i>ICT CheckList Team</i>
<!-- {{ config('app.name') }} -->
</x-mail::message>
