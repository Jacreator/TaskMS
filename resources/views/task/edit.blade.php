@extends('layouts.app')

@section('content')
<div class="card my-3">
                    <div class="card-header">
                        {{ __('Create New Task') }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('create-task') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="task"></label>
                                <div class="col-md">
                                    <input id="task" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" required autocomplete="on" placeholder="Enter Task Name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md">
                                    <input id="task" type="file" class="form-control @error('photos') is-invalid @enderror"
                                        name="photos[]" required multiple>

                                    @error('photos')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md">
                                    <input id="duedate" type="date"
                                        class="form-control @error('duedate') is-invalid @enderror" name="duedate" required
                                        multiple>

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
                                            <option value="{{ $user->id }}" @if ('user' == old('user', $user->id ?? ''))
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
                                            <option value="{{ $project->id }}" @if ('taskProject' == old('taskProject', $project->id ?? ''))
                                                selected="selected"
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
                                            <option value="{{ $key ?? '' }}" @if ('priority' == old('priority', $key ?? ''))
                                                selected="selected"
                                        @endif
                                        >{{ $level }}</option>
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
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
@endsection