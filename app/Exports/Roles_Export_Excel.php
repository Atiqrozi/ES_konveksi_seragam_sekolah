<?php

namespace App\Exports;

use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Roles_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Permission',
            'Created At',   
            'Updated At'        
        ];
    }

    public function map($role): array
    {
        $permissions = $role->permissions->pluck('name')->map(function ($name) {
            return ucwords($name);
        })->implode(', ');

        return [
            $role->id,
            $role->name,
            $permissions,
            $role->created_at,
            $role->updated_at,
        ];
    }


    public function collection()
    {
        return Role::all();
    }

    public function title(): string
    {
        return 'Role - ' . $this->timestamp;
    }
}
