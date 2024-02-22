<?php

namespace App\Jobs;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Record\Export\ExportAdRecord;

class AddUserDownloads extends Command
{

    protected $name = 'export:record';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';
    protected $fileName;
    protected $userId;
    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $fileName,$id,$request)
    {
        parent::__construct();
        $this->fileName = $fileName;
        $this->userId = $id;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Auth::loginUsingId($this->userId);
        Excel::store(new ExportAdRecord($this->request),
            'public/' . $this->fileName
        );

        Session::put('download-link', 'public/' . $this->fileName);
    }
}
