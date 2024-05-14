@component('mail::message')

# Project Updates - ${{title}}

The Project {{$project}} is updated.

{{$content}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
