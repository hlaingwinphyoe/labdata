@extends('layouts.app')
@section('title') Data Entry | 550MCH Lab @endsection
@section('content')
    <div class="container">
        <div class="row my-3">
            <div class="col-12 px-5">
                <a href="{{ route('test_value.index') }}" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i></a>
                <div class="row px-lg-5" id="test_types">
                    @foreach($testTypes as $testType)
                        <div class="col-12 col-lg-5">
                            <div class="box-container">
                                <div class="box-title">
                                    {{ $testType->name }}
                                </div>
                                <form action="{{ route('test_value.store') }}" id="saveForm{{ $testType->id }}"  method="post" class="box-content">
                                    @csrf
                                    <input type="hidden" name="department_id" value="{{ $testType->department_id }}">
                                    <input type="hidden" name="test_type_id" value="{{ $testType->id }}">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="amount" class="form-control" placeholder="Type Value" id="amount" required>
                                        <label for="amount">Type Value</label>
                                    </div>
                                    <button class="btn btn-primary rounded-circle" onclick="addValue({{ $testType->id }})" id="addBtn{{ $testType->id }}"><i class="fa-solid fa-plus"></i></button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop

@push('script')
    <script>
        function addValue(id){
            let saveForm = document.getElementById('saveForm'+id);
            let addBtn = document.getElementById('addBtn'+id);

            saveForm.addEventListener('submit',function (e){
                e.preventDefault();
                // let formData = new FormData(this);
                $.post($(this).attr('action'),$(this).serialize(),function (response){
                    // console.log(response.data);
                    if (response.status === 'success'){
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            title: 'Successfully Added!'
                        })

                        addBtn.setAttribute('disabled','disabled');

                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Fail',
                            text: 'Something went wrong!',
                        })
                    }
                })
            })
        }

    </script>
@endpush
