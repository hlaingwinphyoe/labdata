@extends('layouts.app')
@section('title')
    Data Lists
@endsection

@section('content')
    <div class="container">
        <div class="row my-3">
            <div class="col-12">
                <h4 class="my-3 ms-2">Tests Data</h4>
                <div class="box-container p-4 mt-0">
                    <div class="row">
                        <div class="col-12">
                            <form method="get">
                                <div class="row">
                                    <div class="col-6 col-xl-3">
                                        <div class="mb-3">
                                            <select class="custom-select" name="department" id="department">
                                                <option selected disabled>Select Department</option>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}" {{ $department->id == request()->department ? 'selected':'' }}>{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 col-xl-3">
                                        <div class="mb-3">
                                            <select class="custom-select" name="testType" id="testType">
                                                <option selected disabled>Select Test Type</option>
                                                @foreach($testTypes as $testType)
                                                    <option value="{{ $testType->id }}" {{ $testType->id == request()->testType ? 'selected':'' }}>{{ $testType->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 col-xl-3">
                                        <div class="mb-2">
                                            <input type="date" class="form-control" name="start_date" value="{{ request()->start_date }}">
                                        </div>
                                    </div>
                                    <div class="col-6 col-xl-3">
                                        <div class="mb-2">
                                            <input type="date" class="form-control" name="end_date" value="{{ request()->end_date }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button class="btn btn-primary text-uppercase">Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="row px-4 overflow-scroll">
                    <div class="col-12">
                        <form action="{{ route('data.export') }}" method="get">
                            <div class="row d-none">
                                <div class="col-6 col-xl-3">
                                    <div class="mb-3">
                                        <select class="custom-select d-none" name="department" id="departmentf">
                                            <option selected disabled>Select Department</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ $department->id == request()->department ? 'selected':'' }}>{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 col-xl-3">
                                    <div class="mb-3">
                                        <select class="custom-select d-none" name="testType" id="testTypef">
                                            <option selected disabled>Select Test Type</option>
                                            @foreach($testTypes as $testType)
                                                <option value="{{ $testType->id }}" {{ $testType->id == request()->testType ? 'selected':'' }}>{{ $testType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 col-xl-3">
                                    <div class="mb-2">
                                        <input type="date" class="form-control d-none" name="start_date" value="{{ request()->start_date }}">
                                    </div>
                                </div>
                                <div class="col-6 col-xl-3">
                                    <div class="mb-2">
                                        <input type="date" class="form-control d-none" name="end_date" value="{{ request()->end_date }}">
                                    </div>
                                </div>
                            </div>
                            @if($testTypeValues->count() > 0)
                            <div class="mt-2">
                                <button class="btn btn-primary text-uppercase"><i class="fa-solid fa-file-excel me-2"></i>Export Excel</button>
                            </div>
                            @endif
                        </form>
                        <table class="table table-responsive mt-2">
                            <thead>
                            <tr>
                                <th>Department</th>
                                <th class="text-nowrap">Test Type</th>
{{--                                // custom blade directive--}}
                                @admin
                                <th>User</th>
                                @endadmin
                                <th>Control</th>
                                <th>Date</th>
                                <th>Result</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($testTypeValues as $testTypeValue)
                                @can('view',$testTypeValue)
                                <tr class="align-middle">
                                    <td>{{ $testTypeValue->department->name }}</td>
                                    <td>{{ $testTypeValue->testType->name }}</td>
                                    @admin
                                    <td>{{ $testTypeValue->user->name }}</td>
                                    @endadmin
                                    <td>
                                        <form action="{{ route('test_value.destroy',$testTypeValue->id) }}" id="delForm{{ $testTypeValue->id }}" method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                        <div class="btn-group">
                                            @can('delete',$testTypeValue)
                                                <button type="button" class="btn btn-outline-primary btn-sm" form="delForm{{ $testTypeValue->id }}" onclick="return askConfirm({{ $testTypeValue->id }})" title="Delete" data-bs-toggle="tooltip" data-bs-placement="top">
                                                    <i class="fa-regular fa-trash-alt" ></i>
                                                </button>
                                            @endcan
                                        <!-- Button trigger modal -->
                                            @can('update',$testTypeValue)
                                                <button type="button" class="btn btn-outline-primary btn-sm" style="border-radius: 0 0.2rem 0.2rem 0;" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $testTypeValue->id }}">
                                                    <i class="fa-solid fa-pencil" title="Edit" data-bs-toggle="tooltip" data-bs-placement="top" style="font-size: 13px"></i>
                                                </button>
                                        @endcan

                                        {{--   modal id မတူရဘူး edit လုပ်ရင် အ့ကြောင့် id ထည့်ပေးရတယ်--}}
                                        <!-- Edit Test Type Modal -->
                                            <div class="modal fade" id="staticBackdrop{{ $testTypeValue->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel"><i class="fa-solid fa-pen text-primary me-1"></i>Edit Test Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('test_value.update',$testTypeValue->id) }}" id="editTestValueForm{{ $testTypeValue->id }}" method="post">
                                                                @csrf
                                                                @method('put')
                                                                <div class="mb-4">
                                                                    <label class="text-black-50">Department Name</label>
                                                                    <input type="hidden" name="department" value="{{ $testTypeValue->department->id }}">
                                                                    <input class="form-control" type="text" placeholder="{{ $testTypeValue->department->name }}" disabled="disabled">
                                                                </div>
                                                                <div class="mb-4">
                                                                    <label class="text-black-50">Test Type</label>
                                                                    <input type="hidden" name="test_type" value="{{ $testTypeValue->testType->id }}">
                                                                    <input class="form-control" type="text" placeholder="{{ $testTypeValue->testType->name }}" disabled="disabled">
                                                                </div>

                                                                <div class="mb-4">
                                                                    <div class="form-floating">
                                                                        <input type="number" name="amount" class="form-control" id="testTypeValues" placeholder="testTypeValues" value="{{ old('name',$testTypeValue->amount) }}">
                                                                        <label for="testTypeValues">Type Value</label>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger text-white text-uppercase" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary text-uppercase" form="editTestValueForm{{ $testTypeValue->id }}"><i class="fa-solid fa-save me-1"></i>Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </td>
                                    <td>{{ $testTypeValue->created_at->format('d M Y') }}</td>
                                    <td>{{ $testTypeValue->amount }}</td>
                                </tr>
                                @endcan
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">There's no result!</td>
                                </tr>
                            @endforelse
                            @if(request()->department || request()->testType || request()->start_date || request()->end_date)
                                @if(auth()->user()->role == 0)
                                <tr class="border-0">
                                    <td colspan="5" class="border-0 text-end fw-bold" style="font-size: 16px">Total : </td>
                                    <td class="border-0 fw-bold" style="font-size: 16px">{{ $sum }}</td>
                                </tr>
                                @else
                                    <tr class="border-0">
                                        <td colspan="4" class="border-0 text-end fw-bold" style="font-size: 16px">Total : </td>
                                        <td class="border-0 fw-bold" style="font-size: 16px">{{ $sum }}</td>
                                    </tr>
                                @endif
                            @endif
                            </tbody>
                        </table>
                        {{ $testTypeValues->appends(request()->all())->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
