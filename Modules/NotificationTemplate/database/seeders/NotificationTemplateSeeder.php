<?php

namespace Modules\NotificationTemplate\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Constant\Models\Constant;
use Modules\NotificationTemplate\Models\NotificationTemplate;

class NotificationTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        /*
         * NotificationTemplates Seed
         * ------------------
         */

        // DB::table('notificationtemplates')->truncate();
        // echo "Truncate: notificationtemplates \n";

        $types = [
            [
                'type' => 'notification_type',
                'value' => 'new_appointment',
                'name' => 'New Appointment',
            ],
            [
                'type' => 'notification_type',
                'value' => 'accept_appointment',
                'name' => 'Accept Appointment',
            ],
            [
                'type' => 'notification_type',
                'value' => 'reject_appointment',
                'name' => 'Reject Appointment',
            ],
            [
                'type' => 'notification_type',
                'value' => 'accept_appointment_request',
                'name' => 'Accept Appointment Request',
            ],
            [
                'type' => 'notification_type',
                'value' => 'checkout_appointment',
                'name' => 'Complete On Appointment',
            ],
            [
                'type' => 'notification_type',
                'value' => 'cancel_appointment',
                'name' => 'Cancel On Appointment',
            ],
            [
                'type' => 'notification_type',
                'value' => 'reschedule_appointment',
                'name' => 'Reschedule Appointment',
            ],
            [
                'type' => 'notification_type',
                'value' => 'quick_appointment',
                'name' => 'Quick Appointment',
            ],
            [
                'type' => 'notification_type',
                'value' => 'change_password',
                'name' => 'Chnage Password',
            ],
            [
                'type' => 'notification_type',
                'value' => 'forget_email_password',
                'name' => 'Forget Email/Password',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'id',
                'name' => 'ID',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'user_name',
                'name' => 'Customer Name',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'description',
                'name' => 'Description / Note',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'appointment_id',
                'name' => 'Appointment ID',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'appointment_date',
                'name' => 'Appointment Date',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'appointment_time',
                'name' => 'Appointment Time',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'appointment_services_names',
                'name' => 'Appointment Services Names',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'appointment_duration',
                'name' => 'Appointment Duration',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'doctor_name',
                'name' => 'Doctor Name',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'venue_address',
                'name' => 'Venue / Address',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'logged_in_user_fullname',
                'name' => 'Your Name',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'logged_in_user_role',
                'name' => 'Your Position',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'company_name',
                'name' => 'Company Name',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'company_contact_info',
                'name' => 'Company Info',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'user_id',
                'name' => 'User\' ID',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'user_password',
                'name' => 'User Password',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'link',
                'name' => 'Link',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'site_url',
                'name' => 'Site URL',
            ],
            [
                'type' => 'notification_to',
                'value' => 'user',
                'name' => 'User',
            ],
            [
                'type' => 'notification_to',
                'value' => 'doctor',
                'name' => 'Doctor',
            ],
            [
                'type' => 'notification_to',
                'value' => 'admin',
                'name' => 'Admin',
            ],
            [
                'type' => 'notification_type',
                'value' => 'new_request_service',
                'name' => 'New Service Request',
            ],
            [
                'type' => 'notification_type',
                'value' => 'accept_request_service',
                'name' => 'Accept Service Request',
            ],
            [
                'type' => 'notification_type',
                'value' => 'reject_request_service',
                'name' => 'Reject Service Request',
            ],
        ];

        foreach ($types as $value) {
            Constant::updateOrCreate(['type' => $value['type'], 'value' => $value['value']], $value);
        }

        echo " Insert: notificationtempletes \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('notification_templates')->delete();
        DB::table('notification_template_content_mapping')->delete();

        $template = NotificationTemplate::create([
            'type' => 'new_appointment',
            'name' => 'new_appointment',
            'label' => 'Appointment confirmation',
            'status' => 1,
            'to' => '["admin", "vendor", "doctor"]',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'Thank you for choosing our services! Your appointment has been successfully confirmed. We look forward to serving you and providing an exceptional experience. Stay tuned for further updates.',
            'status' => 1,
            'subject' => 'New Appointment Booked!',
            'template_detail' => '
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Subject: Appointment Confirm - Thank You!</span></p>
            <p><strong id="docs-internal-guid-7d6bdcce-7fff-5035-731b-386f9021a5db" style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Dear [[ user_name ]],</span></p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">We are delighted to inform you that your appointment has been successfully confirmed! Thank you for choosing our services. We are excited to have you as our valued customer and are committed to providing you with a wonderful experience.</span></p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <h4>Appointment Details</h4>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Appointment ID: [[ id ]]</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Appointment Date: [[ appointment_date ]]</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Service/Event: [[ appointment_services_names ]]</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Date: [[ appointment_date ]]</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Time: [[ appointment_time ]]</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Location: [[ venue_address ]]</span></p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">We want to assure you that we have received your appointment details and everything is in order. Our team is eagerly preparing to make this a memorable experience for you. If you have any specific requirements or questions regarding your appointment, please feel free to reach out to us.</span></p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">We recommend marking your calendar and setting a reminder for the date and time of the event to ensure you don\'t miss your appointment. Should there be any updates or changes to your appointment, we will promptly notify you.</span></p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Once again, thank you for choosing our services. We look forward to providing you with exceptional service and creating lasting memories. If you have any further queries, please do not hesitate to contact our friendly customer support team.</span></p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Best regards,</span></p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ logged_in_user_fullname ]],</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ logged_in_user_role ]],</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ company_name ]],</span></p>
            <p>&nbsp;</p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ company_contact_info ]]</span></p>
            <p><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">&nbsp;</span></p>
          ',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'accept_appointment',
            'name' => 'accept_appointment',
            'label' => 'Accept Appointment',
            'status' => 1,
            'to' => '["user","admin","demo_admin","vendor"]',
            'channels' => ['IS_MAIL' => '0', 'PUSH_NOTIFICATION' => '1', 'IS_CUSTOM_WEBHOOK' => '0'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'Welcome to your appointment accommodation. We hope you have a pleasant stay!',
            'status' => 1,
            'subject' => 'Accept Appointment',
            'template_detail' => '<p>Welcome to your appointment accommodation. We hope you have a pleasant stay!</p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'reject_appointment',
            'name' => 'reject_appointment',
            'label' => 'Reject Appointment',
            'status' => 1,
            'to' => '["user","admin","demo_admin","vendor"]',
            'channels' => ['IS_MAIL' => '0', 'PUSH_NOTIFICATION' => '1', 'IS_CUSTOM_WEBHOOK' => '0'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'Thank you for choosing our services. Please remember to check out by [check-out time]. We hope you had a wonderful experience!',
            'status' => 1,
            'subject' => 'Your appointment is rejected',
            'template_detail' => '<p>Thank you for choosing our services. Please remember to check out by [check-out time]. We hope you had a wonderful experience!</p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'checkout_appointment',
            'name' => 'checkout_appointment',
            'label' => 'Complete On Appointment',
            'status' => 1,
            'to' => '["user", "doctor"]',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'Congratulations! Your appointment has been successfully completed. We appreciate your business and look forward to serving you again.',
            'status' => 1,
            'subject' => 'Appointment Completed',
            'template_detail' => '
            <p>Subject: Appointment Completion and Invoice</p>
            <p>&nbsp;</p>
            <p>Dear [[ user_name ]],</p>
            <p>&nbsp;</p>
            <p>We are writing to inform you that your recent appointment with us has been successfully completed. We sincerely appreciate your trust in our services and the opportunity to serve you.</p>
            <p>&nbsp;</p>
            <h4>Appointment Details:</h4>
            <p>&nbsp;</p>
            <p>Appointment Date: [[ appointment_date ]]</p>
            <p>Appointment Time: [[ appointment_time ]]</p>
            <p>Service Provided: [[ appointment_services_names ]]</p>
            <p>Service Duration: [[ appointment_duration ]]</p>
            <p>Service Provider: [[ doctor_name ]]</p>
            <p>&nbsp;</p>
            <p>We are pleased to inform you that the appointment was carried out smoothly, and we hope it met or exceeded your expectations. Our dedicated team worked diligently to ensure your satisfaction throughout the process.</p>
            <p>&nbsp;</p>
            <p>To ensure transparency in our billing procedures, we have attached the invoice for the services rendered during your appointment. The invoice provides a detailed breakdown of the services availed, any applicable taxes, and the total amount due. Please find the invoice attached to this email [or provide instructions on how to access the invoice if it is hosted online].</p>
            <p>&nbsp;</p>
            <p>Thank you once again for choosing our services. We appreciate your trust and support.</p>
            <p>&nbsp;</p>
            <p>Best regards,</p>
            <p>&nbsp;</p>
            <p>[[ logged_in_user_fullname ]]<br />[[ logged_in_user_role ]]<br />[[ company_name ]]</p>
            <p>[[ company_contact_info ]]</p>
          ',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'cancel_appointment',
            'name' => 'cancel_appointment',
            'label' => 'Cancel On Booking',
            'status' => 1,
            'to' => '["user", "doctor"]',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'We regret to inform you that your appointment has been cancelled. If you have any questions or need further assistance, please contact our support team.',
            'status' => 1,
            'subject' => 'Appointment Cancelled',
            'template_detail' => '<p><span id="docs-internal-guid-b1e18659-7fff-e334-ed58-8ced003b3621"><span style="font-size: 11pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space-collapse: preserve;">We regret to inform you that your appointment has been cancelled. If you have any questions or need further assistance, please contact our support team.</span></span></p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'reschedule_appointment',
            'name' => 'reschedule_appointment',
            'label' => 'Reschedule Appointment',
            'status' => 1,
            'to' => '["user","demo_admin","admin", "vendor", "doctor"]',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'Your appointment has been successfully rescheduled.',
            'status' => 1,
            'subject' => 'Appointment Rescheduled',
            'template_detail' => '<p><span id="docs-internal-guid-b1e18659-7fff-e334-ed58-8ced003b3621"><span style="font-size: 11pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space-collapse: preserve;">We regret to inform you that your appointment has been cancelled. If you have any questions or need further assistance, please contact our support team.</span></span></p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'quick_appointment',
            'name' => 'quick_appointment',
            'label' => 'Quick Booking',
            'status' => 1,
            'to' => '["user"]',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'status' => 1,
            'subject' => 'Quick Appointment',
            'template_detail' => '
            <p>Subject: Appointment Confirmation - Details Enclosed</p>
            <p>&nbsp;</p>
            <p>Dear [[ user_name ]],</p>
            <p>&nbsp;</p>
            <p>We are pleased to inform you that your appointment has been successfully booked. We value your time and are committed to providing you with excellent service. Please find the details of your appointment below:</p>
            <p>&nbsp;</p>
            <p>Appointment Date: [[ appointment_date ]]</p>
            <p>Appointment Time: [[ appointment_time ]]</p>
            <p>Appointment Duration: [[ appointment_duration ]]</p>
            <p>&nbsp;</p>
            <p>We kindly request that you arrive a few minutes before your scheduled appointment to ensure a smooth and timely experience. If, for any reason, you need to reschedule or cancel your appointment, please notify us at least [[ link ]] in advance so that we can accommodate other clients.</p>
            <p>&nbsp;</p>
            <p>Should you have any questions or require further information regarding your appointment, please feel free to reach out to us. Our dedicated team is here to assist you and ensure that your experience exceeds your expectations.</p>
            <p>&nbsp;</p>
            <p>Thank you for choosing our services, and we appreciate the opportunity to assist you with your [service type] needs.</p>
            <p>&nbsp;</p>
            <p>Best regards,</p>
            <p>&nbsp;</p>
            <p>[[ logged_in_user_fullname ]]<br />[[ logged_in_user_role ]]<br />[[ company_name ]]</p>
            <p>[[ company_contact_info ]]</p>
            <p>&nbsp;</p>
          ',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'change_password',
            'name' => 'change_password',
            'label' => 'Change Password',
            'status' => 1,
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'status' => 1,
            'subject' => 'Change Password',
            'template_detail' => '
            <p>Subject: Password Change Confirmation</p>
            <p>Dear [[ user_name ]],</p>
            <p>&nbsp;</p>
            <p>We wanted to inform you that a recent password change has been made for your account. If you did not initiate this change, please take immediate action to secure your account.</p>
            <p>&nbsp;</p>
            <p>To regain control and secure your account:</p>
            <p>&nbsp;</p>
            <p>Visit [[ link ]].</p>
            <p>Follow the instructions to verify your identity.</p>
            <p>Create a strong and unique password.</p>
            <p>Update passwords for any other accounts using similar credentials.</p>
            <p>If you have any concerns or need assistance, please contact our customer support team.</p>
            <p>&nbsp;</p>
            <p>Thank you for your attention to this matter.</p>
            <p>&nbsp;</p>
            <p>Best regards,</p>
            <p>[[ logged_in_user_fullname ]]<br />[[ logged_in_user_role ]]<br />[[ company_name ]]</p>
            <p>[[ company_contact_info ]]</p>
          ',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'forget_email_password',
            'name' => 'forget_email_password',
            'label' => 'Forget Email/Password',
            'status' => 1,
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'status' => 1,
            'subject' => 'Forget Email/Password',
            'template_detail' => '
            <p>Subject: Password Reset Instructions</p>
            <p>&nbsp;</p>
            <p>Dear [[ user_name ]],</p>
            <p>A password reset request has been initiated for your account. To reset your password:</p>
            <p>&nbsp;</p>
            <p>Visit [[ link ]].</p>
            <p>Enter your email address.</p>
            <p>Follow the instructions provided to complete the reset process.</p>
            <p>If you did not request this reset or need assistance, please contact our support team.</p>
            <p>&nbsp;</p>
            <p>Thank you.</p>
            <p>&nbsp;</p>
            <p>Best regards,</p>
            <p>[[ logged_in_user_fullname ]]<br />[[ logged_in_user_role ]]<br />[[ company_name ]]</p>
            <p>[[ company_contact_info ]]</p>
            <p>&nbsp;</p>
          ',
        ]);

        // $template = NotificationTemplate::create([
        //     'type' => 'order_placed',
        //     'name' => 'order_placed',
        //     'label' => 'Order Placed',
        //     'status' => 1,
        //     'to' => '["user","admin"]',
        // ]);
        // $template->defaultNotificationTemplateMap()->create([
        //     'language' => 'en',
        //     'notification_link' => '',
        //     'notification_message' => 'Thank you for choosing Us for your recent order. We are delighted to confirm that your order has been successfully placed.!',
        //     'status' => 1,
        //     'subject' => 'Order Placed!',
        //     'template_detail' => '<p>Thank you for choosing Us for your recent order. We are delighted to confirm that your order has been successfully placed.!</p>',
        // ]);

        // $template = NotificationTemplate::create([
        //     'type' => 'order_proccessing',
        //     'name' => 'order_proccessing',
        //     'label' => 'Order Processing',
        //     'status' => 1,
        //     'to' => '["user","admin"]',
        // ]);
        // $template->defaultNotificationTemplateMap()->create([
        //     'language' => 'en',
        //     'notification_link' => '',
        //     'notification_message' => "We're excited to let you know that your order is now being prepared and will soon be on its way to satisfy your taste buds!",
        //     'status' => 1,
        //     'subject' => 'Order Processing!',
        //     'template_detail' => "<p>We're excited to let you know that your order is now being prepared and will soon be on its way to satisfy your taste buds!</p>",
        // ]);

        // $template = NotificationTemplate::create([
        //     'type' => 'order_delivered',
        //     'name' => 'order_delivered',
        //     'label' => 'Order Delivered',
        //     'status' => 1,
        //     'to' => '["user","admin"]',
        // ]);
        // $template->defaultNotificationTemplateMap()->create([
        //     'language' => 'en',
        //     'notification_link' => '',
        //     'notification_message' => "We're delighted to inform you that your order has been successfully delivered to your doorstep.",
        //     'status' => 1,
        //     'subject' => 'Order Delivered!',
        //     'template_detail' => "<p>We're delighted to inform you that your order has been successfully delivered to your doorstep.</p>",
        // ]);

        // $template = NotificationTemplate::create([
        //     'type' => 'order_cancelled',
        //     'name' => 'order_cancelled',
        //     'label' => 'Oreder Cancelled',
        //     'status' => 1,
        //     'to' => '["user","admin"]',
        // ]);
        // $template->defaultNotificationTemplateMap()->create([
        //     'language' => 'en',
        //     'notification_link' => '',
        //     'notification_message' => 'We regret to inform you that your recent order has been cancelled.',
        //     'status' => 1,
        //     'subject' => 'Order Cancelled!',
        //     'template_detail' => '<p>We regret to inform you that your recent order has been cancelled.</p>',
        // ]);


        $template = NotificationTemplate::create([
            'type' => 'new_request_service',
            'name' => 'new_request_service',
            'label' => 'New Service Request',
            'status' => 1,
            'to' => '["admin","demo_admin"]',
            'channels' => ['IS_MAIL' => '0', 'PUSH_NOTIFICATION' => '1', 'IS_CUSTOM_WEBHOOK' => '0'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'New Service Request Found!',
            'status' => 1,
            'subject' => 'New Service Request Found!',
            'template_detail' => '<p>New Service Request Found!</p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'accept_request_service',
            'name' => 'accept_request_service',
            'label' => 'Accept Service Request',
            'status' => 1,
            'to' => '["vendor"]',
            'channels' => ['IS_MAIL' => '0', 'PUSH_NOTIFICATION' => '1', 'IS_CUSTOM_WEBHOOK' => '0'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'Your Service Request Has Been Accepted!',
            'status' => 1,
            'subject' => 'Your Service Request Has Been Accepted!',
            'template_detail' => '<p>Your Service Request Has Been Accepted!</p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'reject_request_service',
            'name' => 'reject_request_service',
            'label' => 'Reject Service Request',
            'status' => 1,
            'to' => '["vendor"]',
            'channels' => ['IS_MAIL' => '0', 'PUSH_NOTIFICATION' => '1', 'IS_CUSTOM_WEBHOOK' => '0'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'Your Service Request Has Been Rejected!',
            'status' => 1,
            'subject' => 'Your Service Request Has Been Rejected!',
            'template_detail' => '<p>Your Service Request Has Been Rejected!</p>',
        ]);
    }
}
