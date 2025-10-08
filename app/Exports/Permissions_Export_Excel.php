<?php

namespace App\Exports;

use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Permissions_Export_Excel implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $timestamp;

    public function __construct()
    {
        $this->timestamp = now()->format('Y-m-d_H-i-s');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Role',
            'Created At',   
            'Updated At'        
        ];
    }

    public function map($permission): array
    {
        $roles = $permission->roles->pluck('name')->map(function ($name) {
            return ucwords($name);
        })->implode(', ');

        return [
            $permission->id,
            $permission->name,
            $roles,
            $permission->created_at,
            $permission->updated_at,
        ];
    }


    public function collection()
    {
        return Permission::all();
    }

    public function title(): string
    {
        return 'Permission - ' . $this->timestamp;
    }
}
