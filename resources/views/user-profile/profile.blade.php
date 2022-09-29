@extends('layouts.app')

@section("title") Profile @endsection

@section('content')
    <div class="container">
        <div class="row my-3">
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-3">
                            <div class="card-body">
                                <div class="">
                                    <div class="">
                                        <h4 class="text-capitalize fw-bold">
                                            Profile Name
                                        </h4>
                                    </div>
                                    <form action="{{ route('profile.changeName') }}" method="post">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="floatingInput" placeholder="name" value="{{ auth()->user()->name }}">
                                            <label for="floatingInput"><i class="me-1 fa-regular fa-user"></i>Your Name</label>
                                            @error("name")
                                            <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary text-uppercase">
                                            <i class="fa-solid fa-arrows-rotate"></i>
                                            Change
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card shadow mb-3">
                            <div class="card-body">
                                <div class="">
                                    <div class="">
                                        <h4 class="text-capitalize fw-bold">
                                            Profile Email
                                        </h4>
                                    </div>
                                    <form action="{{ route('profile.changeEmail') }}" method="post">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" placeholder="email" value="{{ auth()->user()->email }}">
                                            <label for="floatingInput"><i class="me-1 fa-regular fa-envelope"></i>Email</label>
                                            @error("email")
                                            <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary text-uppercase">
                                            <i class="fa-solid fa-arrows-rotate"></i>
                                            Change
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card shadow mb-3">
                    <div class="card-body">
                        <div class="">
                            <div class="">
                                <h4 class="text-capitalize fw-bold">
                                    Profile Photo
                                </h4>
                            </div>
                            <div class="mt-3">
                                <img src="{{ isset(Auth::user()->photo) ? asset('storage/profile_thumbnails/'.Auth::user()->photo) : asset('user_default.png') }}" class="user-img my-2 " alt="">
                            </div>
                            <form action="{{ route('profile.changePhoto') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="file-upload mt-3">
                                    <button class="file-upload__button text-uppercase" type="button">File</button>
                                    <span class="file-upload__label"></span>

                                    <input type="file" name="profile_photo" id="inputPhotos" class="file-upload__input @error('profile_photo') is-invalid @enderror" accept="image/jpeg,image/png">
                                    @error('profile_photo')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                                <hr>
                                <button class="btn btn-primary text-uppercase"><i class="fa-solid fa-upload me-1"></i>Upload</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card shadow mb-3">
                    <div class="card-body">
                        <div class="">
                            <div class="">
                                <h4 class="text-capitalize fw-bold">
                                    Change Password
                                </h4>
                            </div>

                            <form action="{{ route('profile.changePassword') }}" id="changeForm" method="post">
                                @csrf
                                <div class="form-floating mb-4">
                                    <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" id="floatingInput" placeholder="current_password">
                                    <label for="floatingInput"><i class="me-1 fa-solid fa-key"></i>Current Password</label>
                                    @error("current_password")
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-floating mb-4">
                                    <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" id="floatingInput" placeholder="new_password">
                                    <label for="floatingInput"><i class="me-1 fa-solid fa-key"></i>New Password</label>
                                    @error("new_password")
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-floating mb-4">
                                    <input type="password" name="new_confirm_password" class="form-control @error('new_confirm_password') is-invalid @enderror" id="floatingInput" placeholder="new_confirm_password">
                                    <label for="floatingInput"><i class="me-1 fa-solid fa-key"></i>Confirm New Password</label>
                                    @error("new_confirm_password")
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="button" class="btn btn-primary text-uppercase" onclick="return changeConfirm()">
                                    <i class="fa-solid fa-arrows-rotate"></i>
                                    Change
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card shadow mb-3">
                    <div class="card-body">
                        <div class="">
                            <div class="">
                                <h4 class="text-capitalize fw-bold">
                                    Signature Photo
                                </h4>
                            </div>
                            @if(isset(Auth::user()->signature))
                                <div class="mt-3">
                                    <img src="{{ asset('storage/signature_thumbnails/'.Auth::user()->signature) }}" style="width: 100px;height: 70px" class="rounded my-2 border border-2 p-1 border-primary" alt="">
                                </div>
                            @endif
                            <form action="{{ route('profile.signature') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="file-upload mt-3">
                                    <button class="file-upload__button text-uppercase" type="button">File</button>
                                    <span class="file-upload__label"></span>

                                    <input type="file" name="signature" id="inputPhotos" class="file-upload__input @error('signature') is-invalid @enderror" accept="image/jpeg,image/png">
                                    @error('signature')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                                <hr>
                                <button class="btn btn-primary text-uppercase"><i class="fa-solid fa-upload me-1"></i>Upload</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection



