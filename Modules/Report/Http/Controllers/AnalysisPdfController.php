<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\CompanySocial;
use Modules\CoreData\Entities\Platform;
use Modules\Report\Service\AnalysisPdfService;

class AnalysisPdfController extends Controller
{
    protected  $service;

    /**
     * @required must user be login
     *
     * @return void
     */
    public function __construct(AnalysisPdfService $service)
    {
        $this->service = $service;
    }

    public function prepare()
    {
        $companiesData = $this->service->get_top_companies_data();
        $platforms = $this->service->get_platforms();

        return view('report::analysis.prepare', get_defined_vars());
    }

    public function view()
    {
        // $this->storeCompanySocials();

        $date_range = $this->service->get_date_range();
        $primary_categories = $this->service->get_primary_categories();
        $store = $this->service->get_current_company();
        $top_companies = $this->service->get_top_companies();
        $promotion_type_chart = $this->service->get_promotion_type_chart();
        // $test =0.50;
        $companiesData = $this->service->get_top_companies_data();

        return view('report::analysis.analysisPdf', get_defined_vars());
    }

    public function viewPost(Request $request)
    {
        executionTime();
        $this->storeCompanySocials($request);
        $date_range = $this->service->get_date_range();
        $primary_categories = $this->service->get_primary_categories();
        $store = $this->service->get_current_company();
        $top_companies = $this->service->get_top_companies();
        $promotion_type_chart = $this->service->get_promotion_type_chart();
        $companiesData = $this->service->get_top_companies_data();

        $max_discount = $this->service->get_max_discount_count();
        $min_discount = $this->service->get_min_discount_count();
        return view('report::analysis.analysisPdf', get_defined_vars());
    }

    private function storeCompanySocials($request)
    {
        if (!$request->company)return;

        foreach($request->company as $key => $companyData) {
            $company = Company::find($key);

            foreach($companyData as $key => $value) {
                $platform = Platform::find($key);

                $social = CompanySocial::where([
                    'platform_id' => $platform->id,
                    'company_id' => $company->id
                ])->first();

                if(! $social) {
                    CompanySocial::create([
                        'user_id' => auth()->id(),
                        'platform_id' => $platform->id,
                        'company_id' => $company->id,
                        'content' => $value
                    ]);
                }else {
                    $social->update([
                        'user_id' => auth()->id(),
                        'platform_id' => $platform->id,
                        'company_id' => $company->id,
                        'content' => $value
                    ]);
                }
            }
        }
    }

    public function download()
    {
        executionTime();
        $date_range = $this->service->get_date_range();
        $primary_categories = $this->service->get_primary_categories();
        $store = $this->service->get_current_company();
        $top_companies = $this->service->get_top_companies();
        $promotion_type_chart = $this->service->get_promotion_type_chart();


        $test = 0.50;
        $pdf = SnappyPdf::loadView('report::analysis.analysisPdf', get_defined_vars());
        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('no-stop-slow-scripts', true);
        // $pdf->setOption('page-size', 'A4');
        $pdf->setOption('lowquality', false);
        // $pdf->setOption('disable-smart-shrinking', true);
        $pdf->setOption('images', true);
        $pdf->setOption('window-status', 'ready');
        $pdf->setOption('run-script', 'window.setTimeout(function(){window.status="ready";},5000);');

        // (new GenerateAnalysisPdf($store, $this->service))->dispatch($store, $this->service);

        return $pdf->download(Str::slug($store->name_en) . '.pdf');
    }
}
