<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\World\Models\City;
use Modules\Logistic\Models\LogisticZone;
class LogisticZoneExport implements FromCollection, WithHeadings
{
    public array $columns;

    public array $dateRange;

    public function __construct($columns, $dateRange)
    {
        $this->columns = $columns;
        $this->dateRange = $dateRange;
    }

    public function headings(): array
    {
        $modifiedHeadings = [];

        foreach ($this->columns as $column) {
            // Capitalize each word and replace underscores with spaces
            $modifiedHeadings[] = ucwords(str_replace('_', ' ', $column));
        }

        return $modifiedHeadings;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = LogisticZone::query();

        $query->whereDate('created_at', '>=', $this->dateRange[0]);

        $query->whereDate('created_at', '<=', $this->dateRange[1]);

        $query = $query->get();

        $newQuery = $query->map(function ($row) {
            $selectedData = [];

            foreach ($this->columns as $column) {
                switch ($column) {
                    case 'status':
                        $selectedData[$column] = 'inactive';
                        if ($row[$column]) {
                            $selectedData[$column] = 'active';
                        }
                        break;

                    case 'name':

                        $selectedData[$column] = $row->name;
                        break;

                    case 'city_id':
                        $cities = json_decode($row->cities, true);
                        $cityName = City::find($cities[0]['id'])->name ?? '-';
                        $selectedData[$column] = $cityName;
                        break;

                    case 'logistic_id':
                        $selectedData[$column] = $row->logistic->name ?? '-';
                        break;

                    default:
                        $selectedData[$column] = $row[$column];
                        break;
                }
            }

            return $selectedData;
        });

        return $newQuery;
    }
}
