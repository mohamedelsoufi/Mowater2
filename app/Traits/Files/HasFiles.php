<?php

namespace App\Traits\Files;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

trait HasFiles
{
    public function files()
    {
        return $this->morphMany(File::class, 'model');
    }

    public function upload_car_for_sale_Images()
    {
        if (request()->has('front_side_image')) {
            $file = request()->front_side_image->store('vehicles/for_sale');

            $this->files()->create(['path' => $file, 'type' => 'front_side_image']);
        }

        if (request()->has('back_side_image')) {
            $file = request()->back_side_image->store('vehicles/for_sale');

            $this->files()->create(['path' => $file, 'type' => 'back_side_image']);
        }

        if (request()->has('right_side_image')) {
            $file = request()->right_side_image->store('vehicles/for_sale');

            $this->files()->create(['path' => $file, 'type' => 'right_side_image']);
        }

        if (request()->has('left_side_image')) {
            $file = request()->left_side_image->store('vehicles/for_sale');

            $this->files()->create(['path' => $file, 'type' => 'left_side_image']);
        }

        if (request()->has('inside_vehicle_image')) {
            $file = request()->inside_vehicle_image->store('vehicles/for_sale');

            $this->files()->create(['path' => $file, 'type' => 'inside_vehicle_image']);
        }

        if (request()->has('vehicle_dashboard_image')) {
            $file = request()->vehicle_dashboard_image->store('vehicles/for_sale');

            $this->files()->create(['path' => $file, 'type' => 'vehicle_dashboard_image']);
        }

        if (request()->has('traffic_pdf')) {
            $file = request()->traffic_pdf->store('vehicles/for_sale');

            $this->files()->create(['path' => $file, 'type' => 'traffic_pdf']);
        }

        if (request()->has('images')) {
            foreach (request()->images as $image) {
                $file = $image->store('vehicles/profile_car');
                $this->files()->create(['path' => $file, 'type' => 'profile_car']);
            }
        }

    }

    public function update_car_for_sale_Images()
    {
        if (request()->has('inside_vehicle_image')) {
            $file = request()->inside_vehicle_image->store('vehicles/for_sale');

            $this->files()->create(['path' => $file, 'type' => 'inside_vehicle_image']);
        }

        if (request()->has('front_side_image')) {
            $file = request()->front_side_image->store('vehicles/for_sale');

            $this->files()->create(['path' => $file, 'type' => 'front_side_image']);
        }

        if (request()->has('back_side_image')) {
            $file = request()->back_side_image->store('vehicles/for_sale');

            $this->files()->create(['path' => $file, 'type' => 'back_side_image']);
        }

        if (request()->has('right_side_image')) {
            $file = request()->right_side_image->store('vehicles/for_sale');

            $this->files()->create(['path' => $file, 'type' => 'right_side_image']);
        }

        if (request()->has('left_side_image')) {
            $file = request()->left_side_image->store('vehicles/for_sale');

            $this->files()->create(['path' => $file, 'type' => 'left_side_image']);
        }

        if (request()->has('vehicle_dashboard_image')) {
            $file = request()->vehicle_dashboard_image->store('vehicles/for_sale');

            $this->files()->create(['path' => $file, 'type' => 'vehicle_dashboard_image']);
        }

        if (request()->has('traffic_pdf')) {
            $file = request()->traffic_pdf->store('vehicles/for_sale');

            $this->files()->create(['path' => $file, 'type' => 'traffic_pdf']);
        }

        $folder_name = 'vehicles/profile_car';
        if (request()->has('images')) {
            if (request()->filled('folder_name')) {
                $folder_name = request()->folder_name;
            }

            foreach (request()->images as $image) {
                $file = $image->store($folder_name);
                $this->files()->create(['path' => $file, 'type' => 'profile_car']);
            }
        }

        if (request()->has('deleted_images')) {

            foreach (request()->deleted_images as $image) {
                $image_path = public_path('uploads/');


                $img = File::findOrFail($image);

                if (\Illuminate\Support\Facades\File::exists($image_path)) {
//                    return $image_path . $img->getRawOriginal('path');
                    \Illuminate\Support\Facades\File::delete($image_path . $img->getRawOriginal('path'));
                }
                \Illuminate\Support\Facades\File::delete($image_path . $img->path);
                $img->delete();
            }
        }

    }

    public function updateAdminUsedVehicle()
    {
        if (request()->hasFile('front_side_image')) {
            $img = $this->files()->where('type', 'front_side_image')->first();
            Storage::delete($img->getRawOriginal('path'));
            $img->delete();
            $image = request()->front_side_image->store('vehicles/for_sale');
            $this->files()->create(['path' => $image, 'type' => 'front_side_image']);
        }
        if (request()->hasFile('back_side_image')) {
            $img = $this->files()->where('type', 'back_side_image')->first();
            Storage::delete($img->getRawOriginal('path'));
            $img->delete();
            $image = request()->back_side_image->store('vehicles/for_sale');
            $this->files()->create(['path' => $image, 'type' => 'back_side_image']);
        }
        if (request()->hasFile('right_side_image')) {
            $img = $this->files()->where('type', 'right_side_image')->first();
            Storage::delete($img->getRawOriginal('path'));
            $img->delete();
            $image = request()->right_side_image->store('vehicles/for_sale');
            $this->files()->create(['path' => $image, 'type' => 'right_side_image']);
        }
        if (request()->hasFile('left_side_image')) {
            $img = $this->files()->where('type', 'left_side_image')->first();
            Storage::delete($img->getRawOriginal('path'));
            $img->delete();
            $image = request()->left_side_image->store('vehicles/for_sale');
            $this->files()->create(['path' => $image, 'type' => 'left_side_image']);
        }
        if (request()->hasFile('vehicle_dashboard_image')) {
            $img = $this->files()->where('type', 'vehicle_dashboard_image')->first();
            Storage::delete($img->getRawOriginal('path'));
            $img->delete();
            $image = request()->vehicle_dashboard_image->store('vehicles/for_sale');
            $this->files()->create(['path' => $image, 'type' => 'vehicle_dashboard_image']);
        }
        if (request()->hasFile('inside_vehicle_image')) {
            $img = $this->files()->where('type', 'inside_vehicle_image')->first();
            Storage::delete($img->getRawOriginal('path'));
            $img->delete();
            $image = request()->inside_vehicle_image->store('vehicles/for_sale');
            $this->files()->create(['path' => $image, 'type' => 'inside_vehicle_image']);
        }
        if (request()->hasFile('traffic_pdf')) {
            $img = $this->files()->where('type', 'traffic_pdf')->first();
            Storage::delete($img->getRawOriginal('path'));
            $img->delete();
            $image = request()->traffic_pdf->store('vehicles/for_sale');
            $this->files()->create(['path' => $image, 'type' => 'traffic_pdf']);
        }
    }

    public function upload_reserve_vehicle_images()
    {
        if (request()->has('personal_ID')) {
            $file = request()->personal_ID->store('vehicles/reserve_vehicle');

            $this->files()->create(['path' => $file, 'type' => 'personal_ID']);
        }

        if (request()->has('driving_license')) {
            $file = request()->driving_license->store('vehicles/reserve_vehicle');

            $this->files()->create(['path' => $file, 'type' => 'driving_license']);
        }

        if (request()->has('driving_license_for_test')) {
            $file = request()->driving_license_for_test->store('vehicles/test_drive');

            $this->files()->create(['path' => $file, 'type' => 'driving_license_for_test']);
        }

        if (request()->has('personal_ID_for_special')) {
            $file = request()->personal_ID_for_special->store('special_numbers/reservations');

            $this->files()->create(['path' => $file, 'type' => 'personal_ID_for_special']);
        }

        if (request()->has('driving_license_for_special')) {
            $file = request()->driving_license_for_special->store('special_numbers/reservations');

            $this->files()->create(['path' => $file, 'type' => 'driving_license_for_special']);
        }

        if (request()->has('driving_license_for_rental')) {
            $file = request()->driving_license_for_rental->store('rental_offices/reservations');

            $this->files()->create(['path' => $file, 'type' => 'driving_license_for_rental']);
        }

        if (request()->has('personal_ID_for_rental')) {
            $file = request()->personal_ID_for_rental->store('rental_offices/reservations');

            $this->files()->create(['path' => $file, 'type' => 'personal_ID_for_rental']);
        }

        //
        if (request()->has('smart_card_front')) {
            $file = request()->smart_card_front->store('insurance_companies/reservations');

            $this->files()->create(['path' => $file, 'type' => 'smart_card_front']);
        }

        if (request()->has('smart_card_back')) {
            $file = request()->smart_card_back->store('insurance_companies/reservations');

            $this->files()->create(['path' => $file, 'type' => 'smart_card_back']);
        }

        if (request()->has('vehicle_ownership_front')) {
            $file = request()->vehicle_ownership_front->store('insurance_companies/reservations');

            $this->files()->create(['path' => $file, 'type' => 'vehicle_ownership_front']);
        }

        if (request()->has('vehicle_ownership_back')) {
            $file = request()->vehicle_ownership_back->store('insurance_companies/reservations');

            $this->files()->create(['path' => $file, 'type' => 'vehicle_ownership_back']);
        }

        if (request()->has('no_accident_certificate')) {
            $file = request()->no_accident_certificate->store('insurance_companies/reservations');

            $this->files()->create(['path' => $file, 'type' => 'no_accident_certificate']);
        }
//
        if (request()->has('driving_license_for_broker')) {
            $file = request()->driving_license_for_broker->store('broker/reservations');

            $this->files()->create(['path' => $file, 'type' => 'driving_license_for_broker']);
        }

        if (request()->has('vehicle_ownership_for_broker')) {
            $file = request()->vehicle_ownership_for_broker->store('broker/reservations');

            $this->files()->create(['path' => $file, 'type' => 'vehicle_ownership_for_broker']);
        }

        if (request()->has('no_accident_certificate_for_broker')) {
            $file = request()->no_accident_certificate_for_broker->store('broker/reservations');

            $this->files()->create(['path' => $file, 'type' => 'no_accident_certificate_for_broker']);
        }


        if (request()->has('image_ID')) {
            $file = request()->image_ID->store('rental_reservation/IDs');

            $this->files()->create(['path' => $file, 'type' => 'rental_reservation_ID']);
        }

    }

    public function upload_request_traffic_images()
    {
        if (request()->has('smart_card_id')) {
            $file = request()->smart_card_id->store('traffic_clearing_office/requests');

            $this->files()->create(['path' => $file, 'type' => 'smart_card_id']);
        }

        if (request()->has('vehicle_ownership')) {
            $file = request()->vehicle_ownership->store('traffic_clearing_office/requests');

            $this->files()->create(['path' => $file, 'type' => 'vehicle_ownership']);
        }

        if (request()->has('disclaimer_image')) {
            $file = request()->disclaimer_image->store('traffic_clearing_office/requests');

            $this->files()->create(['path' => $file, 'type' => 'disclaimer_image']);
        }
    }

    public function updateImages()
    {

        $folder_name = 'images';
        if (request()->has('images')) {
            if (request()->filled('folder_name')) {
                $folder_name = request()->folder_name;
            }

            foreach (request()->images as $image) {
                $file = $image->store($folder_name);
                $this->files()->create(['path' => $file]);
            }
        }
        if (request()->has('deleted_images')) {

            foreach (request()->deleted_images as $image) {
                $image_path = public_path('uploads/');


                $img = File::findOrFail($image);
                if (\Illuminate\Support\Facades\File::exists($image_path)) {
//                    \Illuminate\Support\Facades\File::delete($image_path . $img->path);
                    Storage::delete($img->getRawOriginal('path'));
                }
                \Illuminate\Support\Facades\File::delete($image_path . $img->path);
                $img->delete();
            }
        }

    }

    public function updateSliderImage()
    {
        if (request()->has('slider_file')) {
            foreach (request()->slider_file as $file) {
                $file_name = $file->store('sliders');
                $this->files()->create(['path' => $file_name, 'type' => request()->type]);
            }
        }
        if (request()->has('image')) {
            $image = request()->image;
            $file = $image->store('images');
            $this->files()->create(['path' => $file]);

        }
        if (request()->has('deleted_images')) {
            foreach (request()->deleted_images as $image) {
                $image_path = public_path('uploads/');


                $img = File::findOrFail($image);
                if (\Illuminate\Support\Facades\File::exists($image_path)) {
                    \Illuminate\Support\Facades\File::delete($image_path . $img->path);
                }
                \Illuminate\Support\Facades\File::delete($image_path . $img->path);
                $img->delete();
            }
        }

    }

    public function uploadImages()
    {
        $folder_name = 'images';
        if (request()->has('images')) {
            if (request()->filled('folder_name')) {
                $folder_name = request()->folder_name;
            }
            foreach (request()->images as $image) {
                $file = $image->store($folder_name);

                $this->files()->create(['path' => $file]);

            }
        }

    }

    public function uploadServiceImages()
    {

        if (request()->has('images')) {
            foreach (request()->images as $image) {
                $file = $image->store('services');

                $this->files()->create(['path' => $file]);

            }
        }

    }

    public function deleteImages()
    {
        //return $this->files;
        foreach ($this->files as $image) {
            Storage::delete($image->getRawOriginal('path'));
        }

        //Delete image from images table
        $this->files()->delete();
    }
}
