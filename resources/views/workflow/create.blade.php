@extends('adminlte::page')

@section('title', 'Workflow')

@section('content_header')
    <h1>Add New Workflow</h1>
@stop

@section('content')
    <div class="">
        <form action="{{ route('workflow.store') }}" method="POST" class=" py-3 px-5 items-center">
            @csrf
            <div class="flex">
                <div class=" py-1">
                    <input type="text" name="name" placeholder="Enter name" required/>
                    @error('name')
                        <p class="">{{ $message }}</p>
                    @enderror
                </div>
                <div class="py-1">
                    Status
                    <input class=" ml-2" type="checkbox" name="status" checked />
                </div>
                <h5 class=" mt-3 font-bold"> Triggers: </h5>
                <div class="flex py-1 ml-4">
                    Trigger type:
                    <select name="trigger_type" id="trigger_type" class=" ml-2">
                        <option value="event">Event</option>
                        <option value="time">Time</option>
                    </select>
                </div>
                <div class="flex py-1 ml-4">
                    Trigger name:
                    <input type="text" name="trigger_name" placeholder="Enter Trigger Name" required>
                </div>
                <div class="flex py-1 ml-4">
                    Trigger params:
                    <input type="text" name="trigger_params" placeholder="Enter Trigger Params" required>
                </div>
                <h5 class=" mt-3 font-bold"> Conditions: </h5>
                <div class="flex py-1 ml-4">
                    Criteria:
                    <input type="text" name="criteria" placeholder="Enter Criteria" required>
                </div>
                <h5 class=" mt-3 font-bold"> Actions: </h5>
                <div class="flex py-1 ml-4">
                    Actions:
                    <select name="action" id="action" class=" ml-2">
                        <option value="log">Write Log</option>
                        <option value="insert">Insert into X Table</option>
                    </select>
                    <input type="text" name="action_params" placeholder="Enter Action Params" required>
                </div>
            </div>
            <div class=" py-3 justify-between px-1">
                <button class="btn btn-primary">Submit</button>
                <a href="{{ route('workflow.index') }}" class=" btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@stop
