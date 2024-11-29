@extends('adminlte::page')

@section('title', 'MyTableMng')

@section('content_header')
    <h1>Add New Record</h1>
@stop

@section('content')
    <div class="">
        <form action="{{ route('mytable.store') }}" method="POST" class=" py-3 px-5 items-center">
            @csrf
            <div>
                <div class=" py-1">
                    <input type="text" name="name" placeholder="Enter name" required/>
                    @error('name')
                        <p class="">{{ $message }}</p>
                    @enderror
                </div>
                <div class="py-1">
                    <input type="text" name="priority" placeholder="Enter priority" required/>
                    @error('priority')
                        <p style=" color:red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="py-1">
                    <label> Status </label>
                    <input class=" ml-2" type="checkbox" name="status" checked />
                </div>
            </div>
            <div class=" py-3 justify-between px-1">
                <button class="btn btn-primary">Submit</button>
                <a href="{{ route('mytable.index') }}" class=" btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@stop
