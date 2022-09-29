@extends('layouts.app')
@section('title') Users @endsection

@section('content')
    <div class="container">
        <div class="row my-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <h4 class="text-capitalize fw-bold">
                                <i class="fa-solid fa-users me-1 text-primary" style="font-size: 25px !important;"></i>
                                Users
                            </h4>
                        </div>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary mb-2 text-uppercase" style="border-radius: 0.2rem;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <i class="fa-solid fa-plus fa-fw" title="create"></i> Create
                        </button>
                        <!-- Create User Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fa-solid fa-plus text-primary me-1"></i>Create User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('register.post') }}" id="createUserForm" method="post">
                                            @csrf
                                            <div class="mb-3">
                                                <div class="form-floating">
                                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="name" value="{{ old('name') }}">
                                                    <label for="name">User Name</label>
                                                    @error('name')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-floating">
                                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="email" value="{{ old('email') }}">
                                                    <label for="email">Email</label>
                                                    @error('email')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-floating">
                                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="password" value="{{ old('password') }}">
                                                    <label for="password">Password</label>
                                                    @error('password')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Choose Hospitals</label><br>
                                                @forelse($hospitals as $hospital)
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" value="{{ $hospital->id }}" id="{{ $hospital->name }}">
                                                        <label for="{{ $hospital->name }}" class="form-check-label">{{ $hospital->name }}</label>
                                                    </div>
                                                @empty
                                                @endforelse
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger text-white text-uppercase" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary text-uppercase" form="createUserForm"><i class="fa-solid fa-save me-1"></i>Register</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Control</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                                <tr class="align-middle">
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role ?? $user->role == 1 ? 'Staff':'' }}</td>
                                    <td class="text-nowrap">
                                        <form action="{{ route('user.destroy',$user->id) }}" id="delForm{{ $user->id }}" method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                        <form action="{{ route('user.makeAdmin') }}" method="post" id="makeAdminForm{{ $user->id }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                        </form>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-outline-primary btn-sm" title="Delete" form="delForm{{ $user->id }}" onclick="return askConfirm({{ $user->id }})">
                                                <i class="fa-regular fa-trash-alt" ></i> Delete
                                            </button>
                                            <button type="button" class="btn btn-outline-primary btn-sm" title="Change Role" onclick="return makeAdmin({{ $user->id }})">
                                                <i class="fa-solid fa-user-edit"></i> Make Admin
                                            </button>
                                        </div>
                                    </td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">There's no staff account!</td>
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
