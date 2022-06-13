<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Http\Requests\LabRequest;
use App\Models\Lab;
use App\Models\Room;
use App\Repository\LabRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use function GuzzleHttp\Promise\all;

class LabController extends Controller
{
    private $repository;
    public function __construct(LabRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(LabRequest $request)
    {
        try {
           if ($request->ajax()) {
               $data = Lab::latest()->get();
               return DataTables::of($data)->editColumn('address',  function(Lab $lab) {
                   return  $lab->address ?? 'N/A';
               })
                   ->addColumn('status', function ($row) {
                       if($row->status == 1) {
                           return '<span class="badge bg-success mb-1">' . ($row->status == 0 ? "Inactive" : "Active") . '</span>';
                       }else {
                           return '<span class="badge bg-danger mb-1">' . ($row->status == 0 ? "Inactive" : "Active") . '</span>';
                       }
                   })
                   ->editColumn('room_id', function ($row){
                       return '<a href="'.route('room.show',$row->rooms->uuid ?? '').'" class="badge-link-success" style="text-decoration: none">'. $row->rooms->room_number  . '</a>' ?? 'N/A' ;
                   })
                   ->addIndexColumn()
                   ->addColumn('action', function ($row) {
                       $btn = '<a href="' . route('lab.edit', $row->uuid) . '" class="btn btn-sm btn-primary icon icon-left"><i data-feather="edit"></i></a>
                               <a href="' . route('lab.show', $row->uuid) . '" class="btn btn-sm btn-primary icon icon-left"><i data-feather="info"></i></a>
                               <button data-bs-toggle="modal" data-bs-target="#danger" onclick="onDelete(this)" id="' . route('lab.destroy', $row->uuid) . '" name="delBtn"
                                                                   class="btn btn-sm btn-danger icon icon-left "><i data-feather="trash-2"></i></button>';
                       return $btn;
                   })
                   ->rawColumns(['action', 'status', 'room_id'])
                   ->make(true);
           }
            return view('lab.index');
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }


    public function create()
    {
        $rooms = Room::all();
        return view('lab.create', ['rooms' => $rooms]);
    }

    public function store(LabRequest $request)
    {

        try {
            $validated = $request->validated();
            if($validated)
            {
                $data = $request->all();
                $this->repository->createLab($data);
                return redirect()->route('lab.index')->with('success', 'Lab Created Successfully');
            }
        }catch(Exception $exception){
            return redirect()->route('lab.index')->withErrors(['errors' => $exception->getMessage()]);
        }

    }


    public function show($uuid)
    {
        $lab = $this->repository->findByUuid($uuid);
        return view('lab.info', ['lab' => $lab]);
    }


    public function edit($uuid)
    {
        $rooms = Room::all();
        $lab= $this->repository->findByUuid($uuid);
        return view('lab.edit', ['lab'=> $lab, 'rooms'=>$rooms]);
    }


    public function update(LabRequest $request, $uuid)
    {
        try {
            $data = $request->all();
            $this->repository->updateLab($uuid, $data);
            return redirect()->route('lab.index')->with('success', 'Lab Updated Successfully');
        }
        catch (Exception $exception)
        {
            return redirect()->route('lab.index')->withErrors(['errors' => $exception->getMessage()]);
        }
    }


    public function destroy($uuid)
    {
        try {
            $this->repository->deleteByUuid($uuid);
            return redirect()->route('lab.index')->with('success', 'Lab Deleted Successfully');
        }
        catch (Exception $exception)
        {
            return redirect()->route('lab.index')->withErrors(['errors' => $exception->getMessage()]);
        }
    }
}
