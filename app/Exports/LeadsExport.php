<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class LeadsExport implements FromQuery
{
    use Exportable;

    public function __construct(int $year)
    {
        $this->year = $year;
    }

    public function query()
    {
        return Lead::whereYear('created_at', $this->year)->orderBy('created_at', 'ASC');
    }
}
