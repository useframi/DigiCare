<?php

namespace Modules\Appointment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Modules\Appointment\Trait\AppointmentTrait;

class BillingRecordDetailsResource extends JsonResource
{
    use AppointmentTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    { 
        $tax_data = $this->calculateTaxAmounts($this->tax_data ? $this->tax_data: null, ($this->service_amount));
        $total_tax = array_sum(array_column($tax_data, 'amount'));
        return [
            'id'=> $this->id,
            'encounter_id'=> $this->encounter_id,
            'user_id'=> $this->user_id,
            'user_name'=>optional($this->user)->first_name .' '.optional($this->user)->last_name,
            'user_address'=>optional($this->user)->address,
            'user_gender'=>optional($this->user)->gender,
            'user_dob'=>optional($this->user)->date_of_birth,
            'clinic_id'=> $this->clinic_id,  
            'clinic_name'=>optional($this->clinic)->name,
            'clinic_email'=>optional($this->clinic)->email,
            'clinic_address'=>optional($this->clinic)->address,
            'doctor_id'=> $this->doctor_id,
            'doctor_name'=>optional($this->doctor)->first_name .' '.optional($this->doctor)->last_name,
            'service_id'=> $this->service_id,
            'service_name'=> optional($this->clinicservice)->name,
            'service_amount'=> $this->service_amount,
            'total_amount'=> $this->total_amount,
            'discount_amount'=> $this->discount_amount,
            'discount_type'=> $this->discount_type,
            'discount_value'=> $this->discount_value,
            'tax_data'=> json_decode($this->tax_data),
            'total_tax' => $total_tax,
            'date'=> $this->date,
            'payment_status'=> $this->payment_status,
            'created_by'=> $this->created_by,
            'updated_by'=> $this->updated_by,
            'deleted_by'=> $this->deleted_by,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
            'deleted_at'=> $this->deleted_at
        ];
    }
}
