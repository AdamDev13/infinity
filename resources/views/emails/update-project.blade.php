{{--@component('mail::message')--}}

Hello,

Please be advised that **{!! $projectName !!}** for **{!! $clientName !!}** in the category of **{{$category}}** has been updated on **{{$todayDate}}**.  Please click the link below to view the updated project details.

[View Project]({{$viewLink}})

{{--@endcomponent--}}
