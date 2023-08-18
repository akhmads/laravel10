<?php

namespace App\Imports;

use App\Models\Jadwal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class JadwalImport implements ToModel,WithStartRow,WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Jadwal([
            'tapel_code' => $row[0],
            'kelas_code' => $row[2],
            'matpel_code' => $row[3],
            'guru_code' => $row[5],
            'ruangan_code' => $row[7],
            'hari' => $row[9],
            'jam_awal' => $row[11],
            'jam_akhir' => $row[12],
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
