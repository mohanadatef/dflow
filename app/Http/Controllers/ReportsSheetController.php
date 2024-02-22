<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Exports\ReportExport;
use App\Imports\ReportsImport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportsSheetController extends Controller
{
    public function index(Request $request)
    {
        $datas = Report::query();

        if($request->name) {
            $datas = $datas->where('name', $request->name);
        }

        if($request->platform) {
            $datas = $datas->where('platform', $request->platform);
        }

        $datas = $datas->paginate();

        return view('dashboard.reports.index', compact('datas'));
    }

    public function upload(Request $request)
    {
        Excel::import(new ReportsImport, $request->file);

        return redirect()->route('reports.index')->with('success', 'Report Imported Successfully');
    }

    public function export(Request $request): BinaryFileResponse
    {
        return Excel::download(new ReportExport($request), 'report.xlsx');
    }
}
