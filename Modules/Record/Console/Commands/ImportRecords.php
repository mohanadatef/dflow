<?php

namespace Modules\Record\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Record\Export\MissingAdRecordsExport;
use Modules\Record\Import\AdRecordImport;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ImportRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'import:record';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
        $files = Storage::allFiles("missing/records");
        Storage::delete($files);

        $adRecordImport = new AdRecordImport;

        session()->put('rows', []);

        $content = Storage::get("records_import.txt");

        Excel::queueImport($adRecordImport, $content);

        if(count(session()->get('rows'))){
            Excel::store(new MissingAdRecordsExport(session()->get('rows')),
                'missing/records/missing_ad_records_data.' . date('m-d-Y_hia') . '.xlsx'
            );
        }

        Storage::delete('records_import.txt');

        // serialize your input array (say $array)
        $serializedData = serialize(session()->get('rows'));
        file_put_contents('missing_data_array_ad_record.txt', $serializedData);
        session()->forget('rows');
        Storage::delete('ad_record_import_in_progress.txt');

        return 1;
    }
}
