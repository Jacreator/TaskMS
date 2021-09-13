@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row col-md-8">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                {{-- display task --}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">{{ __('Project List') }}</div>

                        <div class="card-body">
                            <ul class="list-group list-group-flush" id="Tasklist">
                                @foreach ($projects as $key => $project)
                                    <a href="#"
                                        class="list-group-item list-group-item-action flex-column align-items-start my-2">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ $project->name }}</h5>
                                            <small>3 days ago</small>
                                        </div>
                                        <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas
                                            sed
                                            diam eget risus varius blandit.</p>
                                        <small>Created by {{ $users[0]['name'] }}.</small>
                                    </a>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Task List') }}</div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="taskRoute" value="{{ route('getTask') }}" id="taskRoute">
                                <table class=" table table-striped table-hover datatable datatable-task">
                                    <tbody style="cursor: all-scroll;">
                                        @foreach ($tasks as $task)
                                        <input type="hidden" name="proId" id="proId" value="{{ $task->priority }}">
                                            <tr id="{{ $task->id }}">

                                                <td>
                                                    {{ $task->name ?? '' }}
                                                </td>
                                                <td class="d-flex justify-content-between align-items-center">
                                                    <span
                                                        class="badge @if ($task->priority === 0) badge-primary 
                                                        @elseif($task->priority === 1) badge-danger 
                                                        @else badge-danger @endif badge-pill">
                                                        {{ config('priority.levels.' . $task->priority) }}</span>
                                                </td>
                                                <td>

                                                    <a class="btn btn-xs btn-info"
                                                        href="{{ route('task-edit', $task->id) }}">{{ __('Edit') }}
                                                    </a>


                                                    <form action="{{ route('task-destroy', $task->id) }}" method="POST"
                                                        onsubmit="return confirm('{{ __('Are you Sure?') }}');"
                                                        style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" class="btn btn-xs btn-danger"
                                                            value="{{ __('Detele') }}">
                                                    </form>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
                                    <input id="photos" type="file"
                                        class="form-control @error('photos') is-invalid @enderror" name="photos[]" required
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
            </div>
        </div>

    </div>
    <script>
            $('tbody').sortable({
                placeholder: "ui-state-highlight",
                update: function(event, ui) {
                    var priority_id_array = new Array();
                    var task_id_array = new Array();
                    $('tbody tr').each(function() {
                        priority_id_array.push($(this).attr('id'));
                        
                    });
                    let _tokenTask = $('#tokenTask').value
                    console.log('Reorder');
                    $.ajax({
                        url: "{{ route('task-reorder') }}",
                        method: "GET",
                        data: {
                            priority_id_array: priority_id_array,
                            task_id_array: task_id_array
                        },
                        error: function(error) {
                            console.log(error);
                        },
                        success: function(response) {
                            location.reload();
                        },

                    })
                }
            });
        
        var taskRoute = document.getElementById('taskRoute').value
    </script>

@endsection
