<?php

namespace App\Imports;

use App\Models\Time;
use Maatwebsite\Excel\Concerns\ToArray;
use App\Http\Controllers\Trait\ResponseTrait;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TimeImport implements ToArray, WithHeadingRow
{
    private $pitchAreaId;

    use ResponseTrait;

    public function __construct($pitchAreaId)
    {
        $this->pitchAreaId = $pitchAreaId;
    }

    public function array(array $array): void
    {
        foreach ($array as $each) {
            try {
                $time = Time::firstOrCreate(
                    [
                        'pitch_area_id' => $this->pitchAreaId,
                        'type' => $each['the_loai'],
                        'timeslot' => $each['gio'],
                        'cost' => $each['gia']
                    ],
                    [
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );
            } catch (\Throwable $e) {
                dd($e);
            }
        }
    }
}
