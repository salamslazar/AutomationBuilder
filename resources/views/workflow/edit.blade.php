@extends('adminlte::page')

@section('title', 'Workflow')

@section('content_header')
    <h1>Update Workflow</h1>
@stop

@section('content')
    <div class="">
        <form action="{{ route('workflow.update',$workflow) }}" method="POST" class=" py-3 px-5 items-center">
            @csrf
            @method('PUT')
            <div>
                <div class=" py-1">
                    <input type="text" name="name" placeholder="Enter name" required value="{{$workflow->name}}"/> 
                    @error('name')
                        <p class="">{{ $message }}</p>
                    @enderror
                </div>
                <div class="py-1">
                    Status
                    <input class=" ml-2" type="checkbox" name="status" @if($workflow->is_active) checked @endif  />
                </div>
                <h5 class=" mt-3 font-bold"> Triggers: </h5>
                <div class="flex py-1 ml-4">
                    Trigger type:
                    <select name="trigger_type" id="trigger_type" class=" ml-2">
                        <option value="event" @if($trigger->type == 'event') selected @endif>Event</option>
                        <option value="time" @if($trigger->type == 'time') selected @endif>Time</option>
                    </select>
                </div>
                <div class="flex py-1 ml-4">
                    Trigger name:
                    <input type="text" name="trigger_name" placeholder="Enter Trigger Name" required value="{{$trigger->name}}">
                </div>
                <div class="flex py-1 ml-4">
                    Trigger params:
                    <input type="text" name="trigger_params" placeholder="Enter Trigger Params" required value="{{$trigger->params}}">
                </div>
                <h5 class=" mt-3 font-bold"> Conditions: </h5>
                <div class="flex py-1 ml-4">
                    Criteria:
                    <input type="text" name="criteria" placeholder="Enter Criteria" required value="{{$condition}}">
                </div>
                <h5 class=" mt-3 font-bold"> Actions: </h5>
                <div class="flex py-1 ml-4">
                    Actions:
                    <select name="action" id="action" class=" ml-2">
                        <option value="log" @if($action->name == 'log') selected @endif>Write Log</option>
                        <option value="insert" @if($action->name == 'insert') selected @endif>Insert into X Table</option>
                    </select>
                    <input type="text" name="action_params" placeholder="Enter Action Params" required value="{{$action->params}}">
                </div>
            </div>
            <div class=" py-3 justify-between px-1">
                <button class="btn btn-primary">Submit</button>
                <a href="{{ route('workflow.index') }}" class=" btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@stop
