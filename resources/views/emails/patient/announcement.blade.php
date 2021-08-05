@extends('emails.templates.main')

@section('content')

    @include ('emails.templates.partials.heading', [
            'heading' => $patient->lang == "ar" ? $announcement->subject_ar : $announcement->subject_en,
            'level' => 'h1',
        ])

    @include('emails.templates.partials.contentStart')

    <p> Dear {{ $patient->first_name }} {{ $patient->last_name }},</p>
    <p>{{ $patient->lang == "ar" ? $announcement->message_ar : $announcement->message_en }}</p>

    @include('emails.templates.partials.contentEnd')

@stop
