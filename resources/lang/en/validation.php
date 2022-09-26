<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal to :value.',
        'file' => 'The :attribute must be less than or equal to :value kilobytes.',
        'string' => 'The :attribute must be less than or equal to :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute must not be greater than :max.',
        'file' => 'The :attribute must not be greater than :max kilobytes.',
        'string' => 'The :attribute must not be greater than :max characters.',
        'array' => 'The :attribute must not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid timezone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute must be a valid URL must be like https://www.domain.com.',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name_en' => 'Name in english',
        'name_ar' => 'Name in arabic',
        'manufacture_country_id' => 'Manufacture country',
        'brand_id' => 'Brand',
        'country_id' => 'Country',
        'city_id' => 'City',
        'area_id' => 'Area',
        'slider_file' => [
            '*' => 'Choose file',
        ],
        'type' => 'Type',
        'color_name' => 'Color Name In English',
        'color_name_ar' => 'Color Name In Arabic',
        'color_code' => 'Color Code',
        'description_en' => 'Description In English',
        'description_ar' => 'Description In Arabic',
        'logo' => 'Logo',
        'tax_number' => 'Tax Number',
        'year_founded' => 'Year Founded',

        //main vehicles
        'vehicle_type' => 'Vehicle type',
        'car_model_id' => 'Model',
        'manufacturing_year' => 'Manufacturing year',
        'car_class_id' => 'Class',
        'body_shape' => 'Body shape',
        'engine' => 'Engine',
        'fuel_type' => 'Fuel type',
        'passengers_number' => 'Passengers number',
        'doors_number' => 'Doors number',
        'start_engine_with_button' => 'Start engine with button',
        'seat_adjustment' => 'Seat adjustment',
        'steering_wheel' => 'Steering wheel',
        'ambient_interior_lighting' => 'Ambient interior lighting',
        'seat_heating_cooling_function' => 'Seat heating cooling function',
        'remote_engine_start' => 'Remote engine start',
        'manual_steering_wheel_tilt_and_movement' => 'Manual steering wheel tilt and movement',
        'automatic_steering_wheel_tilt_and_movement' => 'Automatic steering wheel tilt and movement',
        'child_seat_restraint_system' => 'Child seat restraint system',
        'steering_wheel_controls' => 'Steering wheel controls',
        'seat_upholstery' => 'Seat upholstery',
        'air_conditioning_system' => 'Air conditioning system',
        'electric_windows' => 'Electric windows',
        'car_info_screen' => 'Car info screen',
        'seat_memory_feature' => 'Seat memory feature',
        'sunroof' => 'Sunroof',
        'interior_embroidery' => 'Interior embroidery',
        'side_awnings' => 'Side awnings',
        'seat_massage_feature' => 'Seat massage feature',
        'air_filtration' => 'Air filtration',
        'car_gear_shift_knob' => 'Car gear shift knob',
        'front_lighting' => 'Front lighting',
        'side_mirror' => 'Side mirror',
        'tire_type_and_size' => 'Tire type and size',
        'roof_rails' => 'Roof rails',
        'electric_back_door' => 'Electric back door',
        'transparent_coating' => 'Transparent coating',
        'toughened_glass' => 'Toughened glass',
        'back_lights' => 'Back lights',
        'fog_lights' => 'Fog lights',
        'daytime_running_lights' => 'Daytime running lights',
        'automatically_closing_doors' => 'Automatically closing doors',
        'roof' => 'Roof',
        'rear_spoiler' => 'Rear spoiler',
        'Electric_height_adjustment_for_headlights' => 'Electric height adjustment for headlights',
        'back_space' => 'Back space',
        'keyless_entry_feature' => 'Keyless entry feature',
        'sensitive_windshield_wipers_rain' => 'Sensitive windshield wipers rain',
        'weight' => 'Weight',
        'injection_type' => 'Injection type',
        'determination' => 'Determination',
        'fuel_tank_capacity' => 'Fuel tank capacity',
        'fuel_consumption' => 'Fuel consumption',

        'special_number_category_id' => 'Special Number Category',
        'number' => 'Number',
        'transfer_type' => 'Transfer Type',
        'price' => 'Price',
        'Include_insurance' => 'Include Insurance',
        'special_number_organization_id ' => 'Special Number Organization',
        'user_name' => 'User name',
        'nationality' => 'Nationality',
        'image_ID' => 'ID image',
        'title_en' => 'Title In English',
        'title_ar' => 'Title In Arabic',
        'id' => 'ID',
        'reservation_cost' => 'Reservation Cost',
        'role_id' => 'Role',
        'ad_type_id' => 'Ad Type',
        'ref_name' => 'Section',
        'negotiable' => 'Negotiable',
        'start_date' => 'Start Date',
        'end_date' => 'End Date',
        'discount' => 'Discount',
        'discount_type' => 'Discount Type',
    ],
    'insurance_amount' => 'Insurance amount',

];
