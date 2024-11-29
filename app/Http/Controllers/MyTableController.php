<?php

namespace App\Http\Controllers;

use App\Events\NewRecord;
use App\Models\MyTable;
use App\Models\Trigger;
use App\Models\Workflow;
use Illuminate\Http\Request;


class MyTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = MyTable::all()->sortByDesc('created_at');
        return view('mytable.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mytable.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'priority' => ['required', 'integer']
        ]);

        $data['status'] = $request->has('status') ? 1 : 0;

        $record = MyTable::create($data);
        event(new NewRecord($record));

        return to_route('mytable.index')->with('message', 'Record Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MyTable $myTable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $record= MyTable::find($id);
        return view( 'mytable.edit',['record' => $record]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => ['required'],
            'priority' => ['required', 'integer']
        ]);

        $data['status'] = $request->has('status') ? 1 : 0;
        
        $record = MyTable::find($id);
        $record->update($data);

        return to_route('mytable.index')->with('message', 'Record Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $record = MyTable::find($id);
        $record->delete();

        return to_route('mytable.index')->with('message', 'Record Deleted!');
    }
}
