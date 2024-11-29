@extends('adminlte::page')

@section('title', 'MyTableMng')

@section('content_header')
    <h1>My Table Data</h1>
@stop

@section('content')

    @session('message')
        <div style="color:green">
            {{ session('message') }}
        </div>
    @endsession
    <div class=" py-4">
        <a href="{{ route('mytable.create') }}" class=" btn btn-primary float-right">
            New Record
        </a>
    </div>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->name }}</td>
                    <td>{{ $record->status }}</td>
                    <td>{{ $record->priority }}</td>
                    <td>
                        <!-- Edit -->
                        <a href="{{ route('mytable.edit', $record) }}" class="btn btn-info">Edit</a>

                        <!-- Delete  -->
                        <form action="{{ route('mytable.destroy', $record) }}" method="POST" style="display:inline;">
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
