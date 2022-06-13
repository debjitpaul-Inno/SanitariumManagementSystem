<?php

namespace App\Http\Controllers\Ward;

use App\Http\Controllers\Controller;
use App\Http\Requests\WardRequest;
use App\Models\Ward;
use App\Repository\WardRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WardController extends Controller
{
    private $repository;
    public function __construct(WardRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(WardRequest $request)
    {
        try {
            if ($request->ajax()) {
                $data = Ward::latest()->get();
                return DataTables::of($data)
                    ->addColumn('status', function ($row) {
                        if($row->status == 1) {
                            return '<span class="badge bg-success mb-1">' . ($row->status == 0 ? "Inactive" : "Active") . '</span>';
                        }else {
                            return '<span class="badge bg-danger mb-1">' . ($row->status == 0 ? "Inactive" : "Active") . '</span>';
                        }
                    })
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route('ward.edit', $row->uuid) . '" class="btn btn-sm btn-primary icon icon-left"><i data-feather="edit"></i></a>
                               <a href="' . route('ward.show', $row->uuid) . '" class="btn btn-sm btn-primary icon icon-left"><i data-feather="info"></i></a>
                               <button data-bs-toggle="modal" data-bs-target="#danger" onclick="onDelete(this)" id="' . route('ward.destroy', $row->uuid) . '" name="delBtn"
                                                                   class="btn btn-sm btn-danger icon icon-left "><i data-feather="trash-2"></i></button>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }
            return view('ward.index');
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }


    public function create()
    {
        return view('ward.create');
    }

    public function store(WardRequest $request)
    {
        try {
            $validated = $request->validated();
            if($validated)
            {
                $data = $request->all();
                $this->repository->create($data);
                return redirect()->route('ward.index')->with('success', 'Ward Created Successfully');
            }
        }catch(Exception $exception){
            return redirect()->route('ward.index')->withErrors(['errors' => $exception->getMessage()]);
        }

    }


    public function show($uuid)
    {
        $ward = $this->repository->findByUuid($uuid);
        return view('ward.info', ['ward' => $ward]);
    }


    public function edit($uuid)
    {
        $ward= $this->repository->findByUuid($uuid);
        return view('ward.edit', ['ward'=> $ward]);
    }


    public function update(wardRequest $request, $uuid)
    {
        try {
            $data = $request->all();
            $this->repository->updateByUuid($uuid, $data);
            return redirect()->route('ward.index')->with('success', 'Ward Updated Successfully');
        }
        catch (Exception $exception)
        {
            return redirect()->route('ward.index')->withErrors(['errors' => $exception->getMessage()]);
        }
    }


    public function destroy($uuid)
    {
        try {
            $this->repository->deleteByUuid($uuid);
            return redirect()->route('ward.index')->with('success', 'Ward Deleted Successfully');
        }
        catch (Exception $exception)
        {
            return redirect()->route('ward.index')->withErrors(['errors' => $exception->getMessage()]);
        }
    }
}
