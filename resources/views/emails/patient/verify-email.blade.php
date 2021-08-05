@extends('emails.templates.main')

@section('content')

    @include ('emails.templates.partials.heading', [
        'heading' => 'Verify Email',
        'level' => 'h1',
    ])

    @include('emails.templates.partials.contentStart')

    <p>Dear {{ $patient->first_name }} {{ $patient->last_name }},</p>
    <p>Please click below to confirm your email.
        <span style="color: #999;"> or copy and paste this link in your browser:</span>
    </p>

    <a href="#" style="color: #666; text-decoration: none;">
        {{ URL::to('patient/email/verify', array($token)) }}
    </a>

    @include('emails.templates.partials.contentEnd')

    @include('emails.templates.partials.button', [
        'title' => 'Confirm Email',
        'link' =>  URL::to('patient/email/verify', array($token))
    ])

@stop
