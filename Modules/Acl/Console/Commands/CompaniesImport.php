<?php

namespace Modules\Acl\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Acl\Export\CompaniesMissingExport;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CompaniesImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'import:companies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importing Companies.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(): int
    {
        executionTime();

        // Get all files in a directory
        $files = Storage::allFiles("missing/companies");
        Storage::delete($files);

        $companiesImport = new \Modules\Acl\Import\CompaniesImport;

        session()->put('companies', []);

        $content = Storage::get("companies_import.txt");

        Excel::import($companiesImport, $content);

        if(count(session()->get('companies'))){
            Excel::store(new CompaniesMissingExport(session()->get('companies')),
                'missing/companies/companies_with_missing_data.' . date('m-d-Y_hia') . '.xlsx'
            );
        }

        Storage::delete('companies_import.txt');

        // serialize your input array (say $array)
        $serializedData = serialize(session()->get('companies'));
        file_put_contents('missing_data_array_companies.txt', $serializedData);
        session()->forget('companies');
        Storage::delete('companies_import_in_progress.txt');
        return 1;
    }
}
