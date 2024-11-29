@extends('adminlte::page')

@section('title', 'Workflow')

@section('content_header')
    <h1>Workflows</h1>
@stop

@section('content')

    @session('message')
        <div style="color:green">
            {{ session('message') }}
        </div>
    @endsession
    <div class=" py-4">
        <a href="{{ route('workflow.create') }}" class=" btn btn-primary float-right">
            New Workflow
        </a>
    </div>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Is Active</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($workflows as $workflow)
                <tr>
                    <td>{{ $workflow->id }}</td>
                    <td>{{ $workflow->name }}</td>
                    <td>{{ $workflow->is_active }}</td>
                    <td>{{ $workflow->created_at }}</td>
                    <td>
                        <!-- Edit -->
                        <a href="{{ route('workflow.edit', $workflow) }}" class="btn btn-info">Edit</a>

                        <!-- Delete  -->
                        <form action="{{ route('workflow.destroy', $workflow) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
