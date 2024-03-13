<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $category = Category::orderBy('name', 'asc')->get();
            return DataTables::of($category)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<button type="button" class="btn btn-warning btn-sm me-1" data-id="' . $data->id . '" id="btnEdit"><i
                    class="mdi mdi-pencil"></i></button>';
                    $btn = $btn . '<button type="button" class="btn btn-danger btn-sm" data-id="' . $data->id . '" id="btnDelete"><i
                    class="mdi mdi-trash-can"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('category.index');
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $validated = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:categories,name,' . $id,
            ]
        );

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            $category = Category::updateOrCreate([
                'id' => $id
            ], [
                'name' => $request->name,
            ]);
            return response()->json($category);
        }
    }

    public function edit($id)
    {
        $data = Category::find($id);
        return response()->json($data);
    }

    public function destroy(Request $request)
    {
        $category = Category::where('id', $request->id)->delete();
        return Response()->json(['category' => $category, 'success' => 'Data successfully deleted']);
    }
}
