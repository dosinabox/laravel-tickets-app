<?php

namespace App\Exports;

use App\Models\Visitor;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VisitorsExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    public function collection(): Collection
    {
        return Visitor::all();
    }

    public function headings(): array
    {
        return [
            'name',
            'lastname',
            'phone',
            'email',
            'telegram',
            'category',
            'company',
            'position',
            'code',
            'id',
            'createdAt',
            'status',
            'isRejected',
        ];
    }

    public function map($row): array
    {
        return [
            $row->getName(),
            $row->getLastName(),
            $row->getPhone(),
            $row->getEmail(),
            $row->getTelegram(),
            $row->getCategory(),
            $row->getCompany(),
            $row->getPosition(),
            $row->getCode(),
            $row->getID(),
            $row->getCreatedAt(),
            $row->getStatus(),
            $row->isRejected(),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => '+#',
        ];
    }
}
