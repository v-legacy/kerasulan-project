<?php

namespace App\Imports;

use App\Models\Recruitment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RecruitmentImport implements ToModel, WithHeadingRow
{
    /**
     * @param Model $model
     */
    public function model(array $row)
    {
        return new Recruitment([
            'nama' => $row['nama'],
            'pecah_suara' => $row['pecah_suara'],
            'audio_video' => $row['audio_video'],
            'bidang' => $row['bidang'],
        ]);
    }
}
