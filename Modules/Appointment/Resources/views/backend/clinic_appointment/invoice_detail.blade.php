@extends('backend.layouts.app')

@section('title')
{{ __($module_title) }}
@endsection
@section('content')
<b-row>
    <b-col sm="12">
        <div id="bill">
        
            @foreach($data as $info)
            
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <p class="mb-0">{{ __('messages.invoice_id') }} :<span class="text-secondary"> #{{ $info['id'] ?? '--' }}</span></h3>
                                <p class="mb-0">
                                    {{ __('messages.payment_status') }}
                                    @if($info['appointmenttransaction']['payment_status'] == 1)
                                    <span class="text-capitalize badge bg-success-subtle p-2">{{ __('messages.paid') }}</span>
                                    @else
                                    <span class="text-capitalize badge bg-soft-danger p-2">{{ __('messages.unpaid') }}</span>
                                    @endif
                                </p>
                            </div>
                            @php
                                $setting = App\Models\Setting::where('name', 'date_formate')->first();
                                    $dateformate = $setting ? $setting->val : 'Y-m-d';
                                    $setting = App\Models\Setting::where('name', 'time_formate')->first();
                                    $timeformate = $setting ? $setting->val : 'h:i A';
                                    $createdDate = isset($info['created_at']) ? date($dateformate, strtotime($info['created_at'] ?? '--' )) : '--';
                                @endphp
                                <p class="mb-0 mt-1">
                                     {{ __('messages.created_at') }} : <span class="font-weight-bold text-dark"> {{ $createdDate }}</span>
                                </p>
                            
                        </div>
                    </div>                    
                </div>
            </div>

            <div class="row gy-3">
                <div class="col-md-6 col-lg-4">
                    <h5 class="mb-3">Clinic Info</h5>
                    <div class="card card-block card-stretch card-height mb-0">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-3">
                                <div class="image-block">
                                <img src="{{$info['cliniccenter']['file_url'] ?? '--'}}" class="img-fluid avatar avatar-50 rounded-circle" alt="image">
                                </div>
                                <div class="content-detail">
                                    <h5 class="mb-2">{{ $info['cliniccenter']['name'] ?? '--' }}</h5>
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <i class="ph ph-envelope"></i> 
                                        <u class="text-secondary">{{ $info['cliniccenter']['email'] ?? '--' }}</u>
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <i class="ph ph-map-pin"></i> 
                                        <span>{{ $info['cliniccenter']['address'] ?? '--' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <h5 class="mb-3">{{ __('messages.patient_detail') }}</h5>
                    <div class="card card-block card-stretch card-height mb-0">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-3">
                                <div class="image-block">
                                <img src="{{$info['user']['profile_image'] ?? '--'}}" class="img-fluid avatar avatar-50 rounded-circle" alt="image">
                                </div>
                                <div class="content-detail">
                                <h5 class="mb-2">{{ $info['user']['first_name'] .''.$info['user']['last_name'] ?? '--' }}</h5>
                                    <div class="d-flex flex-wrap align-items-center gap-3 mb-2">
                                    @if($info['user']['gender']!== null)
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="ph ph-user text-dark"></i>
                                            <span class="">{{ $info['user']['gender'] ?? '--' }}</span>
                                        </div>
                                        @endif
                                       @if($info['user']['date_of_birth'] !== null)
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="ph ph-cake text-dark"></i>
                                            <span class="">{{  date($dateformate, strtotime($info['user']['date_of_birth']))  ?? '--' }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <h5 class="mb-3">{{ __('messages.service') }}</h5>
                    <div class="card card-block card-stretch card-height mb-0">
                        <div class="card-body">
                            <div class="content-detail">
                                <div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
                                    <span>{{ __('messages.item_name') }}</span>
                                    <span class="text-dark">{{ $info['clinicservice']['name'] ?? '--' }}</span>
                                </div>
                                <div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
                                    <span>{{ __('messages.price') }}</span>
                                    <span class="text-dark">{{ Currency::format($info['service_price']) ?? '--' }}</span>
                                </div>
                                <!-- <div class="d-flex flex-wrap align-items-center justify-content-between">
                                    <span>{{ __('messages.total') }}</span>
                                    <span class="text-dark">{{ Currency::format($info['service_amount']) ?? '--' }}</span>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($info['appointmenttransaction']['tax_percentage'] !== null)
            @php
            $tax = $info['appointmenttransaction']['tax_percentage'];
            $taxData = json_decode($tax, true);
            
            $total_amount = $info['service_amount'] ?? 0;
            @endphp
            <div class="row gy-3 mt-4">
                <div class="col-sm-12">
                    <h5 class="mb-3">{{ __('report.lbl_taxes') }}</h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                                <span>{{ __('messages.total') }}</span>
                                <span class="text-dark">{{ Currency::format($info['service_price'] ?? 0) }}</span>
                            </div>
                        @foreach($taxData as $taxPercentage)
                            @php
                            $taxTitle = $taxPercentage['title'];
                            @endphp
                            <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                                <span>
                                    @if($taxPercentage['type'] == 'fixed')
                                        {{ $taxTitle }} ({{ Currency::format($taxPercentage['value']) ?? '--' }})
                                    @else
                                        {{ $taxTitle }} ({{ $taxPercentage['value'] ?? '--' }}%)
                                    @endif
                                </span>
                                <span class="text-dark">
                                    @if($taxPercentage['type'] == 'fixed')
                                        {{ Currency::format($taxPercentage['value']) ?? '--' }}
                                    @else
                                        <?php
                                            $tax_amount = $info['service_amount']  * $taxPercentage['value'] / 100;
                                        ?>
                                        {{  Currency::format($tax_amount) ?? '--' }}
                                    @endif
                                </span>
                            </div>
                            @endforeach
                            
                            @php
                            $amount_total = 0;
                            $discount_total = $info['appointmenttransaction']['discount_value'] ?? 0;
                            $discount_amount = $info['appointmenttransaction']['discount_amount'] ?? 0;
                            $amount_due = $total_amount ?? 0;
                            @endphp
                            @foreach($taxData as $taxPercentage)
                                @php
                                $tax_amount = $info['service_amount']  * $taxPercentage['value'] / 100;
                                $amount_total += $taxPercentage['type'] == 'fixed' ? $taxPercentage['value'] : $tax_amount;
                                $amount_due = $total_amount + $amount_total;
                                @endphp
                                @endforeach
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <span>{{ __('messages.discount') }}(
                                     @if($info['appointmenttransaction']['discount_type'] === 'percentage')
                                    <span class="text-dark">{{ $discount_total ?? '--' }}%</span>
                                    @else
                                    <span class="text-dark">{{ Currency::format($discount_total) ?? '--' }}</span>
                                    @endif
                                  )

                              

                               </span>

                               <span class="text-dark">{{ Currency::format($discount_amount) ?? '--' }}</span>
                                
                            </div>
                            
                            <hr class="border-top border-gray">
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <span class="text-dark">{{ __('messages.grand_total') }}</span>
                                <span class="text-secondary">{{ Currency::format($amount_due) ?? '--' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endif

            <div class="d-flex justify-content-end align-items-center ">
                <a class="btn btn-primary" href="{{ route('backend.appointments.download_invoice', ['id' => $info['id']]) }}">
                    <i class="fa-solid fa-download"></i>
                    {{__('appointment.lbl_download')}}
                </a>
            </div>




         

           
            <hr class="my-3" />
            
           
            <!-- <div class="d-flex justify-content-end align-items-center">
                <a href="{{ route('backend.appointments.download_invoice', ['id' => $info['id']]) }}" class="btn text-info p-0 fs-4" data-bs-toggle="tooltip" title="{{ __('clinic.invoice_detail') }}"><i class="ph ph-file-pdf"></i></a>
            </div> -->
            @endforeach
        </div>

    </b-col>
</b-row>
@endsection

@push('after-styles')
<style>
    .detail-box {
        padding: 0.625rem 0.813rem;
    }
</style>
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
<script src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>
<script src="{{ mix('modules/appointment/script.js') }}"></script>
<script src="{{ asset('js/form-offcanvas/index.js') }}" defer></script>
@endpush