<?php


namespace App\Traits\Files;


use App\Models\File;
use Illuminate\Support\Facades\Storage;

trait HasFile
{
    public function file()
    {
        return $this->morphOne('App\Models\File', 'model');
    }

    public function updateImage()
    {
        if (request()->hasFile('image')) {
            //Delete the old image from the public images folder

            if ($this->file && is_object($this->file)) {
                Storage::delete($this->file->getRawOriginal('path'));
                //Delete the old image from the images table
                $this->file()->delete();

            }

            //Store the new image in public images folder & set the path in $image variable
            $image = request()->image->store('images');
            //Create a new user's image in images table
            $this->file()->create(['path' => $image]);
        }

        if (request()->hasFile('flag')) {
            if ($this->file && is_object($this->file)) {
                Storage::delete($this->file->getRawOriginal('path'));
            }

            //Delete the old image from the images table
            $this->file()->delete();
            //Store the new image in public images folder & set the path in $image variable
            $image = request()->flag->store('countries');
            //Create a new user's image in images table
            $this->file()->create(['path' => $image, 'type' => 'country_image']);
        }

        if (request()->hasFile('file_url')) {
            if ($this->file && is_object($this->file)) {
                Storage::delete($this->file->getRawOriginal('path'));
            }

            //Delete the old image from the images table
            $this->file()->delete();
            //Store the new image in public images folder & set the path in $image variable
            $image = request()->file_url->store('sections');
            //Create a new user's image in images table
            $this->file()->create(['path' => $image, 'type' => 'section_image']);
        }
    }

    public function uploadImage()
    {
        if (request()->hasFile('image')) {
            //Store the new image in public images folder & set the path in $image variable
            $image = request()->image->store('images');
            //Create a new user's image in images table
            $this->file()->create(['path' => $image]);
        }

        if (request()->hasFile('flag')) {
            //Store the new image in public images folder & set the path in $image variable
            $image = request()->flag->store('countries');
            //Create a new user's image in images table
            $this->file()->create(['path' => $image, 'type' => 'country_image']);
        }
    }

    public function deleteImage()
    {
        if ($this->file) {
            if ($this->file && is_object($this->file)) {
                Storage::delete($this->file->getRawOriginal('path'));
                //Storage::delete($this->file->path);
            }
            //Delete image from images table
            $this->file()->delete();
        }
    }

    public function getFileUrlAttribute()
    {
        return $this->file ?  $this->file->path : asset('uploads/default_image.png');
    }
}
