@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                @if ($errors)
                    @foreach ($errors->all() as $error)
                        <x-alert type="danger" message="{{$error}}"></x-alert>
                    @endforeach
                @endif
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-12 col-sm-12 col-xs-12 order-md-1 order-last ">
                            <h3 class="text-capitalize">{{'Room Information'}}</h3>
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
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <b><label for="name" class="mb-2">Room Number</label></b>
                                    <p>{{ ucwords($room->room_number ?? 'N/A') }}</p>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <b><label for="name" class="mb-2 d-block">Ward Name</label></b>
                                    <a href="{{ route('ward.show',$room->wards->uuid) }}" class="badge-link-success" style="text-decoration: none">{{ ucwords($room->wards->name) ?? 'N/A' }}</a>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <b><label for="name" class="mb-2  d-block">Room Type</label></b>
                                    <a href="{{ route('room-type.show',$room->roomTypes->uuid) }}" class="badge-link-success" style="text-decoration: none">{{ ucwords($room->roomTypes->name) ?? 'N/A' }}</a>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <b><label for="description" class="mb-2">Description</label></b>
                                    <p>{{ ucwords($room->description ?? 'N/A') }}</p>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <b><label for="status" class="mb-2">{{'Status'}}</label></b>
                                    <br>
                                    @if($room->status == 1)
                                        <p class="badge bg-success mb-1">{{ ucwords("Active" ?? 'N/A') }}</p>
                                    @else
                                        <p class="badge bg-danger mb-1">{{ucwords("Inactive" ?? 'N/A')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
