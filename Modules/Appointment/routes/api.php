<?php

use Illuminate\Support\Facades\Route;
use Modules\Appointment\Http\Controllers\Backend\API\AppointmentsController;
use Modules\Appointment\Http\Controllers\Backend\API\PatientEncounterController;
use Modules\Appointment\Http\Controllers\Backend\API\EncounterDashboardController;



Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('save-booking', [Modules\Appointment\Http\Controllers\Backend\AppointmentsController::class, 'store']);
    Route::post('update-booking/{id}', [Modules\Appointment\Http\Controllers\Backend\AppointmentsController::class, 'update']);
    Route::get('appointment-list', [AppointmentsController::class, 'appointmentList']);
    Route::get('appointment-detail', [AppointmentsController::class, 'appointmentDetails']);
    Route::post('save-payment', [Modules\Appointment\Http\Controllers\Backend\AppointmentsController::class, 'savePayment']);
    Route::post('update-status/{id}', [Modules\Appointment\Http\Controllers\Backend\AppointmentsController::class, 'updateStatus']);
    Route::post('reschedule-booking', [AppointmentsController::class, 'rescheduleBooking']);

    Route::get('encounter-list', [PatientEncounterController::class, 'encounterList']);
    Route::post('save-encounter', [Modules\Appointment\Http\Controllers\Backend\PatientEncounterController::class, 'store']);
    Route::post('update-encounter/{id}', [Modules\Appointment\Http\Controllers\Backend\PatientEncounterController::class, 'update']);
    Route::post('delete-encounter/{id}', [Modules\Appointment\Http\Controllers\Backend\PatientEncounterController::class, 'destroy']);
    Route::get('encounter-details', [PatientEncounterController::class, 'encounterList']);
    Route::get('download-encounter-invoice', [PatientEncounterController::class, 'encounterInvoice']);

    Route::get('encounter-dropdown-list', [EncounterDashboardController::class, 'encounterDropdownList']);

    Route::get('get-medical-report', [EncounterDashboardController::class, 'GetMedicalReport']);
    Route::post('save-medical-report', [Modules\Appointment\Http\Controllers\Backend\PatientEncounterController::class, 'saveMedicalReport']);

    Route::post('update-medical-report/{id}', [Modules\Appointment\Http\Controllers\Backend\PatientEncounterController::class, 'updateMedicalReport']);
    Route::get('delete-medical-report/{id}', [Modules\Appointment\Http\Controllers\Backend\PatientEncounterController::class, 'deleteMedicalReport']);

    Route::get('get-prescription', [EncounterDashboardController::class, 'GetPrescription']);
    Route::post('save-prescription', [Modules\Appointment\Http\Controllers\Backend\PatientEncounterController::class, 'saveMedicalReport']);

    Route::post('update-prescription/{id}', [Modules\Appointment\Http\Controllers\Backend\PatientEncounterController::class, 'updateMedicalReport']);
    Route::get('delete-prescription/{id}', [Modules\Appointment\Http\Controllers\Backend\PatientEncounterController::class, 'deleteMedicalReport']);

    Route::post('save-encounter-dashboard', [EncounterDashboardController::class, 'saveEncounterDashboard']);
    Route::get('encounter-dashboard-detail', [EncounterDashboardController::class, 'encounterDashboardDetail']);
    Route::get('encounter-service-detail', [EncounterDashboardController::class, 'encounterServiceDetails']);

    Route::get('download_invoice', [Modules\Appointment\Http\Controllers\Backend\ClinicAppointmentController::class, 'downloadPDf'])->name('download_invoice');

    Route::post("save-bodychart", [EncounterDashboardController::class, 'saveBodychart']);
    Route::post("update-bodychart/{id}", [EncounterDashboardController::class, 'updateBodychart']);
    Route::post('delete-bodychart/{id}', [EncounterDashboardController::class, 'deleteBodychart']);
    Route::get('bodychart-list', [EncounterDashboardController::class, 'bodyChartList']);

    Route::post('save-billing-details', [Modules\Appointment\Http\Controllers\Backend\BillingRecordController::class, 'saveBillingDetails']);
    Route::get('billing-list', [EncounterDashboardController::class, 'billingList']);
    Route::get('billing-record-detail', [EncounterDashboardController::class, 'billingList']);

    Route::get('get-revenue-chart-data', [AppointmentsController::class, 'getRevenuechartData']);
    Route::post("save-soap/{id}", [Modules\Appointment\Http\Controllers\Backend\ClinicAppointmentController::class, 'appointment_patient'])->name("appointment_patient");
    Route::get("get-soap/{id}", [Modules\Appointment\Http\Controllers\Backend\ClinicAppointmentController::class, 'appointment_patient_data'])->name("appointment_patient_data");
});
