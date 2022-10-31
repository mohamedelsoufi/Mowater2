<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $role = Role::create([
          'name_en' => 'super admin',
          'name_ar' => 'المدير المتميز',
          'display_name_ar' => 'المدير المتميز',
          'display_name_en' => 'super admin',
          'description_ar' => 'له جميع الصلاحيات',
          'description_en' => 'has all permissions',
          'is_super' => 1,
      ]);

      foreach (\config('laratrust_seeder.roles') as $key => $values){
          foreach ($values as $value){
              $permission = Permission::create([
                  'name' => $value . '-' . $key,
                  'display_name_ar' => __('words.'.$value) . ' ' . __('words.'.$key),
                  'display_name_en' => $value . ' ' . $key,
                  'description_ar' => __('words.'.$value) . ' ' . __('words.'.$key),
                  'description_en' => $value . ' ' . $key,
              ]);
              $role->attachPermissions([$permission]);
          }
      }
    }
}
