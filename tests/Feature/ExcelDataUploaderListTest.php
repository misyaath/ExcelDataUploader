<?php

namespace Tests\Feature;

use App\src\Domain\ExcelDataUploads\Models\ExcelDataUploaderStatus;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExcelDataUploaderListTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */

    public function canGetListOfUploadedExcelList()
    {
        ExcelDataUploaderStatus::factory()->count(50)->create([
            'file_path' => $this->faker->filePath()
        ]);

        $this->json('get', '/api/v1/upload')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'uuid',
                        'file_path',
                        'status',
                        'created_at',
                        'updated_at'
                    ]
                ],
                'links',
                'meta',
            ]);
    }
}