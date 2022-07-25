<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\TestType;
use App\Http\Requests\StoreTestTypeRequest;
use App\Http\Requests\UpdateTestTypeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('denied');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        $test_types = TestType::with(['user','department'])->when(Auth::user()->isUser(),fn($q)=>$q->where('user_id',Auth::id()))
            ->orderBy('name','asc')
            ->paginate(10);
        return view('test_type.create',compact('test_types','departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTestTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTestTypeRequest $request)
    {
        $testType = new TestType();
        $testType->name = $request->name;
        $testType->department_id = $request->department;
        $testType->user_id = Auth::id();
        $testType->save();
        return redirect()->back()->with('status',"Successfully Created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestType  $testType
     * @return \Illuminate\Http\Response
     */
    public function show(TestType $testType)
    {
        return redirect()->route('denied');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestType  $testType
     * @return \Illuminate\Http\Response
     */
    public function edit(TestType $testType)
    {
        return redirect()->route('denied');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTestTypeRequest  $request
     * @param  \App\Models\TestType  $testType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTestTypeRequest $request, TestType $testType)
    {
        $testType->name = $request->name;
        $testType->department_id = $request->department;
        $testType->user_id = Auth::id();
        $testType->update();
        return redirect()->back()->with('status',"Successfully Updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestType  $testType
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestType $testType)
    {
        Gate::allows('delete',$testType);
        $testType->delete();
        return redirect()->back()->with('status',"Successfully Deleted!");
    }
}
