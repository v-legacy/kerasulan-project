<?php

namespace App\Imports;

use App\Models\DataTraining;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataTrainingImport implements ToModel, WithHeadingRow
{
    /**
     * @param Model $model
     */
    public function model(array $row)
    {
        return new DataTraining([
            'nama' => $row['nama'],
            'pecah_suara' => $row['pecah_suara'],
            'audio_video' => $row['audio_video'],
            'bidang' => $row['bidang'],

        ]);
    }
}
