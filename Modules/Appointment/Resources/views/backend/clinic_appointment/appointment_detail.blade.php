@extends('backend.layouts.app')

@section('title')
{{ __($module_title) }}
@endsection
@section('content')
<div class="row">
    <x-backend.section-header>
        <x-slot name="toolbar">
            <div class="d-flex justify-content-end">
                <a href="{{ route('backend.appointments.index') }}" class="btn btn-primary" data-type="ajax" data-bs-toggle="tooltip">
                     {{ __('appointment.back') }}
                </a>
            </div>
            @php 
                $id = $appointment ? $appointment->id : 0; 
                $status = $appointment ? $appointment->status : null; 
                $pay_status = $appointment ? optional($appointment->appointmenttransaction)->payment_status : 0;
            @endphp
            @if($pay_status == 1 && $status == 'checkout')
            <div class="d-flex justify-content-end align-items-center ">
                
                            <a class="btn btn-primary" href="{{ route('backend.appointments.download_invoice', ['id' => $appointment->id]) }}">
                                <i class="fa-solid fa-download"></i>
                                {{__('appointment.lbl_download')}}
                            </a>
                        </div>
                        @endif
        </x-slot>
    </x-backend.section-header>
    <div class="col-lg-12">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="col-md-3">
                        <span class="d-block mb-1">{{ __('appointment.lbl_patient_name') }}</span>
                        <div class="d-flex gap-3 align-items-center">
                        
                            <img src="{{optional($appointment->user)->profile_image ?? default_user_avatar() }}" alt="avatar" class="avatar avatar-70 rounded-pill">
                            <div class="text-start">
                                <h5 class="m-0">{{optional($appointment->user)->full_name ?? default_user_name() }}</h5>
                                <span>{{optional($appointment->user)->email ?? '--' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div>
                            <span class="d-block mb-2">{{ __('clinic.lbl_clinic_name') }}</span>
                            <h6 class="m-0"> <img src="{{ optional($appointment->cliniccenter)->file_url ?? 'default_file_url()' }}" alt="avatar" class="avatar avatar-30 rounded-pill me-2"> {{$appointment->cliniccenter ? optional($appointment->cliniccenter)->name : '--' }} </h6>
                        </div>

                        <div>
                            <span class="d-block mb-2">{{ __('appointment.lbl_status') }}</span>
                            <h6 class="m-0">{{ ucwords(str_replace('_', ' ', $appointment->status ?? '--' )) }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <div class="row gy-3 mb-5">
                    <div class="col-md-3">
                        <span class="d-block mb-1">{{ __('appointment.lbl_appointment_date') }}</span>
                        <h6 class="m-0">{{ date($dateformate, strtotime($appointment->appointment_date ?? '--' )) }}</h6>
                    </div>
                    <div class="col-md-3">
                        <span class="d-block mb-1">{{ __('appointment.lbl_appointment_time') }}</span>
                        <h6 class="m-0">At {{ date($timeformate, strtotime($appointment->appointment_time ?? '--' )) }}</h6>
                    </div>
                    <div class="col-md-3">
                        <span class="d-block mb-1">{{ __('appointment.lbl_doctor') }} {{ __('appointment.lbl_name') }}</span>

                        @if($appointment->doctor === Null)
                        <h6 class="m-0">--</h6>
                        @else
                        <div class="d-flex gap-3 align-items-center">
                            <img src="{{optional($appointment->doctor)->profile_image ?? default_user_avatar() }}" alt="avatar" class="avatar avatar-50 rounded-pill">
                            <div class="text-start">
                                <h6 class="m-0">{{optional($appointment->doctor)->first_name.' '.optional($appointment->doctor)->last_name }} </h6>
                                <span>{{optional($appointment->doctor)->email ?? '--' }}</span>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
                <div class="border-top"></div>
                <div class="row gy-3 pt-5">
                    <div class="col-md-3">
                        <span class="d-block mb-1">{{ __('appointment.lbl_payment_status') }}</span>
                        @if(isset($appointment->appointmenttransaction->payment_status))
                        @if($appointment->appointmenttransaction->payment_status == 0)
                        <h6 class="m-0 mb-2 text-secondary">{{__('appointment.pending')}}</h6>
                        @else
                        <h6 class="m-0 mb-2 text-success">{{__('appointment.paid')}}</h6>

                        <span class="d-block mb-1">{{ __('appointment.lbl_payment_method') }}</span>

                        <h6 class="m-0  mb-2">Paid with {{ ucfirst(optional($appointment->appointmenttransaction)->transaction_type) }}</h6>

                        @endif
                        @else
                        <h6 class="m-0">--</h6>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <span class="d-block mb-1">{{ __('appointment.lbl_contact_number') }}</span>
                        <h6 class="m-0">{{optional($appointment->user)->mobile ?? '--' }}</h6>
                    </div>
                    <div class="col-md-3">
                        <span class="d-block mb-1">{{ __('appointment.lbl_duration') }}</span>
                        <h6 class="m-0">{{$appointment->duration ?? '--' }} min</h6>
                    </div>

                    @if($appointment->media->isNotEmpty())
                        <div class="col-md-3">
                            <span class="d-block mb-1">{{ __('appointment.lbl_medical_report') }}</span>
                            <ul>
                                @foreach($appointment->media as $media)
                                    <li>
                                        <a href="{{ asset($media->getUrl()) }}" download>
                                            {{ $media->file_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($appointment->appointment_extra_info !='')
    <div class="col-md-3">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <div class="flex-column">
                    <h5>{{ __('appointment.lbl_addition_information') }}</h5>
                    <span class="m-0">{{$appointment->appointment_extra_info }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-9">
                <div class="card card-block card-stretch card-height">
                    <div class=" card-header">
                        <h5 class="card-title mb-0">{{__('appointment.price')}} {{__('appointment.detail')}} </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center bg-body p-4 rounded">
                            <div class="detail-box bg-white rounded">
                                <img src="{{optional($appointment->clinicservice)->file_url ?? default_file_url() }}" alt="avatar" class="avatar avatar-80 rounded-pill">
                            </div>

                            <div class="ms-3 w-100 row">
                                <div class="col-md-9">
                                    <div class="d-flex align-items-center">
                                        <span>
                                            <b>{{ optional($appointment->clinicservice)->name }}</b> 
                                            {{ optional($appointment->clinicservice)->description ?? ' ' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex justify-content-end">
                                    <h5 class="mb-0">{{ Currency::format($appointment->service_price) }}</h5>
                                </div>
                            </div>
                        </div>
                        <ul class="list-unstyled pt-4 mb-0">
                            <?php
                            $transaction = $appointment->appointmenttransaction ? $appointment->appointmenttransaction : null;
                            if ($transaction != null) {

                                $tax = json_decode(optional($transaction)->tax_percentage, true);
                               
                                
                            }
                            ?>
                            @if($transaction !== null)
                            @foreach($tax as $t)
                            @if($t['type'] == 'percent')
                            <li class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom">
                                <span>{{$t['title']}} ({{$t['value']}}%)</span>
                                <?php
                                $tax_amount = $appointment->service_amount * $t['value'] / 100;
                                ?>
                                <span class="text-primary">{{Currency::format($tax_amount)}}</span>
                            </li>
                            @elseif($t['type'] == 'fixed')
                            <li class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom">
                                <span>{{$t['title']}}</span>
                                <span class="text-primary">{{ Currency::format($t['value']) }}</span>
                            </li>
                            @endif
                            @endforeach
                            
                            <li class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom">
                                <span>{{__('messages.discount')}}
                               ( <span class="text-primary">@if($transaction->discount_type === 'percentage')
                                    {{ $transaction->discount_value ?? '--' }}%
                                    @else
                                    {{ Currency::format($transaction->discount_value) ?? '--' }}
                                    @endif</span>)
                                    </span>
                                    <span class="text-dark">{{ Currency::format($transaction->discount_amount) ?? '--' }}</span>
                            </li>
                            @endif
                           
                           
                            <li class="d-flex align-items-center justify-content-between pt-3">
                                <h5 class="mb-0">{{__('appointment.total')}}</h5>
                                <h5 class="mb-0">{{ Currency::format($appointment->total_amount) }}</h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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