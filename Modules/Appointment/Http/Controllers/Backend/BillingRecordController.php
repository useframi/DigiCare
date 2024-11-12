<?php

namespace Modules\Appointment\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\CustomField\Models\CustomField;
use Modules\CustomField\Models\CustomFieldGroup;
use Yajra\DataTables\DataTables;
use Modules\Appointment\Models\BillingRecord;
use Modules\Appointment\Models\PatientEncounter;
use Modules\Appointment\Models\AppointmentTransaction;
use Modules\Appointment\Models\Appointment;
use Carbon\Carbon;
use Modules\Clinic\Models\ClinicsService;
use Modules\Commission\Models\CommissionEarning;
use Modules\Appointment\Trait\AppointmentTrait;
use App\Models\Setting;

class BillingRecordController extends Controller
{
    use AppointmentTrait;
    protected string $exportClass = '\App\Exports\BillingExport';
    public function __construct()
    {
        // Page Title
        $this->module_title = 'appointment.billing_record';
        // module name
        $this->module_name = 'billing-record';

        // module icon
        $this->module_icon = 'fa-solid fa-clipboard-list';

        view()->share([
            'module_title' => $this->module_title,
            'module_icon' => $this->module_icon,
            'module_name' => $this->module_name,
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = [
            'payment_status' => $request->payment_status,
        ];

        $module_action = 'List';
        $columns = CustomFieldGroup::columnJsonValues(new BillingRecord());
        $customefield = CustomField::exportCustomFields(new BillingRecord());
        $service = ClinicsService::SetRole(auth()->user())->with( 'sub_category','doctor_service','ClinicServiceMapping','systemservice')->where('status', 1)->get();

        $export_import = true;
        $export_columns = [
            [
                'value' => 'encounter_id',
                'text' => __('appointment.lbl_encounter_id'),
            ],
            [
                'value' => 'user_id',
                'text' =>  __('appointment.lbl_patient_name'),
            ],
            [
                'value' => 'clinic_id',
                'text' => __('appointment.lbl_clinic'),
            ],
            [
                'value' => 'doctor_id',
                'text' => __('appointment.lbl_doctor'),
            ],
            [
                'value' => 'service_id',
                'text' => __('appointment.lbl_service'),
            ],
            [
                'value' => 'total_amount',
                'text' =>  __('appointment.lbl_total_amount'),
            ],
            [
                'value' => 'date',
                'text' => __('appointment.lbl_date'),
            ],
            [
                'value' => 'payment_status',
                'text' => __('appointment.lbl_payment_status'),
            ],

        ];
        $export_url = route('backend.billing-record.export');

        return view('appointment::backend.billing_record.index_datatable', compact('service','module_action', 'filter', 'columns', 'customefield', 'export_import', 'export_columns', 'export_url'));
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);

        $actionType = $request->action_type;

        $message = __('messages.bulk_update');

        switch ($actionType) {
            case 'change-status':
                $clinic = BillingRecord::whereIn('id', $ids)->update(['status' => $request->status]);
                $message = __('clinic.clinic_status');
                break;

            case 'delete':
                if (env('IS_DEMO')) {
                    return response()->json(['message' => __('messages.permission_denied'), 'status' => false], 200);
                }
                BillingRecord::whereIn('id', $ids)->delete();
                $message = __('clinic.clinic_delete');
                break;

            default:
                return response()->json(['status' => false, 'message' => __('service_providers.invalid_action')]);
                break;
        }

        return response()->json(['status' => true, 'message' => $message]);
    }
    public function index_data(Datatables $datatable, Request $request)
    {
        $query = BillingRecord::SetRole(auth()->user());
        
        $filter = $request->filter;

        if(isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('payment_status', $filter['column_status']);
            }
        }


        if (isset($filter)) {
            if (isset($filter['doctor_name'])) {
                $query->where('doctor_id', $filter['doctor_name']);
            }
            if (isset($filter['patient_name'])) {
                $query->where("user_id", $filter['patient_name']);
            }
            if (isset($filter['clinic_name'])) {
                $query->where("clinic_id", $filter['clinic_name']);
            }
            if (isset($filter['service_name'])) {
                $query->where('service_id', $filter['service_name']);
            }
        }
       

        $datatable = $datatable->eloquent($query)
            ->addColumn('check', function ($data) {
                return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-' . $data->id . '"  name="datatable_ids[]" value="' . $data->id . '" onclick="dataTableRowCheck(' . $data->id . ')">';
            })
            ->addColumn('action', function ($data) {
                return view('appointment::backend.billing_record.action_column', compact('data'));
            })

            ->editColumn('clinic_id', function ($data)  {
                return view('appointment::backend.patient_encounter.clinic_id', compact('data'));
            })

            ->editColumn('user_id', function ($data) {
                return view('appointment::backend.clinic_appointment.user_id', compact('data'));
            })

            ->editColumn('date', function ($data) {
                return date('y-m-d', strtotime($data->date));
            }) 

            ->editColumn('doctor_id', function ($data) {
                return view('appointment::backend.clinic_appointment.doctor_id', compact('data'));
            })

            ->editColumn('payment_status', function ($data) {

                return view('appointment::backend.billing_record.verify_action', compact('data'));
            })


            ->editColumn('service_id', function ($data) {
                if ($data->clinicservice) {
                    return optional($data->clinicservice)->name;
                } else {
                    return '-';
                }
            })

            ->editColumn('total_amount', function ($data) {
                return '<span>' . \Currency::format($data->total_amount) . '</span>';
            })


            ->filterColumn('doctor_id', function ($query, $keyword) {
                if (!empty($keyword)) {
                    $query->whereHas('user', function ($query) use ($keyword) {
                        $query->where('first_name', 'like', '%' . $keyword . '%')
                            ->orWhere('last_name', 'like', '%' . $keyword . '%')
                            ->orWhere('email', 'like', '%' . $keyword . '%');
                    });
                }
            })


            ->filterColumn('user_id', function ($query, $keyword) {
                if (!empty($keyword)) {
                    $query->whereHas('user', function ($query) use ($keyword) {
                        $query->where('first_name', 'like', '%' . $keyword . '%')
                            ->orWhere('last_name', 'like', '%' . $keyword . '%')
                            ->orWhere('email', 'like', '%' . $keyword . '%');
                    });
                }
            })

            ->filterColumn('clinic_id', function ($query, $keyword) {
                if (!empty($keyword)) {
                    $query->whereHas('clinic', function ($query) use ($keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%')
                              ->orWhere('email', 'like', '%' . $keyword . '%');
                    });
                }
            })

            ->editColumn('updated_at', function ($data) {
                $module_name = $this->module_name;

                $diff = Carbon::now()->diffInHours($data->updated_at);

                if ($diff < 25) {
                    return $data->updated_at->diffForHumans();
                } else {
                    return $data->updated_at->isoFormat('llll');
                }
            })
            ->orderColumns(['id'], '-:column $1');
            
        // Custom Fields For export
        $customFieldColumns = CustomField::customFieldData($datatable, BillingRecord::CUSTOM_FIELD_MODEL, null);

        return $datatable->rawColumns(array_merge(['action', 'payment_status', 'check', 'total_amount'], $customFieldColumns))
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('appointment::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('appointment::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data=BillingRecord::where('id',$id)->first();

       return response()->json(['data' => $data, 'status' => true]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function saveBillingDetails(Request $request){

        $data = $request->all();

        $encounter_details = PatientEncounter::where('id', $data['encounter_id'])->with('appointment')->first();
        
        $service_price_data = $data['service_details']['service_price_data'] ?? null;

        $tax_data = isset($data['service_details']['tax_data']) ? json_encode($data['service_details']['tax_data'], true) : null;

        $date = isset($data['date']) ? date('Y-m-d', strtotime($data['date'])) : (isset($encounter_details['encounter_date']) ? date('Y-m-d', strtotime($encounter_details['encounter_date'])) : null);
    
        $biling_details = [
            'encounter_id' => $data['encounter_id'],
            'user_id' => $data['user_id'],
            'clinic_id' => $encounter_details['clinic_id'],
            'doctor_id' => $encounter_details['doctor_id'],
            'service_id' => $data['service_id'],
            'total_amount' => $service_price_data['total_amount'] ?? 0,
            'service_amount' => $service_price_data['service_price'] ?? 0,
            'discount_amount' => $service_price_data['discount_amount'] ?? 0,
            'discount_type' => $service_price_data['discount_type'] ?? null,
            'discount_value' => $service_price_data['discount_value'] ?? null,
            'tax_data' => $tax_data, 
            'date' => $date,
            'payment_status' => $data['payment_status']
        ];
        
        $billing_data = BillingRecord::updateOrCreate(
            ['encounter_id' => $data['encounter_id']],
            $biling_details
        );


        if($encounter_details['appointment_id'] !=null && $data['payment_status'] == 1){

            AppointmentTransaction::where('appointment_id',$encounter_details['appointment_id'])->update(['payment_status'=>$data['payment_status']]);

            CommissionEarning::where('commissionable_id', $encounter_details['appointment_id'])->update(['commission_status' => 'unpaid']);
    
        }

        if($request->has('encounter_status') && $request->encounter_status==0 &&  $data['payment_status'] == 1){

            PatientEncounter::where('id',$data['encounter_id'])->update(['status'=> $request->encounter_status]);

            if($encounter_details['appointment_id'] !=null  &&  $data['payment_status'] == 1 ){

                $appointment=Appointment::where('id',$encounter_details['appointment_id'])->first();

                if ($appointment && $appointment->status == 'check_in') {
        
                    $appointment->update(['status' => 'checkout']);
                    $startDate = Carbon::parse($appointment['start_date_time']);
                    $notification_data = [
                        'id' => $appointment->id,
                        'description' => $appointment->description,
                        'appointment_duration' => $appointment->duration,
                        'user_id' => $appointment->user_id,
                        'user_name' => optional($appointment->user)->first_name ?? default_user_name(),
                        'doctor_id' => $appointment->doctor_id,
                        'doctor_name' => optional($appointment->doctor)->first_name,
                        'appointment_date' => $startDate->format('d/m/Y'),
                        'appointment_time' => $startDate->format('h:i A'),
                        'appointment_services_names' => ClinicsService::with('systemservice')->find($appointment->service_id)->systemservice->name ?? '--',
                        'appointment_services_image' => optional($appointment->clinicservice)->file_url,
                        'appointment_date_and_time' => $startDate->format('Y-m-d H:i'),
                        'latitude' =>  null,
                        'longitude' => null,
                    ];
                    $this->sendNotificationOnBookingUpdate('checkout_appointment', $notification_data);
                }
            }

        }

        $message = __('clinic.save_biiling_form');

        if ($request->is('api/*')) {
            return response()->json(['message' => $message, 'data' => $data, 'status' => true], 200);
        } else {
            return response()->json(['message' => $message, 'status' => true], 200);
        }

    }
    public function billing_detail(Request $request)
    {
        $id = $request->id;
        $module_action = 'Billing Detail';
        $appointments = BillingRecord::with('user', 'doctor', 'clinicservice', 'clinic')
            ->where('id', $id)
            ->first();
            $billing = $appointments;
        $timezone = Setting::where('name', 'default_time_zone')->value('val') ?? 'UTC';
        $setting = Setting::where('name', 'date_formate')->first();
        $dateformate = $setting ? $setting->val : 'Y-m-d';
        $setting = Setting::where('name', 'time_formate')->first();
        $timeformate = $setting ? $setting->val : 'h:i A';
        $combinedFormat = $dateformate . ' ' . $timeformate;
        return view('appointment::backend.billing_record.billing_detail', compact('module_action', 'billing','dateformate','timeformate','timezone','combinedFormat'));
    }

    public function EditBillingDetails(Request $request){

        $encounter_id=$request->encounter_id;

        $data=[];

        $encounter_details = PatientEncounter::where('id',$encounter_id)->with('appointmentdetail','billingrecord')->first();

        if($encounter_details->appointmentdetail){

            $data['service_id']= optional($encounter_details->appointmentdetail)->service_id ?? null;
            $data['payment_status']= optional($encounter_details->appointmentdetail)->appointmenttransaction->payment_status ?? 0;

        }else{

            $data['service_id']= optional($encounter_details->billingrecord)->service_id ?? null;
            $data['payment_status']= optional($encounter_details->billingrecord)->payment_status ?? 0;

        }

        return response()->json(['data' => $data, 'status' => true]);

    }

    public function encounter_billing_detail(Request $request)
    {
     
        $encouter_id = $request->id;

        $module_action = 'Billing Detail';
        $appointments = BillingRecord::with('user', 'doctor', 'clinicservice', 'clinic')
            ->where('encounter_id', $encouter_id)
            ->first();
        $billing = $appointments;
        $setting = Setting::where('name', 'date_formate')->first();
        $dateformate = $setting ? $setting->val : 'Y-m-d';
        $setting = Setting::where('name', 'time_formate')->first();
        $timeformate = $setting ? $setting->val : 'h:i A';
        $timezone = Setting::where('name', 'default_time_zone')->value('val') ?? 'UTC';
        $combinedFormat = $dateformate . ' ' . $timeformate;
        return view('appointment::backend.billing_record.billing_detail', compact('module_action', 'billing','dateformate','timeformate','timezone','combinedFormat'));
    }


}
