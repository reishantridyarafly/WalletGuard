<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $users = User::where('id', '!=', auth()->user()->id)->orderBy('name', 'asc')->get();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('active_status', function ($data) {
                    $status = $data->active_status == 0 ? '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="active_status" name="active_status" data-id="' . $data->id . '" checked>
                    <label class="form-check-label" for="active_status"></label>
                    </div>' : '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="active_status" data-id="' . $data->id . '" name="active_status">
                    <label class="form-check-label" for="active_status"></label>
                    </div>';
                    return $status;
                })
                ->addColumn('action', function ($data) {
                    $btn = '<button type="button" class="btn btn-warning btn-sm me-1" data-id="' . $data->id . '" id="btnEdit"><i
                    class="mdi mdi-pencil"></i></button>';
                    $btn = $btn . '<button type="button" class="btn btn-danger btn-sm" data-id="' . $data->id . '" id="btnDelete"><i
                    class="mdi mdi-trash-can"></i></button>';
                    return $btn;
                })
                ->rawColumns(['active_status', 'action'])
                ->make(true);
        }
        return view('users.index');
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $validated = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|unique:users,email,' . $id,
                'phone_number' => 'required|min:11|max:13|unique:users,phone_number,' . $id,
                'type' => 'required',
            ]
        );

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            $user = User::updateOrCreate([
                'id' => $id
            ], [
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make(12345),
                'type' => $request->type,
            ]);
            return response()->json($user);
        }
    }

    public function edit($id)
    {
        $data = User::find($id);
        return response()->json($data);
    }

    public function destroy(Request $request)
    {
        $user = User::where('id', $request->id)->delete();
        return Response()->json(['user' => $user, 'success' => 'Data successfully deleted']);
    }

    public function updateActiveStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->active_status = $request->active_status;
        $user->save();
        return response()->json($user);
    }
}
