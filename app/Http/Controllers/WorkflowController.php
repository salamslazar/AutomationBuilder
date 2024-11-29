<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkflowRequest;
use App\Http\Requests\UpdateWorkflowRequest;
use App\Models\Action;
use App\Models\Condition;
use App\Models\Trigger;
use App\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WorkflowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Workflow::all()->sortByDesc('created_at');
        return view('workflow.index', ['workflows' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('workflow.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'trigger_type' => ['required', Rule::in(['event','time'])],
            'trigger_name' => ['required'],
            'trigger_params' => ['required'],
            'criteria' => ['required'],
            'action' => ['required', Rule::in(['log','insert'])],
            'action_params' => ['required']
        ]);

        $data['is_active'] = $request->has('status') ? 1 : 0;

        $workflow = Workflow::create($data);

        $trigger = Trigger::create([
            'name' => $request['trigger_name'],
            'type' => $request['trigger_type'],
            'params' => $request['trigger_params'],
            'workflow_id' => $workflow->id
        ]);

        $condition = Condition::create([
            'criteria' => $request['criteria'],
            'workflow_id' => $workflow->id
        ]);

        $action = Action::create([
            'name' => $request['action'],
            'params' => $request['action_params'],
            'workflow_id' => $workflow->id
        ]);

        return to_route('workflow.index')->with('message', 'Workflow Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Workflow $workflow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $workflow= Workflow::find($id);
        $triggers = $workflow->triggers;
        $conditions = $workflow->conditions;
        $actions = $workflow->actions;
        return view( 'workflow.edit',[
            'workflow' => $workflow,
            'trigger' => $triggers[0],
            'condition' => $conditions['criteria'],
            'action' => $actions[0]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => ['required'],
            'trigger_type' => ['required', Rule::in(['event','time'])],
            'trigger_name' => ['required'],
            'trigger_params' => ['required'],
            'criteria' => ['required'],
            'action' => ['required', Rule::in(['log','insert'])],
            'action_params' => ['required']
        ]);

        $data['is_active'] = $request->has('status') ? 1 : 0;
        
        $workflow = Workflow::find($id);
        $workflow->update($data);

        $trigger = $workflow->triggers;
        $trigger[0]->update([
            'name' => $request['trigger_name'],
            'type' => $request['trigger_type'],
            'params' => $request['trigger_params'],
        ]);

        $condition = $workflow->conditions;
        $condition->update([
            'criteria' => $request['criteria'],
        ]);

        $action = $workflow->actions;
        $action[0]->update([
            'name' => $request['action'],
            'params' => $request['action_params'],
        ]);

        return to_route('workflow.index')->with('message', 'Workflow Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $record = Workflow::find($id);
        $record->delete();

        return to_route('workflow.index')->with('message', 'Workflow Deleted!');
    }
}
