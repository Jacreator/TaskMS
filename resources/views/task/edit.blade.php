@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row col-md-8">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{ __('Edit New Task') }}</div>

                        <div class="card-body">
                            <form action="{{ route('task-update', $task->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="task"></label>
                                    <div class="col-md">
                                        <input id="task" type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" autocomplete="on" value="{{ $task->name }}">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    @if (count($task->taskfiles) > 0)
                                        <ul class="list-group list-group-flush">
                                            @foreach ($task->taskfiles as $file)
                                                <li class="list-group-item">{{ $file->filename }}
                                                    <span>&nbsp;&nbsp;</span> 
                                                    <a id="del_file" href="{{ route('task-deletefile', $file->id)}}" class="btn btn-xs btn-danger"
                                                            >{{ __('Detele') }}</a>
                                                    
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="form-group row">
                                    <div class="col-md">
                                        <input id="photos" type="file"
                                            class="form-control @error('photos') is-invalid @enderror" name="photos[]"
                                            multiple>

                                        @error('photos')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md">
                                        {{ 'Duedate for this task is '. $task->duedate}}
                                        <input id="duedate" type="date"
                                        class="form-control @error('duedate') is-invalid @enderror" 
                                        name="duedate">
                                        
                                        
                                        @error('duedate')
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
                                                <option value="{{ $user->id }}" @if ($task->user->id == $user->id)
                                                    selected
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
                                                <option value="{{ $project->id }}" @if ($task->project->id == $project->id)
                                                    selected
                                            @endif
                                            >{{ $project->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('taskProject')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md">
                                        <select class="form-control" name="priority">
                                            <option>Task Priority</option>
                                            @foreach (config('priority.levels') as $key => $level)
                                                @if ($task->priority == 0)
                                                    <option value="0" selected>Low</option>
                                                    <option value="1">High</option>
                                                @else
                                                    <option value="0">Low</option>
                                                    <option value="1" selected>High</option>
                                                @endif

                                            @endforeach
                                        </select>

                                        @error('priority')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="d-flex">
                                        <div class="col-md-12">
                                            <a class="btn btn-default"
                                                href="{{ redirect()->getUrlGenerator()->previous() }}">Go Back</a>
                                        </div>
                                        <div class="col-md-12" style="text-align: right">
                                            <input class="btn btn-primary" type="submit" value="Submit">
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src="{{ asset('js/moment.js') }}"></script>

            <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>

            <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
        @endsection
