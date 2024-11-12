<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Certificate</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i%7CHeebo:300,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&#038;display=swap' type='text/css' media='all' />
    <style>
        /* Add CSS styles here */
        .custom-table {
            border-collapse: collapse;
            width: 100%;
        }

        .custom-table th,
        .custom-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .custom-table thead {
            background-color: #f0f0f0;
        }

        .text-capitalize {
            text-transform: capitalize;
        }

        .text-right {
            text-align: right;
        }

        .badge {
            font-size: 12px;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 10px;
        }

        .badge-success {
            background-color: #5cb85c;
            color: #fff;
        }

        .badge-danger {
            background-color: #d9534f;
            color: #fff;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .d-flex {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .btn {
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            border-radius: 4px;
        }

        .btn-sm {
            padding: 4px 8px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }

        .btn-primary {
            background-color: #337ab7;
            color: #fff;
            border-color: #2e6da4;
        }

        .text-info {
            color: #31708f;
        }

        .fs-4 {
            font-size: 1.25rem;
        }
        body {
            font-family: 'Noto Sans', sans-serif;
        }
    </style>
</head>

<body style="font-size: 16px; color: #000;">
    <b-row>
        <b-col sm="12">
            <div id="bill">
                @foreach($data as $info)

                <div class="row">
                    <div class="col-md-6">
                        <h2 class="mb-0">{{ $info['cliniccenter']['name'] ?? '--' }}</h2>
                        <h3 class="mb-0 font-weight-bold">{{ __('messages.invoice_id') }} <span class="text-primary">#{{ $info['id'] ?? '--' }}</span></h3>
                        @php
                        
                        $setting = App\Models\Setting::where('name', 'date_formate')->first();
                        $dateformate = $setting ? $setting->val : 'Y-m-d';
                        $setting = App\Models\Setting::where('name', 'time_formate')->first();
                        $timeformate = $setting ? $setting->val : 'h:i A';
                        $createdDate = isset($info['created_at']) ? date($dateformate, strtotime($info['created_at'] ?? '--' )) : '--';
                        @endphp
                        <h4 class="mb-0">
                            <span class="font-weight-bold"> {{ __('messages.created_at') }}: </span> {{ $createdDate }}
                        </h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <p class="mb-0">{{ $info['cliniccenter']['address'] ?? '--' }}</p>
                        <p class="mb-0">{{ $info['cliniccenter']['email'] ?? '--' }}</p>
                        <p class="mb-0 mt-2">
                            {{ __('messages.payment_status') }}
                            @if($info['appointmenttransaction']['payment_status'] == 1)
                            <span class="badge badge-success">{{ __('messages.paid') }}</span>
                            @else
                            <span class="badge badge-danger">{{ __('messages.unpaid') }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                <hr class="my-3" />
                <div class="row">
                    <div class="col-md-12">
                        <h3>{{ __('messages.patient_detail') }}</h3>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-sm custom-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('messages.patient_name') }}</th>
                                    <th>{{ __('messages.patient_gender') }}</th>
                                    <th>{{ __('messages.patient_dob') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-capitalize">
                                <tr>
                                    <td>{{ $info['user']['first_name'] .''.$info['user']['last_name'] ?? '--' }}</td>
                                    <td>{{ $info['user']['gender'] ?? '--' }}</td>
                                    @if($info['user']['date_of_birth'] !== null)
                                    <td>{{ date($dateformate, strtotime($info['user']['date_of_birth']))  ?? '--'  }}</td>
                                    @else
                                    <td>-</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr class="my-3" />
                @if($info['clinicservice'] !== null)
                <div class="row">
                    <div class="col-md-12">
                        <h3>{{ __('messages.service') }}</h3>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ __('messages.sr_no') }}</th>
                                        <th>{{ __('messages.item_name') }}</th>
                                        <th>{{ __('messages.price') }}</th>
                                        <th>{{ __('messages.total') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $index = 1 @endphp
                                    <tr>
                                        <td>{{ $index }}</td>
                                        <td>{{ $info['clinicservice']['name'] ?? '--' }}</td>
                                        <td>{{ Currency::format($info['service_price']) ?? '--' }}</td>
                                        <td>{{ Currency::format($info['service_price']) ?? '--' }}</td>
                                    </tr>
                                    @php $index++ @endphp
                                </tbody>
                                @if($info['clinicservice'] == null)
                                <tbody>
                                    <tr>
                                        <td colspan="6">
                                            <h4 class="text-primary mb-0">{{ __('messages.no_record_found') }}</h4>
                                        </td>
                                    </tr>
                                </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
                @endif
                <hr class="my-3" />
                @if($info['appointmenttransaction']['tax_percentage'] !== null)
                @php
                $tax = $info['appointmenttransaction']['tax_percentage'];
                $taxData = json_decode($tax, true);
                
                $total_amount = $info['service_price'] ?? 0;
                @endphp

                <div class="row">
                    <div class="col-md-12">
                        <h3>{{ __('report.lbl_tax_details') }}</h3>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th colspan="3">{{ __('messages.sr_no') }}</th>
                                       
                                        <th colspan="3">{{ __('messages.tax_name') }}</th>
                                        
                                        <th colspan="2">
                                            <div class="text-right">
                                                {{ __('messages.charges') }}
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                @php 
                                    $index = 1;
                                    $totalTax = 0;
                                @endphp
                                @foreach($taxData as $taxPercentage)
                                @php
                                $taxTitle = $taxPercentage['title'];
                                
                                @endphp
                                <tbody>
                                    <tr>
                                        <td colspan="3">{{ $index }}</td>

                                        <td colspan="3">
                                            @if($taxPercentage['type'] == 'fixed')
                                            {{ $taxTitle }} ({{ Currency::format($taxPercentage['value']) ?? '--' }})
                                            @else
                                            {{ $taxTitle }} ({{ $taxPercentage['value'] ?? '--' }}%)
                                            @endif
                                        </td>
                                       
                                        <td colspan="2" style="text-align: right;">
                                            @if($taxPercentage['type'] == 'fixed')
                                            @php
                                                $totalTax += $taxPercentage['value'];
                                            @endphp
                                            {{ Currency::format($taxPercentage['value']) ?? '--' }}
                                            @else
                                            @php
                                                $tax_amount = $info['service_amount'] * $taxPercentage['value'] / 100;
                                                $totalTax += $tax_amount;
                                            @endphp
                                            {{  Currency::format($tax_amount) ?? '--' }}
                                            @endif
                                        </td>
                                    </tr>
                                    @php $index++ @endphp
                                </tbody>
                                @endforeach
                                
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <h3>{{ __('report.lbl_taxes') }}</h3>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th colspan="3"> </th>
                                       
                                        <th colspan="3"> </th>
                                        
                                        <th colspan="2">
                                            <div class="text-right">
                                                {{ __('messages.charges') }}
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                
                                
                                @php
                                $amount_total = 0;

                                $discount_total = $info['appointmenttransaction']['discount_value'] ?? 0;
                                $discount_amount = $info['appointmenttransaction']['discount_amount'] ?? 0;
                            
                                $amount_due = $info['service_amount'] ?? 0;
                                @endphp

                                <tfoot>
                                    @foreach($taxData as $taxPercentage)
                                    @php
                                    $tax_amount = $info['service_amount']  * $taxPercentage['value'] / 100;
                                    $amount_total += $taxPercentage['type'] == 'fixed' ? $taxPercentage['value'] : $tax_amount;
                                    $amount_due =  $info['service_amount'] + $amount_total;
                                    @endphp
                                    @endforeach
                                    <!-- <tr>
                                        <th colspan="6" class="text-right">{{ __('messages.charges') }}</th>
                                        <th class="text-right">{{ Currency::format($amount_total) ?? '--' }}</th>
                                    </tr> -->

                                    <tr>
                                        <th colspan="6" class="text-right">{{ __('messages.total') }}</th>
                                        <th colspan="2" style="text-align: right;"><span>{{ Currency::format($total_amount) }}</span></th>
                                    </tr>

                                    <tr>
                                        <th colspan="6" class="text-right">{{ __('messages.total_tax') }}</th>
                                        <th colspan="2" style="text-align: right;"><span>{{ Currency::format($totalTax) }}</span></th>
                                    </tr>

                                    <tr>
                                        <th colspan="6" class="text-right">{{ __('messages.discount') }}     
                                       ( @if($info['appointmenttransaction']['discount_type'] === 'percentage')
                                    <span class="text-dark">{{ $discount_total ?? '--' }}%</span>
                                    @else
                                    <span class="text-dark">{{ Currency::format($discount_total) ?? '--' }}</span>
                                    @endif
                                  )

                                        
                                        </th>
                                        <th colspan="2" style="text-align: right;">{{ Currency::format($discount_amount) ?? '--' }}</th>
                                    </tr>

                                    <tr>
                                        <th colspan="6" class="text-right">{{ __('messages.grand_total') }}</th>
                                        <th colspan="2" style="text-align: right;">{{ Currency::format($amount_due) ?? '--' }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
        </b-col>
    </b-row>
</body>

</html>