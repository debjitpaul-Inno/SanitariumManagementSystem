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
                            <h3 class="text-capitalize">Bed List Information</h3>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('bed-list.index')}}" class="btn-sm btn-primary">BACK</a>
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
                                    <b><label for="bed_number" class="mb-2">Bed Number</label></b>
                                    <p>{{ ucwords($bedList->bed_number ?? 'N/A') }}</p>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <b><label for="bed_type_id" class="mb-2">Bed Type</label></b>
                                    <p>{{ ucwords($bedList->bedTypes->title ?? 'N/A') }}</p>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <b><label for="floor_no" class="mb-2 d-block">Room Number</label></b>
                                    <a href="{{ route('room.show',$bedList->rooms->uuid) }}" class="badge-link-success" style="text-decoration: none">{{ ucwords($bedList->rooms->room_number) ?? 'N/A' }}</a>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <b><label for="price" class="mb-2">Price</label></b>
                                    <p>{{ ucwords($bedList->price ?? 'N/A')  }} BDT</p>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <b><label for="description" class="mb-2">Description</label></b>
                                    <p>{{ ucfirst($bedList->description ?? 'N/A') }}</p>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <b><label for="description" class="mb-1">Status</label></b>
                                    <br>
                                    @if($bedList->status == 1)
                                        <p class="badge bg-success mb-1">{{ ucwords("Active" ?? 'N/A') }}</p>
                                    @else
                                        <p class="badge bg-danger mb-1">{{ucwords("Inactive" ?? 'N/A')}}</p>
                                    @endif
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <b><label for="description" class="mb-2">Availability</label></b>
                                    <br>
                                    @if($bedList->availability == 1)
                                        <p class="badge bg-success mb-1">{{ ucwords("Available" ?? 'N/A') }}</p>
                                    @else
                                        <p class="badge bg-danger mb-1" >{{ucwords("Not Available" ?? 'N/A')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
