@extends('layouts.app')
@section('title') Tests | 550MCH Lab @endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-10">
                <div class="box-container p-4" style="margin: 25px 17px">
                    <div class="mb-3">
                        <select class="custom-select" name="department_id" form="saveForm" id="departments">
                            <option selected disabled>Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 px-5">
                <div class="row px-lg-5" id="test_types">

                </div>
            </div>
        </div>
    </div>
@stop
@push('script')

    <script>
        $("#departments").on('change',function (){
            let id = $(this).val();
            // console.log(id);

            $("#test_types").empty();
            $("#test_types").append(`
                <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                    <span class="loader"></span>
                </div>
            `);

            $.ajax({
                type : 'GET',
                url : '/test_form/'+id,
                success : function (response){
                    var response = JSON.parse(response);

                    // console.log(response);
                    $('#test_types').empty();
                    // $('#test_types').append(`<option value="0" disabled selected>Select Test Type</option>`);

                    response.forEach(el => {
                        $("#test_types").append(`
                        <div class="col-12 col-lg-5">
                            <div class="box-container">
                                <div class="box-title">
                                    ${el['name']}
                                </div>
                                <form action="{{ route('test_value.store') }}" id="saveForm" method="post" class="box-content">
                                    @csrf
                        <input type="hidden" name="department_id" value="${el['department_id']}">
                                    <input type="hidden" name="test_type_id" value="${el['id']}">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="test_values" class="form-control" placeholder="Type Value">
                                        <label for="test_values">Type Value</label>
                                    </div>
                                    <button class="btn btn-primary rounded-circle"><i class="fa-solid fa-plus"></i></button>
                                </form>
                            </div>
                        </div>
                        `);
                    });
                }
            });

        });


    </script>

@endpush

