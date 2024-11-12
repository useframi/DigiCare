<?php

namespace App\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Modules\Currency\Models\Currency;
use App\Models\User;
use Modules\Tax\Models\Tax;
use Modules\Tax\Transformers\TaxResource;

class SettingController extends Controller
{
    public function appConfiguraton(Request $request)
    {
        $settings = Setting::all()->pluck('val', 'name');

        $currencies = Currency::all();
        $response = [];

        // Define the specific names you want to include
        $specificNames = ['app_name', 'footer_text', 'primary', 'razorpay_secretkey', 'razorpay_publickey', 'stripe_secretkey', 'stripe_publickey', 'paystack_secretkey', 'paystack_publickey', 'paypal_secretkey', 'paypal_clientid', 'flutterwave_secretkey', 'flutterwave_publickey', 'onesignal_app_id', 'onesignal_rest_api_key', 'onesignal_channel_id', 'google_maps_key', 'helpline_number', 'copyright', 'inquriy_email', 'site_description', 'customer_app_play_store', 'customer_app_app_store', 'isForceUpdate', 'version_code','account_id','client_id','client_secret','airtel_secretkey', 'airtel_clientid','phonepay_app_id','phonepay_merchant_id','phonepay_salt_key','phonepay_salt_index','midtrans_clientid','cinet_siteid','cinet_apikey','cinet_secretkey','sadad_id','sadad_key','sadad_domain'];
        foreach ($settings as $name => $value) {
            if (in_array($name, $specificNames)) {
                if (strpos($name, 'onesignal_') === 0 && $request->is_authenticated == 1) {
                    $nestedKey = 'onesignal_customer_app';
                    $nestedName = str_replace('', 'onesignal_', $name);
                    if (!isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                } elseif (strpos($name, 'razorpay_') === 0 && $request->is_authenticated == 1) {
                    $nestedKey = 'razor_pay';
                    $nestedName = str_replace('', 'razorpay_', $name);
                    if (!isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                } elseif (strpos($name, 'stripe_') === 0 && $request->is_authenticated == 1) {
                    $nestedKey = 'stripe_pay';
                    $nestedName = str_replace('', 'stripe_', $name);
                    if (!isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                } elseif (strpos($name, 'paystack_') === 0 && $request->is_authenticated == 1 && $settings['paystack_payment_method'] !== null) {
                    $nestedKey = 'paystack_pay';
                    $nestedName = str_replace('', 'paystack_', $name);
                    if (!isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                } elseif (strpos($name, 'paypal_') === 0 && $request->is_authenticated == 1 && $settings['paypal_payment_method'] !== null) {
                    $nestedKey = 'paypal_pay';
                    $nestedName = str_replace('', 'paypal_', $name);
                    if (!isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                } elseif (strpos($name, 'flutterwave_') === 0 && $request->is_authenticated == 1 && $settings['flutterwave_payment_method'] !== null) {
                    $nestedKey = 'flutterwave_pay';
                    $nestedName = str_replace('', 'flutterwave_', $name);
                    if (!isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                }elseif (strpos($name, 'airtel_') === 0 && $request->is_authenticated == 1 && $settings['airtel_payment_method'] !== Null) {
                    $nestedKey = 'airtel_pay';
                    $nestedName = str_replace('', 'airtel_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;

                }elseif (strpos($name, 'phonepay_') === 0 && $request->is_authenticated == 1 && $settings['phonepay_payment_method'] !== Null) {
                    $nestedKey = 'phonepay_pay';
                    $nestedName = str_replace('', 'phonepay_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                }elseif (strpos($name, 'midtrans_') === 0 && $request->is_authenticated == 1 && $settings['midtrans_payment_method'] !== Null) {
                    $nestedKey = 'midtrans_pay';
                    $nestedName = str_replace('', 'midtrans_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;

                }elseif (strpos($name, 'cinet_') === 0 && $request->is_authenticated == 1 && $settings['cinet_payment_method'] !== Null) {
                    $nestedKey = 'cinet_pay';
                    $nestedName = str_replace('', 'cinet_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                }elseif (strpos($name, 'sadad_') === 0 && $request->is_authenticated == 1 && $settings['sadad_payment_method'] !== Null) {
                    $nestedKey = 'sadad_pay';
                    $nestedName = str_replace('', 'sadad_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;

                }

                if (!strpos($name, 'onesignal_') === 0) {
                    $response[$name] = $value;
                } elseif (!strpos($name, 'stripe_') === 0) {
                    $response[$name] = $value;
                } elseif (!strpos($name, 'razorpay_') === 0) {
                    $response[$name] = $value;
                }elseif (! strpos($name, 'paystack_') === 0) {
                    $response[$name] = $value;
                } elseif (! strpos($name, 'paypal_') === 0) {
                    $response[$name] = $value;
                } elseif (! strpos($name, 'flutterwave_') === 0) {
                    $response[$name] = $value;
                }elseif (! strpos($name, 'airtel_') === 0) {
                    $response[$name] = $value;
                }elseif (! strpos($name, 'phonepay_') === 0) {
                    $response[$name] = $value;
                }elseif (! strpos($name, 'midtrans_') === 0) {
                    $response[$name] = $value;
                }
                elseif (! strpos($name, 'cinet_') === 0) {
                    $response[$name] = $value;
                }elseif (! strpos($name, 'sadad_') === 0) {
                    $response[$name] = $value;
                }
            }
        }
        // Fetch currency data
        $currencies = Currency::all();

        $currencyData = null;
        if ($currencies->isNotEmpty()) {
            $currency = $currencies->first();
            $currencyData = [
                'currency_name' => $currency->currency_name,
                'currency_symbol' => $currency->currency_symbol,
                'currency_code' => $currency->currency_code,
                'currency_position' => $currency->currency_position,
                'no_of_decimal' => $currency->no_of_decimal,
                'thousand_separator' => $currency->thousand_separator,
                'decimal_separator' => $currency->decimal_separator,
            ];
        }

        $taxes = Tax::active()->whereNull('module_type')->orWhere('module_type', 'services')->where('status', 1)->get();

        if (isset($settings['isForceUpdate']) && isset($settings['version_code'])) {
            $response['isForceUpdate'] = intval($settings['isForceUpdate']);

            $response['version_code'] = intval($settings['version_code']);
        } else {
            $response['isForceUpdate'] = 0;

            $response['version_code'] = 0;
        }
        $response['tax'] = $taxes;

        $response['currency'] = $currencyData;
        $response['google_login_status'] = 'false';
        $response['apple_login_status'] = 'false';
        $response['otp_login_status'] = 'false';
        $response['site_description'] = $settings['site_description'] ?? null;
        // Add locale language to the response
        $response['application_language'] = app()->getLocale();

        $response['view_patient_soap'] = isset($settings['view_patient_soap']) ? intval($settings['view_patient_soap']) : 0;
        $response['is_body_chart'] = isset($settings['is_body_chart']) ? intval($settings['is_body_chart']) : 0;
        $response['is_telemed_setting'] = isset($settings['is_telemed_setting']) ? intval($settings['is_telemed_setting']) : 0;
        $response['is_multi_vendor'] = isset($settings['is_multi_vendor']) ? intval($settings['is_multi_vendor']) : 0;  
        $response['is_encounter_problem'] = isset($settings['is_encounter_problem']) ? intval($settings['is_encounter_problem']) : 0;
        $response['is_encounter_observation'] = isset($settings['is_encounter_observation']) ? intval($settings['is_encounter_observation']) : 0;
        $response['is_encounter_note'] = isset($settings['is_encounter_note']) ? intval($settings['is_encounter_note']) : 0;
        $response['is_encounter_prescription'] = isset($settings['is_encounter_prescription']) ? intval($settings['is_encounter_prescription']) : 0;

        $response['status'] = true;

        return response()->json($response);
    }

    public function Configuraton(Request $request)
    {
        $googleMeetSettings = Setting::whereIn('name', ['google_meet_method', 'google_clientid', 'google_secret_key'])
            ->pluck('val', 'name');
        $settings = $googleMeetSettings->toArray();
        return $settings;
    }

    
}
