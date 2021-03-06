@extends('template.master')

@section('title', 'Home')

@section('content-css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-timer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/switch.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center mt-5">
            <form id="lamp_form" action="{{ route('toggleLamp') }}" method="post" onsubmit="return false">
                @csrf
                <a class="mx-3 navbar-brand lamp-icon" onclick="document.getElementById('lamp_form').submit();">
                    @if ($lamp->on)
                        <i class="bi bi-lightbulb-fill"></i>
                    @else
                        <i class="bi bi-lightbulb-off-fill"></i>
                    @endif
                </a>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center">
            @if ($lamp->on)
                <h2>LIGADA</h2>
            @else
                <h2>DESLIGADA</h2>
            @endif
        </div>
    </div>
    
    @if (Session::has('success-message'))
        <div class="row d-flex justify-content-center mt-5">
            <div class="alert alert-success alert-dismissible fade show w-50" role="alert">
                <strong>{{ Session::get('success-message') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if (Session::has('error-message'))
        <div class="row d-flex justify-content-center mt-5">
            <div class="alert alert-danger alert-dismissible fade show w-50" role="alert">
                <strong>{{ Session::get('error-message') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if ($errors->has('timer')))
        <div class="row d-flex justify-content-center">
            <div class="alert alert-danger alert-dismissible fade show w-50" role="alert">
                <strong>{{ $errors->first('timer') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <form action="{{ route('timer') }}" method="POST">
        @csrf
        <div class="row mt-5">
            <div class="col-12 offset-0 col-sm-6 offset-sm-3 col-lg-4 offset-lg-2 d-flex justify-content-center align-items-center">
                <h3 class="text-white mx-2">Temporizador: </h3>
                <input class="form-control input-timer {{ $errors->has('timer') ? 'is-invalid' : '' }}" type="time" name="timer" id="timer" step="1">
            </div>
            <div class="col-6 offset-4 col-sm-6 offset-sm-4 col-md-3 offset-md-4 col-lg-2 offset-lg-0 mt-3 mt-lg-0 d-flex justify-content-center">
                <div class="align-buttons align-items-center">
                    <label class="form-check-label mx-2" style="color: #fff">
                        Desligar
                    </label>

                    <label class="switch">
                        <input type="checkbox" name="on">
                        <span class="slider round"></span>
                    </label>

                    <label class="form-check-label mx-2" style="color: #fff">
                        Ligar
                    </label>
                    
                </div>
            </div>
            <div class="col-6 offset-6 col-sm-6 offset-sm-6 col-md-3 offset-md-0 col-lg-2 offset-lg-0 mt-3 mt-lg-0">
                <button class="btn btn-md btn-secondary mx-3 align-self-center" type="submit">Ativar</button>
            </div>
        </div>
    </form>
@endsection

@section('content-js')
    
@endsection