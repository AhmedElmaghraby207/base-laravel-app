@extends('dashboard.layout.auth')
@section('title') Expired page @endsection
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-md-4 col-10 box-shadow-2 p-0">
                            <div class="card mb-0">
                                <div class="card-body text-center">
                                    @if(isset($error))
                                        <p>{{ $error}}</p>
                                        <img src='{{ url("/assets/images/failure.png")}}' alt="Failure" width="100"
                                             style="margin-top: 15px"/>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
