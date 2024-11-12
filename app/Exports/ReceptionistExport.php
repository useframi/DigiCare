<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Clinic\Models\Receptionist;

class ReceptionistExport implements FromCollection, WithHeadings
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
        $query = User::role('receptionist')->setRoleReceptionist(auth()->user())->with('receptionist');
        $userId = auth()->id();
    
        $query->whereDate('users.created_at', '>=', $this->dateRange[0]);

        $query->whereDate('users.created_at', '<=', $this->dateRange[1]);

        $query->orderBy('users.updated_at', 'desc');

        $query = $query->get();

        $newQuery = $query->map(function ($row) {
            $selectedData = [];

            foreach ($this->columns as $column) {
                switch ($column) {
                    case 'Name':
                        $selectedData[$column] = $row->first_name . ' ' . $row->last_name;
                        break;

                    case 'mobile':
                        $selectedData[$column]= $row->mobile;
                        break;
                        
                    case 'varification_status':
                        $selectedData[$column] = __('customer.msg_unverified');
                        if ($row['email_verified_at']) {
                            $selectedData[$column] = __('customer.msg_verified');
                        }
                        break;

                  
                    case 'Clinic Center':
                        $clinics = optional(optional($row->receptionist)->clinics)->name;
                        $selectedData[$column]= $clinics;
                        break;

                    case 'status':
                        $selectedData[$column] = 'no';
                        if ($row[$column]) {
                            $selectedData[$column] = 'yes';
                        }
                        break;

                    case 'service_providers':
                        $selectedData[$column] = implode(', ', optional($row->mainServiceProvider)->pluck('name')->toArray()) ?? '-';
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
