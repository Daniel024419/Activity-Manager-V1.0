<?php

namespace App\Exports;

use App\Models\Activity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ActivityUpdatesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Activity::with('updates.user')->get()->flatMap(function ($activity) {
            return $activity->updates->map(function ($update) use ($activity) {
                return [
                    'ID' => $update->id,
                    'Activity Description' => $activity->description,
                    'Status' => $update->status,
                    'Remark' => $update->remark,
                    'Personnel' => $update->user->name,
                    'Time' => $update->manual_updated_at->format('d/m/Y H:i'),
                ];
            });
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Activity Description',
            'Status',
            'Remark',
            'Personnel',
            'Time',
        ];
    }
}
