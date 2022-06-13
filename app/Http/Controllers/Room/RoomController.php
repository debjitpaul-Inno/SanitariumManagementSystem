<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Ward;
use App\Repository\RoomRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoomController extends Controller
{
    private $repository;
    public function __construct(RoomRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(RoomRequest $request)
    {
        try {
            if ($request->ajax()) {
                $data = Room::latest()->get();
                return DataTables::of($data)
                    ->addColumn('room_type_id',  function($row) {
                        if ($row->roomTypes != null){
                            return '<a href="'.route('room-type.show',$row->roomTypes->uuid ?? '').'" class="badge-link-success" style="text-decoration: none">'. $row->roomTypes->name  . '</a>' ?? 'N/A' ;
                        }else{
                            return '<span class="badge-link-danger" style="text-decoration: none">'. 'N/A'   . '</a>' ;
                        }
                    })
                    ->addColumn('ward_id',  function($row) {
                        if ($row->wards != null){
                            return '<a href="'.route('ward.show',$row->wards->uuid ?? '').'" class="badge-link-success" style="text-decoration: none">'. $row->wards->name  . '</a>' ?? 'N/A' ;
                        }else{
                            return '<span class="badge-link-danger" style="text-decoration: none">'. 'N/A'   . '</a>' ;
                        }
                    })
                    ->addColumn('status', function ($row) {
                        if($row->status == 1) {
                            return '<span class="badge bg-success">' . ($row->status == 0 ? "Inactive" : "Active") . '</span>';
                        }else {
                            return '<span class="badge bg-danger">' . ($row->status == 0 ? "Inactive" : "Active") . '</span>';
                        }
                    })
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route('room.edit', $row->uuid) . '" class="btn btn-sm btn-primary icon icon-left"><i data-feather="edit"></i></a>
                               <a href="' . route('room.show', $row->uuid) . '" class="btn btn-sm btn-primary icon icon-left"><i data-feather="info"></i></a>
                               <button data-bs-toggle="modal" data-bs-target="#danger" onclick="onDelete(this)" id="' . route('room.destroy', $row->uuid) . '" name="delBtn"
                                                                   class="btn btn-sm btn-danger icon icon-left "><i data-feather="trash-2"></i></button>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'status','room_type_id','ward_id'])
                    ->make(true);
            }
            return view('roomManager.room.index');
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }


    public function create()
    {
        $wards = Ward::where('status',1)->get();
        $roomTypes = RoomType::where('status',1)->get();
        return view('roomManager.room.create', ['wards' => $wards,'roomTypes'=>$roomTypes]);
    }

    public function store(RoomRequest $request)
    {
        try {
            $validated = $request->validated();
            if($validated)
            {
                $data = $request->all();
                $this->repository->create($data);
                return redirect()->route('room.index')->with('success', 'Room Created Successfully');
            }
        }catch(Exception $exception){
            return redirect()->route('room.index')->withErrors(['errors' => $exception->getMessage()]);
        }

    }


    public function show($uuid)
    {
        $wards = Ward::all();
        $roomTypes = RoomType::all();
        $room = $this->repository->findByUuid($uuid);
        return view('roomManager.room.info', ['room' => $room,'wards'=>$wards,'roomTypes'=>$roomTypes]);
    }


    public function edit($uuid)
    {
        $wards = Ward::all();
        $roomTypes = RoomType::all();
        $room= $this->repository->findByUuid($uuid);
        return view('roomManager.room.edit', ['room'=> $room,'wards'=>$wards,'roomTypes'=>$roomTypes]);
    }


    public function update(RoomRequest $request, $uuid)
    {
        try {
            $data = $request->all();
            $this->repository->updateByUuid($uuid, $data);
            return redirect()->route('room.index')->with('success', 'Room Updated Successfully');
        }
        catch (Exception $exception)
        {
            return redirect()->route('room.index')->withErrors(['errors' => $exception->getMessage()]);
        }
    }


    public function destroy($uuid)
    {
        try {
            $this->repository->deleteByUuid($uuid);
            return redirect()->route('room.index')->with('success', 'Room Deleted Successfully');
        }
        catch (Exception $exception)
        {
            return redirect()->route('room.index')->withErrors(['errors' => $exception->getMessage()]);
        }
    }
}
