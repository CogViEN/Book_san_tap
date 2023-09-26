<?php

namespace App\Imports;


use App\Models\Time;
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
                $arrName = explode(',', $each['ten_san']);
                foreach ($arrName as $name) {
                    $type = $each['the_loai'];
                    $status = StatusPitchEnum::ACTIVE;

                    $pitch = Pitch::firstOrCreate([
                        'pitch_area_id' => $this->pitchAreaId,
                        'name' => $name,
                    ], [
                        'type' => $type,
                        'status' => $status,
                    ]);

                    Time::create([
                        'pitch_id' => $pitch->id,
                        'timeslot' => $each['gio'],
                        'cost' => $each['gia'],
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ]);
                }
            } catch (\Throwable $e) {
                dd($e);
            }
        }
    }
}
