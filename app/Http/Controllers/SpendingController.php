<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Spending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SpendingController extends Controller
{
    public function index()
    {
        $category = Category::orderBy('name', 'asc')->get();
        $totalSpending = Spending::where('user_id', auth()->user()->id)->sum('spending');
        if (request()->ajax()) {
            $spending = Spending::with('category')->where('user_id', auth()->user()->id)->orderBy('created_at', 'asc')->get();
            return DataTables::of($spending)
                ->addIndexColumn()
                ->addColumn('category', function ($data) {
                    if ($data->category && $data->category->name) {
                        return $data->category->name;
                    } else {
                        return "-";
                    }
                })

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
        return view('spending.index', compact('category', 'totalSpending'));
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $validated = Validator::make(
            $request->all(),
            [
                'spending' => 'required',
            ]
        );

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            $spending = $request->spending;
            $spending = preg_replace("/[^0-9]/", "", $spending);
            $spending = (int) $spending;

            $category = Spending::updateOrCreate([
                'id' => $id
            ], [
                'spending' => $spending,
                'user_id' => auth()->user()->id,
                'category_id' => $request->category,
                'description' => $request->description,
            ]);
            return response()->json($category);
        }
    }

    public function edit($id)
    {
        $data = Spending::find($id);
        return response()->json($data);
    }

    public function destroy(Request $request)
    {
        $category = Spending::where('id', $request->id)->delete();
        return Response()->json(['category' => $category, 'success' => 'Data successfully deleted']);
    }

    public function total()
    {
        $totalSpending = Spending::sum('spending');
        return response()->json(['totalSpending' => number_format($totalSpending, 0, ',', '.')]);
    }
}
