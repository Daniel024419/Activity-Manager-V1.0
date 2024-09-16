<?php

namespace App\Exports;

use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class AdminExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Admin::all()->map(function ($user) {
                return [
                    'ID' => $user->id,
                    'Name' => $user->name,
                    'Email' => $user->email,
                    'Role' => $user->role->name,
                    'Created_at' => Carbon::parse($user->created_at)->format('d/m/Y H:i'),
                ];
           
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Role',
            'Created_at'
        ];
    }
}
