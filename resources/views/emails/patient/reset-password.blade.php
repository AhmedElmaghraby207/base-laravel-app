@extends('emails.templates.main')

@section('content')

    @include ('emails.templates.partials.heading', [
        'heading' => 'Reset Password',
        'level' => 'h1',
    ])

    @include('emails.templates.partials.contentStart')

    <p>Dear {{ $patient->first_name }} {{ $patient->last_name }},</p>
    <p>Please click below to reset your password.
        <span style="color: #999;"> or copy and paste this link in your browser:</span>
    </p>

    <a href="#" style="color: #666; text-decoration: none;">
        {{ URL::to('patient/password/reset', array($token)) }}
    </a>

    @include('emails.templates.partials.contentEnd')

    @include('emails.templates.partials.button', [
        'title' => 'Reset password',
        'link' =>  URL::to('patient/password/reset', array($token))
    ])

@stop
