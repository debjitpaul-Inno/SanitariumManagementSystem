@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-12 col-sm-12 col-xs-12 order-md-1 order-last ">
                            <h3 class="text-capitalize">Edit Room Information</h3>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('room.index')}}" class="btn-sm btn-primary">BACK</a>
                            </div>
                            <hr/>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form id="editForm" class="form form-vertical" action="{{route('room.update', $room->uuid)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="room_number" class="mb-2">Room Number</label>
                                                <input type="text" class="form-control" id="room_number" name="room_number" value="{{$room->room_number}}"
                                                       placeholder="Type Name" required>
                                            </div>
                                            <span class="text-danger">@error('name'){{ $message }}@enderror</span>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="ward_id" class="mb-2 d-flex align-items-center"><span
                                                        class="required">*</span> Ward Name</label>
                                                <select name="ward_id"
                                                        class="form-select select2">
                                                    @foreach($wards as $ward)
                                                        <option hidden
                                                                value="{{old('ward_id', $ward->id)}}" {{$room->ward_id == $ward->id ? 'selected' : ''}}>{{$ward->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span
                                                class="text-danger">@error('category_id'){{ $message }}@enderror</span>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="room_type_id" class="mb-2 d-flex align-items-center"><span
                                                        class="required">*</span> Room Type</label>
                                                <select name="room_type_id"
                                                        class="form-select select2">
                                                    @foreach($roomTypes as $type)
                                                        <option hidden
                                                                value="{{old('room_type_id', $type->id)}}" {{$room->room_type_id == $type->id ? 'selected' : ''}}>{{$type->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span
                                                class="text-danger">@error('category_id'){{ $message }}@enderror</span>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="description" class="mb-2">Description</label>
                                                <textarea class="form-control"
                                                          name="description" id="description"
                                                          rows="2"
                                                          >{{$room->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="status"><span class="required">*</span> Status</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status" id="active"
                                                           value="1" {{($type->status == "1") ? "checked" : ""}} required>
                                                    <label class="form-check-label" for="active">Active</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status" id="inactive"
                                                           value="0" {{($type->status == "0") ? "checked" : ""}} required>
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
                room_number: "required",
                status:"required",
                ward_id:"required",
                room_type_id:"required",
            },
            messages:{
                room_number:"Room Number is required",
                status: "Status is required",
                ward_id: "Ward is required",
                room_type_id: "Room Type is required",
            }
        });

    </script>
@endpush

