<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class IncomeController extends Controller
{
    public function index()
    {
        $category = Category::orderBy('name', 'asc')->get();
        $totalIncome = Income::where('user_id', auth()->user()->id)->sum('income');
        if (request()->ajax()) {
            $income = Income::with('category')->where('user_id', auth()->user()->id)->orderBy('created_at', 'asc')->get();
            return DataTables::of($income)
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
        return view('income.index', compact('category', 'totalIncome'));
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $validated = Validator::make(
            $request->all(),
            [
                'income' => 'required',
            ]
        );

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            $income = $request->income;
            $income = preg_replace("/[^0-9]/", "", $income);
            $income = (int) $income;

            $category = Income::updateOrCreate([
                'id' => $id
            ], [
                'income' => $income,
                'user_id' => auth()->user()->id,
                'category_id' => $request->category,
                'description' => $request->description,
            ]);
            return response()->json($category);
        }
    }

    public function edit($id)
    {
        $data = Income::find($id);
        return response()->json($data);
    }

    public function destroy(Request $request)
    {
        $category = Income::where('id', $request->id)->delete();
        return Response()->json(['category' => $category, 'success' => 'Data successfully deleted']);
    }

    public function total()
    {
        $totalIncome = Income::sum('income');
        return response()->json(['totalIncome' => number_format($totalIncome, 0, ',', '.')]);
    }
}
