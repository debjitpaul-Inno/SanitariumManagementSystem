<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomTypeRequest;
use App\Models\RoomType;
use App\Repository\RoomTypeRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoomTypeController extends Controller
{
    private $repository;
    public function __construct(RoomTypeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(RoomTypeRequest $request)
    {
        try {
            if ($request->ajax()) {
                $data = RoomType::latest()->get();
                return DataTables::of($data)
                    ->editColumn('description',  function(RoomType $type) {
                        return  $type->description ?? 'N/A';
                    })
                    ->addColumn('status', function ($row) {
                        if($row->status == 1) {
                            return '<span class="badge bg-success mb-1">' . ($row->status == 0 ? "Inactive" : "Active") . '</span>';
                        }else {
                            return '<span class="badge bg-danger mb-1">' . ($row->status == 0 ? "Inactive" : "Active") . '</span>';
                        }
                    })
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route('room-type.edit', $row->uuid) . '" class="btn btn-sm btn-primary icon icon-left"><i data-feather="edit"></i></a>
                               <a href="' . route('room-type.show', $row->uuid) . '" class="btn btn-sm btn-primary icon icon-left"><i data-feather="info"></i></a>
                               <button data-bs-toggle="modal" data-bs-target="#danger" onclick="onDelete(this)" id="' . route('room-type.destroy', $row->uuid) . '" name="delBtn"
                                                                   class="btn btn-sm btn-danger icon icon-left "><i data-feather="trash-2"></i></button>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }
            return view('roomManager.roomType.index');
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }


    public function create()
    {
        return view('roomManager.roomType.create');
    }

    public function store(RoomTypeRequest $request)
    {
        try {
            $validated = $request->validated();
            if($validated)
            {
                $data = $request->all();
                $this->repository->create($data);
                return redirect()->route('room-type.index')->with('success', 'Room Type Created Successfully');
            }
        }catch(Exception $exception){
            return redirect()->route('room-type.index')->withErrors(['errors' => $exception->getMessage()]);
        }

    }


    public function show($uuid)
    {
        $type = $this->repository->findByUuid($uuid);
        return view('roomManager.roomType.info', ['type' => $type]);
    }


    public function edit($uuid)
    {
        $type= $this->repository->findByUuid($uuid);
        return view('roomManager.roomType.edit', ['type'=> $type]);
    }


    public function update(RoomTypeRequest $request, $uuid)
    {
        try {
            $data = $request->all();
            $this->repository->updateByUuid($uuid, $data);
            return redirect()->route('room-type.index')->with('success', 'Room Type Updated Successfully');
        }
        catch (Exception $exception)
        {
            return redirect()->route('room-type.index')->withErrors(['errors' => $exception->getMessage()]);
        }
    }


    public function destroy($uuid)
    {
        try {
            $this->repository->deleteByUuid($uuid);
            return redirect()->route('room-type.index')->with('success', 'Room Type Deleted Successfully');
        }
        catch (Exception $exception)
        {
            return redirect()->route('room-type.index')->withErrors(['errors' => $exception->getMessage()]);
        }
    }
}
