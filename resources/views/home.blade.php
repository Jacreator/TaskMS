@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row col-md-8">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{ __('Task List') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            {{ Auth::user()->name . ', You are logged in! and Welcome' }}
                            <br>
                            <a href="{{ route('workspace')}}">Click here</a> {{ __('to go to your work space') }}
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-4">

                {{-- Member Creation Section --}}
                <div class="card">
                    <div class="card-header">
                        {{ __('Create New Member') }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('register') }}" method="post">
                            @csrf
                            <div class="form-group row">

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter Member Full name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter member email Address">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                name="password" required autocomplete="new-password" placeholder="Enter default password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control" 
                                name="password_confirmation" required autocomplete="new-password" placeholder="Please enter default password again">
                            </div>
                        </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Member List Section --}}
                <div class="card my-3">
                    <div class="card-header">
                        {{ __('List Of Memebers') }}
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($users as $user)    
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $user->name }} <span class="badge badge-primary badge-pill">14</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
