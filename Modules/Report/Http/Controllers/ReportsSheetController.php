<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Report\Entities\Report;
use Modules\Report\Exports\ReportExport;
use Modules\Report\Imports\ReportsImport;
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

        return view('report::reports.index', compact('datas'));
    }

    public function upload(Request $request)
    {
        Excel::import(new ReportsImport, $request->file);

        return redirect()->route('reports.index')->with('success', getCustomTranslation('report_imported_successfully'));
    }

    public function export(Request $request): BinaryFileResponse
    {
        return Excel::download(new ReportExport($request), 'report.xlsx');
    }
}
