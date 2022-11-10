<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Favourites\CanBeFavourites;
use App\Traits\Files\HasFiles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Vehicle extends Model
{
    use HasFactory, HasFiles, CanBeFavourites, HasAds;

    protected $table = 'vehicles';

    protected $fillable = ['id', 'vehicle_type', 'vehicle_id', 'ghamara_count',
        'brand_id', 'car_model_id', 'car_class_id', 'manufacturing_year', 'is_new', 'traveled_distance',
        'traveled_distance_type', 'outside_color_id', 'inside_color_id', 'in_bahrain', 'country_id', 'guarantee',
        'guarantee_month', 'guarantee_year', 'transmission_type', 'engine_size', 'cylinder_number', 'fuel_type',
        'doors_number', 'start_engine_with_button', 'seat_adjustment', 'seat_heating_cooling_function',
        'fog_lights', 'seat_massage_feature', 'seat_memory_feature', 'front_lighting', 'electric_back_door',
        'wheel_drive_system', 'specifications', 'status', 'insurance', 'insurance_month',
        'insurance_year', 'coverage_type', 'start_with_fingerprint', 'remote_start', 'screen', 'seat_upholstery',
        'air_conditioning_system', 'windows_control', 'wheel_size', 'wheel_type', 'sunroof', 'selling_by_plate',
        'number_plate', 'price_is_negotiable', 'location', 'additional_notes', 'price', 'discount',
        'discount_type', 'mawatery_third_party', 'user_vehicle_status', 'vehicle_name', 'chassis_number',
        'battery_size', 'maintenance_history', 'maintenance_history_km', 'tire_installation_date',
        'tire_installation_date_km', 'tire_warranty_expiration_date', 'tire_warranty_expiration_date_km',
        'battery_installation_date', 'battery_installation_date_km', 'battery_warranty_expiry_date',
        'battery_warranty_expiry_date_km', 'vehicle_registration_expiry_date',
        'vehicle_registration_expiry_date_km', 'vehicle_insurance_expiry_date',
        'vehicle_insurance_expiry_date_km', 'number_of_views', 'active_number_of_views', 'availability', 'active'];

    protected $hidden = ['created_at', 'updated_at', 'traveled_distance', 'user_vehicle_status', 'mawatery_third_party'];
    protected $appends = ['one_image', 'is_favorite', 'favorites_count', 'distance_color', 'price_after_discount'];
    public $timestamps = true;

    // relations start
    public function vehicable()
    {
        return $this->morphTo();
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function car_class()
    {
        return $this->belongsTo(CarClass::class);
    }

    public function car_model()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function outside_color()
    {
        return $this->belongsTo(Color::class, 'outside_color_id');
    }

    public function inside_color()
    {
        return $this->belongsTo(Color::class, 'inside_color_id');
    }

    public function reserve_vehicles()
    {
        return $this->hasMany(ReserveVehicle::class);
    }

    public function test_drives()
    {
        return $this->hasMany(TestDrive::class);
    }

    public function branches()
    {
        return $this->morphToMany('App\Models\Branch', 'usable', 'branch_use');
    }

    public function offers()
    {
        return $this->morphMany(Offer::class, 'offerable');
    }

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function additional_maintenance_history()
    {
        return $this->hasMany(MaintenanceHistory::class);
    }

    // relations end

    // scopes start
    public function scopeVehicleProperties()
    {
        $features = [];
        $vehicle = Vehicle::find($this->id);
        if ($vehicle->is_new == false) {

            $features[] = [
                'key' => __('vehicle.is_new'),
                'value' => $vehicle->is_new ? __('vehicle.new') : __('vehicle.used'),
            ];
        }

        $features[] = [
            'key' => __('vehicle.vehicle_type'),
            'value' => __('vehicle.' . $vehicle->vehicle_type)
        ];

//        if ($vehicle->vehicle_type == 'pickups') {
//            $features[] = [
//                'key' => __('vehicle.ghamara_count'),
//                'value' => __('vehicle.' . $vehicle->ghamara_count)
//            ];
//        }
        $features[] = [
            'key' => __('vehicle.brand_id'),
            'value' => $vehicle->brand->name
        ];
        $features[] = [
            'key' => __('vehicle.car_model_id'),
            'value' => $vehicle->car_model->name
        ];
        $features[] = [
            'key' => __('vehicle.car_class_id'),
            'value' => $vehicle->car_class->name
        ];
        $features[] = [
            'key' => __('vehicle.manufacturing_year'),
            'value' => $vehicle->manufacturing_year
        ];
        if ($vehicle->is_new == false) {
            $features[] = [
                'key' => __('vehicle.traveled_distance'),
                'value' => $vehicle->traveled_distance . ' ' . __('vehicle.' . $vehicle->traveled_distance_type)
            ];
        }
        $features[] = [
            'key' => __('vehicle.outside_color'),
            'value' => $vehicle->outside_color ? $vehicle->outside_color->name : '--'
        ];
        $features[] = [
            'key' => __('vehicle.inside_color'),
            'value' => $vehicle->inside_color ? $vehicle->inside_color->name : '--'
        ];
        if ($vehicle->is_new == false) {
            $features[] = [
                'key' => __('vehicle.in_bahrain'),
                'value' => $vehicle->in_bahrain ? __('vehicle.yes') : __('vehicle.no')
            ];
            if ($vehicle->in_bahrain == false) {
                $features[] = [
                    'key' => __('vehicle.country_id'),
                    'value' => $vehicle->country ? $vehicle->country->name : ''
                ];
            }
            $features[] = [
                'key' => __('vehicle.guarantee'),
                'value' => $vehicle->guarantee ? __('vehicle.yes') : __('vehicle.no')
            ];
            if ($vehicle->guarantee == true) {
                $features[] = [
                    'key' => __('vehicle.guarantee_month'),
                    'value' => $vehicle->guarantee_month
                ];
                $features[] = [
                    'key' => __('vehicle.guarantee_year'),
                    'value' => $vehicle->guarantee_year
                ];
            }
        }
        $features[] = [
            'key' => __('vehicle.transmission_type'),
            'value' => $vehicle->transmission_type ? __('vehicle.' . $vehicle->transmission_type) : '--'
        ];
        $features[] = [
            'key' => __('vehicle.engine_size'),
            'value' => $vehicle->engine_size != null ? __('vehicle.' . $vehicle->engine_size) : '--'
        ];
        $features[] = [
            'key' => __('vehicle.cylinder_number'),
            'value' => $vehicle->cylinder_number ? $vehicle->cylinder_number : '--'
        ];
        $features[] = [
            'key' => __('vehicle.fuel_type'),
            'value' => __('vehicle.' . $vehicle->fuel_type)
        ];
        $features[] = [
            'key' => __('vehicle.wheel_drive_system'),
            'value' => $vehicle->wheel_drive_system ? __('vehicle.' . $vehicle->wheel_drive_system) : '--'
        ];
        $features[] = [
            'key' => __('vehicle.specifications'),
            'value' => $vehicle->specifications ? __('vehicle.' . $vehicle->specifications) : '--'
        ];
        if ($vehicle->is_new == false) {
            $features[] = [
                'key' => __('vehicle.status'),
                'value' => __('vehicle.' . $vehicle->status)
            ];
            $features[] = [
                'key' => __('vehicle.insurance'),
                'value' => $vehicle->insurance ? __('vehicle.yes') : __('vehicle.no')
            ];

            if ($vehicle->insurance == true) {
                $features[] = [
                    'key' => __('vehicle.insurance_month'),
                    'value' => $vehicle->insurance_month
                ];
                $features[] = [
                    'key' => __('vehicle.insurance_year'),
                    'value' => $vehicle->insurance_year
                ];
            }

            $features[] = [
                'key' => __('vehicle.coverage_type'),
                'value' => $vehicle->coverage_type ? __('vehicle.' . $vehicle->coverage_type) : '--'
            ];
        }
        $features[] = [
            'key' => __('vehicle.start_with_fingerprint'),
            'value' => $vehicle->start_with_fingerprint ? __('vehicle.yes') : __('vehicle.no')
        ];
        $features[] = [
            'key' => __('vehicle.remote_start'),
            'value' => $vehicle->remote_start ? __('vehicle.yes') : __('vehicle.no')
        ];
        $features[] = [
            'key' => __('vehicle.screen'),
            'value' => $vehicle->screen ? __('vehicle.yes') : __('vehicle.no')
        ];
        $features[] = [
            'key' => __('vehicle.seat_upholstery'),
            'value' => $vehicle->seat_upholstery ? __('vehicle.' . $vehicle->seat_upholstery) : '--'
        ];
        $features[] = [
            'key' => __('vehicle.air_conditioning_system'),
            'value' => $vehicle->air_conditioning_system ? __('vehicle.' . $vehicle->air_conditioning_system) : '--'
        ];
        $features[] = [
            'key' => __('vehicle.windows_control'),
            'value' => $vehicle->windows_control ? __('vehicle.' . $vehicle->windows_control) : '--'
        ];
        $features[] = [
            'key' => __('vehicle.wheel_size'),
            'value' => $vehicle->wheel_size ? __('vehicle.' . $vehicle->wheel_size) : '--'
        ];
        $features[] = [
            'key' => __('vehicle.wheel_type'),
            'value' => $vehicle->wheel_type ? __('vehicle.' . $vehicle->wheel_type) : '--'
        ];
        $features[] = [
            'key' => __('vehicle.sunroof'),
            'value' => $vehicle->sunroof ? __('vehicle.' . $vehicle->sunroof) : '--'
        ];
        if ($vehicle->is_new == false) {
            $features[] = [
                'key' => __('vehicle.selling_by_plate'),
                'value' => $vehicle->selling_by_plate ? __('vehicle.yes') : __('vehicle.no')
            ];
            if ($vehicle->selling_by_plate == true) {
                $features[] = [
                    'key' => __('vehicle.number_plate'),
                    'value' => $vehicle->number_plate ? $vehicle->number_plate : '--'
                ];
            }
        }
//        $features[] = [
//            'key' => __('vehicle.doors_number'),
//            'value' => $vehicle->doors_number
//        ];
//        $features[] = [
//            'key' => __('vehicle.electric_back_door'),
//            'value' => $vehicle->electric_back_door ? __('vehicle.yes') : __('vehicle.no')
//        ];
//        $features[] = [
//            'key' => __('vehicle.start_engine_with_button'),
//            'value' => $vehicle->start_engine_with_button ? __('vehicle.yes') : __('vehicle.no')
//        ];
//        $features[] = [
//            'key' => __('vehicle.seat_adjustment'),
//            'value' => $vehicle->seat_adjustment ? __('vehicle.yes') : __('vehicle.no')
//        ];
//        $features[] = [
//            'key' => __('vehicle.seat_heating_cooling_function'),
//            'value' => $vehicle->seat_heating_cooling_function ? __('vehicle.yes') : __('vehicle.no')
//        ];
//        $features[] = [
//            'key' => __('vehicle.seat_massage_feature'),
//            'value' => $vehicle->seat_massage_feature ? __('vehicle.yes') : __('vehicle.no')
//        ];
//        $features[] = [
//            'key' => __('vehicle.seat_memory_feature'),
//            'value' => $vehicle->seat_memory_feature ? __('vehicle.yes') : __('vehicle.no')
//        ];
//        $features[] = [
//            'key' => __('vehicle.fog_lights'),
//            'value' => $vehicle->fog_lights ? __('vehicle.yes') : __('vehicle.no')
//        ];
//        $features[] = [
//            'key' => __('vehicle.front_lighting'),
//            'value' => __('vehicle.' . $vehicle->front_lighting)
//        ];
        if ($vehicle->is_new == false) {
            $features[] = [
                'key' => __('vehicle.price_is_negotiable'),
                'value' => $vehicle->price_is_negotiable ? __('vehicle.yes') : __('vehicle.no')
            ];
            $features[] = [
                'key' => __('vehicle.location'),
                'value' => $vehicle->location == null ? '--' : $vehicle->location
            ];
        }
        $features[] = [
            'key' => __('vehicle.additional_notes'),
            'value' => $vehicle->additional_notes == null ? '--' : $vehicle->additional_notes
        ];

        return $features;
    }

    public function scopeMyCarsSelection($query)
    {
        return $query->select('id', 'vehicable_id', 'vehicable_type', 'brand_id', 'car_model_id',
            'car_class_id', 'manufacturing_year', 'price', 'vehicle_name', 'wheel_size',
            'number_plate', 'chassis_number', 'battery_size', 'maintenance_history', 'maintenance_history_km',
            'tire_installation_date', 'tire_installation_date_km', 'tire_warranty_expiration_date', 'tire_warranty_expiration_date_km'
            , 'battery_installation_date', 'battery_installation_date_km', 'battery_warranty_expiry_date', 'battery_warranty_expiry_date_km',
            'vehicle_registration_expiry_date', 'vehicle_registration_expiry_date_km', 'vehicle_insurance_expiry_date',
            'vehicle_insurance_expiry_date_km', 'user_vehicle_status', 'traveled_distance', 'created_at', 'availability', 'active');
    }

    public function scopeOverView($query)
    {
        return $query->select('vehicles.id', 'vehicable_id', 'vehicable_type', 'vehicle_type', 'brand_id', 'car_model_id',
            'car_class_id', 'manufacturing_year', 'is_new', 'price', 'user_vehicle_status', 'traveled_distance', 'active_number_of_views', 'number_of_views', 'created_at', 'availability', 'active');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeAvailable($query)
    {
        return $query->where('availability', 1);
    }

    public function scopeSearch($query)
    {
        $query->where(function ($q) {
            if (request()->filled('is_new')) {
                $q->where('is_new', request()->is_new);
            }
        })->when(request()->brand_id, function ($q) {
            return $q->where('brand_id', request()->brand_id);
        })->when(request()->car_model_id, function ($q) {
            return $q->where('car_model_id', request()->car_model_id);
        })->when(request()->car_class_id, function ($q) {
            return $q->where('car_class_id', request()->car_class_id);
        })->when(request()->vehicle_type, function ($q) {
            return $q->where('vehicle_type', 'like', '%' . request()->vehicle_type . '%');
        })->when(request()->manufacturing_year, function ($q) {
            return $q->where('manufacturing_year', request()->manufacturing_year);
        })->when(request()->user_vehicle_status, function ($query) {
            return $query->where('user_vehicle_status', request()->user_vehicle_status);
        });
    }
    //Scopes end

    // accessors & Mutator start
    public function get_offer($discount_card_id)
    {
        return $this->offers()->where('offers.discount_card_id', $discount_card_id)->first();
    }

    public function getDistanceColorAttribute()
    {
        // distance color start [green,orange,red]
        $year = now()->year;
        $manufacturing_year = $this->manufacturing_year;
        $green_distance = 25000.00;
        $orange_distance = 30000.00;

        $number_of_years = $year - (int)$manufacturing_year;
        $traveled_distance = (float)$this->traveled_distance;

        if ($traveled_distance != 0 && $number_of_years != 0) {
            $total_distance_in_year = $traveled_distance / $number_of_years;
            if ($total_distance_in_year <= $green_distance) {
                return '#008000'; //green
            } elseif ($total_distance_in_year > $green_distance && $total_distance_in_year <= $orange_distance) {
                return '#FFA500'; //orange
            } else {
                return '#FF0000'; //red
            }

        } else {
            return '#008000'; //green
        }


        // distance color end
    }

    public function getActive()
    {
        return $this->active == 1 ? __('words.active') : __('words.inactive');
    }

    public function getActiveNumberOfViews()
    {
        return $this->active_number_of_views == 1 ? __('words.active') : __('words.inactive');
    }

    public function getAvailability()
    {
        return $this->availability == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getIsNew()
    {
        return $this->is_new == 1 ? __('vehicle.new') : __('vehicle.used');
    }

    public function getOneImageAttribute()
    {
        $default_image = $this->files()->first();
        return $default_image ? $default_image->path : asset('uploads/default_image.png');
    }

    public function getTrafficPdf()
    {
        $default_image = $this->files()->where('type', 'traffic_pdf')->first();
        return $default_image ? $default_image->path : '';
    }

    public function getNameAttribute()
    {
        $brand = $this->brand ? $this->brand->name : '';
        $car_model = $this->car_model ? $this->car_model->name : '';
        $car_class = $this->car_class ? $this->car_class->name : '';
        $manufacturing_year = $this->manufacturing_year ? $this->manufacturing_year : '';

        $name = $brand . ' - ' . $car_model . ' - ' . $manufacturing_year . ' - ' . $car_class;

        return $name;

    }

    public function getPriceAfterDiscountAttribute()
    {
        if ($this->discount != null) {
            $discount_type = $this->discount_type;
            $percentage_value = ((100 - $this->discount) / 100);
            if ($discount_type == 'percentage') {
                return $price_after_discount = number_format($this->price * $percentage_value,2);
            } else {
                return $price_after_discount = number_format($this->price - $this->discount,2);

            }
        }
        return 0;
    }

    public function getPriceInMowaterCard()
    {
        $discount_type = $this->discount_type;
        $percentage_value = ((100 - $this->discount) / 100);
        if ($discount_type == 'percentage') {
            return $this->price * $percentage_value;
        } else {
            return $this->price - $this->discount;

        }
    }
    // accessors & Mutator end

}
