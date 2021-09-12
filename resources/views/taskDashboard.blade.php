@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row col-md-8">
                {{-- display task --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">{{ __('Project List') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            {{ __('You are logged in!') }}
                        </div>

                        <div class="card-footer">
                            <div class="text-align-right">

                                edit and delete here
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">{{ __('Task List') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            {{ __('You are logged in!') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Project Creation Section --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{ __('Create New Project') }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('create-project') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md">
                                    <input id="project" type="text"
                                        class="form-control @error('project') is-invalid @enderror" name="name" required
                                        autocomplete="on" placeholder="Enter Project Name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                <div class="card my-3">
                    <div class="card-header">
                        {{ __('Create New Task') }}
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="task"></label>
                                <div class="col-md">
                                    <input id="task" type="text"
                                        class="form-control @error('task_name') is-invalid @enderror" name="task_name"
                                        required autocomplete="on" placeholder="Enter Task Name">

                                    @error('task_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md">
                                    <select class="form-control" name="user">
                                        <option>Assign Team Mate</option>
                                        
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @if ('user' == old('user', $user->id ?? ""))
                                                selected="selected"
                                        @endif
                                        >{{ $user->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('task_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md">
                                    <select class="form-control" name="taskProject">
                                        <option>Pick Project</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}" @if ('taskProject' == old('taskProject', $project->id ?? ""))
                                                selected="selected"
                                        @endif
                                        >{{ $project->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('task_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
            </div>
        </div>

    </div>
@endsection
