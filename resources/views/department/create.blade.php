@extends('layouts.app')
@section('title') Departments @endsection

@section('content')
    <div class="container">
        <div class="row my-3">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="mb-4">
                            <h4 class="text-capitalize fw-bold">
                                <i class="fa-solid fa-layer-group me-1 text-primary" style="font-size: 25px !important;"></i>
                                Departments
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
                        @if(auth()->user()->role == 0)
                            <button type="button" class="btn btn-primary mb-2 text-uppercase" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <i class="fa-solid fa-plus fa-fw" title="create"></i> Create
                            </button>
                    @endif
                    <!-- Create Department Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fa-solid fa-plus text-primary me-1"></i>Create Department</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('department.store') }}" id="createDepartmentForm" method="post">
                                            @csrf
                                            <div class="mb-4">
                                                <div class="form-floating">
                                                    <input type="text" name="name" class="form-control" id="departments" placeholder="departments" value="{{ old('name') }}">
                                                    <label for="departments">Department's Name</label>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <select class="custom-select" name="hospital">
                                                    <option selected disabled>Select Hospital</option>
                                                    @foreach($hospitals as $hospital)
                                                    <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger text-white text-uppercase" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary text-uppercase" form="createDepartmentForm"><i class="fa-solid fa-save me-2"></i>Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>Departments</th>
                                <th>Hospital</th>
                                <th>Creator</th>
                                <th>Control</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($departments as $department)
                                <tr class="align-middle">
                                    <td class="text-nowrap">{{ $department->name }}</td>
                                    <td>{{ $department->hospital->name }}</td>
                                    <td class="text-nowrap">{{ $department->user->name }}</td>
                                    <td>
                                        <form action="{{ route('department.destroy',$department->id) }}" id="delForm{{ $department->id }}" method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                        <div class="btn-group">
                                            @can('delete',$department)
                                                <button type="button" class="btn btn-outline-primary btn-sm" form="delForm{{ $department->id }}" onclick="return askConfirm({{ $department->id }})" title="Delete" data-bs-toggle="tooltip" data-bs-placement="top">
                                                    <i class="fa-regular fa-trash-alt" ></i>
                                                </button>
                                            @endcan
                                        <!-- Button trigger modal -->
                                            @can('update',$department)
                                                <button type="button" class="btn btn-outline-primary btn-sm" style="border-radius: 0 0.2rem 0.2rem 0;" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $department->id }}">
                                                    <i class="fa-solid fa-pencil" title="Edit" data-bs-toggle="tooltip" data-bs-placement="top" style="font-size: 13px"></i>
                                                </button>
                                        @endcan

                                        {{--   modal id မတူရဘူး edit လုပ်ရင် အ့ကြောင့် id ထည့်ပေးရတယ်--}}
                                        <!-- Edit Department Modal -->
                                            <div class="modal fade" id="staticBackdrop{{ $department->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel"><i class="fa-solid fa-pen text-primary me-1"></i>Edit Department</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('department.update',$department->id) }}" id="editDepartmentForm{{ $department->id }}" method="post">
                                                                @csrf
                                                                @method('put')
                                                                <div class="mb-4">
                                                                    <div class="form-floating">
                                                                        <input type="text" name="name" class="form-control" id="departments" placeholder="departments" value="{{ old('name',$department->name) }}">
                                                                        <label for="departments">Department's Name</label>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-4">
                                                                    <select class="custom-select" name="hospital">
                                                                        <option selected disabled>Select Hospital</option>
                                                                        @foreach(\App\Models\Hospital::all() as $hospital)
                                                                            <option value="{{ $hospital->id }}" {{ $hospital->id == $department->hospital_id ? 'selected':'' }}>{{ $hospital->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger text-white text-uppercase" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary text-uppercase" form="editDepartmentForm{{ $department->id }}"><i class="fa-solid fa-save me-1"></i>Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </td>
                                    <td>{{ $department->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">There's no departments!</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
