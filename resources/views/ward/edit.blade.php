@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-12 col-sm-12 col-xs-12 order-md-1 order-last ">
                            <h3 class="text-capitalize">Edit Ward Information</h3>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('ward.index')}}" class="btn-sm btn-primary">BACK</a>
                            </div>
                            <hr/>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form id="editForm" class="form form-vertical" action="{{route('ward.update', $ward->uuid)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="mb-2">Ward Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{$ward->name}}"
                                                       placeholder="WarD Name" required>
                                            </div>
                                            <span class="text-danger">@error('name'){{ $message }}@enderror</span>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="ward_number" class="mb-2">Ward Number</label>
                                                <input type="text" class="form-control" id="ward_number" name="ward_number" value="{{$ward->ward_number}}"
                                                       placeholder="Ward Number" required>
                                            </div>
                                            <span class="text-danger">@error('ward_number'){{ $message }}@enderror</span>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="floor" class="mb-2">Floor Number</label>
                                                <input type="text" class="form-control" id="floor" name="floor" value="{{$ward->floor}}"
                                                       placeholder="Floor Number" required>
                                            </div>
                                            <span class="text-danger">@error('floor'){{ $message }}@enderror</span>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="description" class="mb-2">Description</label>
                                                <textarea class="form-control"
                                                          name="description" id="description"
                                                          rows="2"
                                                          >{{$ward->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="status"><span class="required">*</span> Status</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status" id="active"
                                                           value="1" {{($ward->status == "1") ? "checked" : ""}} required>
                                                    <label class="form-check-label" for="active">Active</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status" id="inactive"
                                                           value="0" {{($ward->status == "0") ? "checked" : ""}} required>
                                                    <label class="form-check-label" for="inactive">Inactive</label>
                                                </div>
                                                <span class="text-danger">@error('status'){{ $message }}@enderror</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end mb-2">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('customScripts')

    <script>

        $("#editForm").validate({
            errorPlacement: function (error, e) {
                e.parents('.form-group').append(error);
            },
            rules:{
                name: "required",
                ward_number: "required",
                floor: "required",
                status:"required",
            },
            messages:{
                name:"Ward name is required",
                ward_number: "Ward number is required",
                floor: "Floor number is required",
                status: "Status is required",
            }
        });

    </script>
@endpush

