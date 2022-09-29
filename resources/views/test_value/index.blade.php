@extends('layouts.app')
@section('title') Tests @endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-10">
                <div class="box-container p-4" style="margin: 25px 17px">
                    <form action="{{ route('test_value.testTypeByDepartment') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-7 col-lg-8 col-xxl-10">
                                <div class="mb-3">
                                    <select class="custom-select @error('department') is-invalid @enderror" name="department" id="departments" required>
                                        <option selected disabled>Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-5 col-lg-4 col-xxl-2">
                                <button class="btn btn-primary text-uppercase"><i class="fa-solid fa-plus me-1"></i>Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@push('script')


@endpush

