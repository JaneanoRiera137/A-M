<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$codes = array(
    array( 'code' => 'appointment_date',  'description' => __( 'date of appointment', 'bookly' ) ),
    array( 'code' => 'appointment_time',  'description' => __( 'time of appointment', 'bookly' ) ),
    array( 'code' => 'booking_number',    'description' => __( 'booking number', 'bookly' ) ),
    array( 'code' => 'approve_appointment_url', 'description' => esc_html__( 'URL of approve appointment link (to use inside <a> tag)', 'bookly' ) ),
    array( 'code' => 'cancel_appointment_url', 'description' => esc_html__( 'URL of cancel appointment link (to use inside <a> tag)', 'bookly' ) ),
    array( 'code' => 'category_name',     'description' => __( 'name of category', 'bookly' ) ),
    array( 'code' => 'client_email',      'description' => __( 'email of client', 'bookly' ) ),
    array( 'code' => 'client_name',       'description' => __( 'name of client', 'bookly' ) ),
    array( 'code' => 'client_phone',      'description' => __( 'phone of client', 'bookly' ) ),
    array( 'code' => 'company_name',      'description' => __( 'name of company', 'bookly' ) ),
    array( 'code' => 'company_address',   'description' => __( 'address of company', 'bookly' ) ),
    array( 'code' => 'company_phone',     'description' => __( 'company phone', 'bookly' ) ),
    array( 'code' => 'company_website',   'description' => __( 'company web-site address', 'bookly' ) ),
    array( 'code' => 'custom_fields',     'description' => __( 'combined values of all custom fields', 'bookly' ) ),
    array( 'code' => 'google_calendar_url', 'description' => esc_html__( 'URL for adding event to client\'s Google Calendar (to use inside <a> tag)', 'bookly' ) ),
    array( 'code' => 'number_of_persons', 'description' => __( 'number of persons', 'bookly' ) ),
    array( 'code' => 'payment_type',      'description' => __( 'payment type', 'bookly' ) ),
    array( 'code' => 'service_info',      'description' => __( 'info of service', 'bookly' ) ),
    array( 'code' => 'service_name',      'description' => __( 'name of service', 'bookly' ) ),
    array( 'code' => 'service_price',     'description' => __( 'price of service', 'bookly' ) ),
    array( 'code' => 'staff_email',       'description' => __( 'email of staff', 'bookly' ) ),
    array( 'code' => 'staff_name',        'description' => __( 'name of staff', 'bookly' ) ),
    array( 'code' => 'staff_phone',       'description' => __( 'phone of staff', 'bookly' ) ),
    array( 'code' => 'staff_info',        'description' => __( 'info of staff', 'bookly' ) ),
    array( 'code' => 'total_price',       'description' => __( 'total price of booking (sum of all cart items after applying coupon)', 'bookly' ) ),
);
\BooklyLite\Lib\Utils\Common::Codes( apply_filters( 'bookly_notification_short_codes', $codes ) );
