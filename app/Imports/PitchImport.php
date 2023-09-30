<?php

namespace App\Imports;


use App\Models\Pitch;
use App\Enums\StatusPitchEnum;
use Maatwebsite\Excel\Concerns\ToArray;
use App\Http\Controllers\Trait\ResponseTrait;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PitchImport implements ToArray, WithHeadingRow
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
                $pitch = Pitch::firstOrCreate([
                    'pitch_area_id' => $this->pitchAreaId,
                    'name' => $each['ten_san'],
                ], [
                    'type' => $each['loai'],
                    'status' => StatusPitchEnum::ACTIVE,
                ]);
            } catch (\Throwable $e) {
                dd($e);
            }
        }
    }
}
