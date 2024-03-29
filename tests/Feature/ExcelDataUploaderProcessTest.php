<?php

namespace Tests\Feature;

use App\src\Domain\ExcelDataUploads\Actions\Command\ImportExcelDataFromUploadedAction;
use App\src\Domain\ExcelDataUploads\Actions\Command\StoreExcelDataAction;
use App\src\Domain\ExcelDataUploads\Enums\ExcelDataUploadStatus;
use App\src\Domain\ExcelDataUploads\Jobs\ExcelDataUploadProcess;
use App\src\Domain\ExcelDataUploads\Models\ExcelDataUploaderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ExcelDataUploaderProcessTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */

    public function canAbleToProcessQueuedSpreadsheet()
    {
        $status = ExcelDataUploaderStatus::factory()->create([
            'file_path' => 'tests/Feature/Data/financial_sample.xlsx'
        ]);

        $data = Excel::toArray(
            new ImportExcelDataFromUploadedAction, $status->file_path
        );

        (new ExcelDataUploadProcess($status))->handle(new StoreExcelDataAction);

        $this->assertDatabaseHas('excel_data_uploader_status', [
            'id' => $status->id,
            'status' => ExcelDataUploadStatus::PROCESSED->key()
        ]);
        $this->assertDatabaseCount('financial_data_by_sectors', count($data[0]));

    }
}