@extends('layouts.app')
@section('title') Test Types @endsection

@section('content')
    <div class="container">
        <div class="row my-3">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="mb-4">
                            <h4 class="text-capitalize fw-bold">
                                <i class="fa-solid fa-flask-vial me-1 text-primary" style="font-size: 25px !important;"></i>
                                Test Types
                            </h4>
                        </div>
                        @if ($errors->any())
                            <div class="text-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary mb-2 text-uppercase" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <i class="fa-solid fa-plus fa-fw" title="create"></i> Create
                    </button>
                    <!-- Create Test Type Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fa-solid fa-plus text-primary me-1"></i>Create Test Type</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('test_type.store') }}" id="createTestTypeForm" method="post">
                                            @csrf
                                            <div class="mb-4">
                                                <div class="form-floating">
                                                    <input type="text" name="name" class="form-control" id="test_types" placeholder="test_types" value="{{ old('name') }}">
                                                    <label for="test_types">Test Type's Name</label>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <select class="custom-select" name="department">
                                                    <option selected disabled>Select Department</option>
                                                    @foreach(\App\Models\Department::all() as $department)
                                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger text-white text-uppercase" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary text-uppercase" form="createTestTypeForm"><i class="fa-solid fa-save me-2"></i>Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>Test Types</th>
                                <th>Department</th>
                                @admin
                                <th>Creator</th>
                                @endadmin
                                <th>Control</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($test_types as $test_type)
                                <tr class="align-middle">
                                    <td class="text-nowrap">{{ $test_type->name }}</td>
                                    <td>{{ $test_type->department->name }}</td>
                                    @admin
                                    <td class="text-nowrap">{{ $test_type->user->name }}</td>
                                    @endadmin
                                    <td>
                                        <form action="{{ route('test_type.destroy',$test_type->id) }}" id="delForm{{ $test_type->id }}" method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                        <div class="btn-group">
                                            @can('delete',$test_type)
                                                <button type="button" class="btn btn-outline-primary btn-sm" form="delForm{{ $test_type->id }}" onclick="return askConfirm({{ $test_type->id }})" title="Delete" data-bs-toggle="tooltip" data-bs-placement="top">
                                                    <i class="fa-regular fa-trash-alt" ></i>
                                                </button>
                                            @endcan
                                        <!-- Button trigger modal -->
                                            @can('update',$test_type)
                                                <button type="button" class="btn btn-outline-primary btn-sm" style="border-radius: 0 0.2rem 0.2rem 0;" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $test_type->id }}">
                                                    <i class="fa-solid fa-pencil" title="Edit" data-bs-toggle="tooltip" data-bs-placement="top" style="font-size: 13px"></i>
                                                </button>
                                        @endcan

                                        {{--   modal id မတူရဘူး edit လုပ်ရင် အ့ကြောင့် id ထည့်ပေးရတယ်--}}
                                        <!-- Edit Test Type Modal -->
                                            <div class="modal fade" id="staticBackdrop{{ $test_type->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel"><i class="fa-solid fa-pen text-primary me-1"></i>Edit Test Type</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('test_type.update',$test_type->id) }}" id="editTestTypeForm{{ $test_type->id }}" method="post">
                                                                @csrf
                                                                @method('put')
                                                                <div class="mb-4">
                                                                    <div class="form-floating">
                                                                        <input type="text" name="name" class="form-control" id="test_types" placeholder="test_types" value="{{ old('name',$test_type->name) }}">
                                                                        <label for="test_types">Test Type's Name</label>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-4">
                                                                    <select class="custom-select" name="department">
                                                                        <option selected disabled>Select Department</option>
                                                                        @foreach($departments as $department)
                                                                            <option value="{{ $department->id }}" {{ $department->id == $test_type->department_id ? 'selected':'' }}>{{ $department->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger text-white text-uppercase" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary text-uppercase" form="editTestTypeForm{{ $test_type->id }}"><i class="fa-solid fa-save me-1"></i>Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </td>
                                    <td>{{ $test_type->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">There's no test types!</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $test_types->appends(request()->all())->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
