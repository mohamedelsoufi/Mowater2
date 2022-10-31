<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\City;
use App\Models\CoverageType;
use App\Models\Feature;
use App\Models\InsuranceCompany;
use App\Models\PaymentMethod;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class InsuranceCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $logos = ['m40.png', 'm41.png', 'm42.jpg', 'm43.jpeg', 'm44.jpg', 'm45.png', 'm46.png', 'm47.png', 'm48.png'];
        $users = ['c1@gmail.com', 'c2@gmail.com', 'c3@gmail.com', 'c4@gmail.com', 'c5@gmail.com', 'c6@gmail.com', 'c7@gmail.com', 'c8@gmail.com', 'c9@gmail.com'];
        $names = ['شركة سنيك للتأمين', 'المتحدة للتأمين', 'الأهلية للتأمين', 'سوليدرتي البحرين', 'مجموعة الخليج للتأمين', 'جمعية التأمين ابحرينية', 'شركة التأمين للوطنية', 'الدرع العربي للتأمين', 'تآزر',];
        $year_founded = [1990, 1995, 1980, 1991, 1985, 1996, 1997, 1998, 1984];
        $phone = ['3366 7714', '1311 2262', '1725 3470', '1773 2426', '3838 7468', ''];

        $law_en = ['Inform the insurance company of the accident caused by the vehicle', 'Submit to the insurance company all papers and documents related to the accidentYou should be in bahrain'];
        $law_ar = ['إبلاغ شركة التأمين بالحادث الذى تسببت فيه المركبة', 'قدم إلى شركة التأمين جميع الأوراق والمستندات المتعلقة بالحادث'];


        for ($counter = 0; $counter < 9; $counter++) {
            $insurance_company1 = InsuranceCompany::create([
                'name_en' => 'Company' . $counter,
                'name_ar' => $names[$counter],
                'description_ar' => 'تأسست الشركة المتحدة للتأمين في عام 1986 برأسمال وقدره مليون دينار بحريني, تمارس الشركة أعمال التأمين على جميع أنواع السيارات التي تعبر جسر الملك فهد وفقاً لقوانين التأمين النافذة في مملكة البحرين وفي الدول الموقعة على اتفاقية بطاقة التأمين الموحدة عن سير السيارات عبر البلاد العربية, وهي الشركة الوحيدة التي تنفرد بهذه الخاصية. وللشركة أن تمارس خارج البحرين جميع أنواع التأمين مثل تأمين السيارات, التأمين على الحياة والتأمين ضد الحريق والتأمين ضد الحوادث وضد أخطار النقل البري والنهري والبحري والجوي والصناعي',
                'description_en' => 'The United Insurance Company was established in 1986 with a capital of one million Bahraini dinars. The company carries out insurance business on all types of cars that cross the King Fahd Causeway in accordance with the insurance laws in force in the Kingdom of Bahrain and in the signatory countries to the Unified Insurance Card Agreement on the movement of cars across the Arab countries, which is the company The only one that has this feature. The company may exercise outside Bahrain all types of insurance such as car insurance, life insurance, fire insurance, accident insurance and against the dangers of land, river, marine, air and industrial transport.',
                'tax_number' => 'w' . rand(1000, 1000000),
                'logo' => 'seeder/' . $logos[$counter],
                'country_id' => '1',
                'city_id' => '1',
                'area_id' => '1',
                'year_founded' => $year_founded[array_rand($year_founded)],
            ]);

            $payment_methods = PaymentMethod::pluck('id');
            $insurance_company1->payment_methods()->attach($payment_methods);

            $insurance_company1->laws()->create([
                'law_en' => $law_en[array_rand($law_en)],
                'law_ar' => $law_ar[array_rand($law_ar)],
            ]);

            $insurance_company1->phones()->create([
                'country_code' => '+973',
                'phone' => $phone[array_rand($phone)],
                'title_en' => $names[$counter],
                'title_ar' => $names[$counter]
            ]);

            $insurance_company1->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '01124579105',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

            $insurance_company1->work_time()->create([
                'from' => '09:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sun,Mon,Tue,Wed,Thu',
            ]);


            $org_user = $insurance_company1->organization_users()->create([
                'user_name' => 'insurance company user ' . $counter,
                'email' => $users[$counter],
                'password' => "123456",
            ]);

            $org_role = $insurance_company1->roles()->create([
                'name_en' => 'Organization super admin' . ' ' . $insurance_company1->name_en,
                'name_ar' => 'صلاحية المدير المتميز' . ' ' . $insurance_company1->name_ar,
                'display_name_ar' => 'صلاحية المدير المتميز' . ' ' . $insurance_company1->name_ar,
                'display_name_en' => 'Organization super admin' . ' ' . $insurance_company1->name_en,
                'description_ar' => 'له جميع الصلاحيات',
                'description_en' => 'has all permissions',
                'is_super' => 1,
            ]);

            foreach (\config('laratrust_seeder.org_roles') as $key => $values) {
                foreach ($values as $value) {
                    $permission = Permission::create([
                        'name' => $value . '-' . $key . '-' . $insurance_company1->name_en,
                        'display_name_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $insurance_company1->name_ar,
                        'display_name_en' => $value . ' ' . $key . ' ' . $insurance_company1->name_en,
                        'description_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $insurance_company1->name_ar,
                        'description_en' => $value . ' ' . $key . ' ' . $insurance_company1->name_en,
                    ]);
                    $org_role->attachPermissions([$permission]);
                }
            }

            $org_user->attachRole($org_role);

            $insurance_company1->discount_cards()->attach(1);

            $companies = InsuranceCompany::get();
            $coverage = CoverageType::pluck('id')->toArray();
            $features = Feature::inRandomOrder()->take(7)->pluck('id');
            $package_name_en = ['golden package', 'silver package', 'bronze package'];
            $package_name_ar = ['الباقة الذهبية', 'الباقة الفضية', 'الباقة البرونزية'];
            $discount_value = ['', '10', '20', '', '30'];

            for ($c = 0; $c < count($package_name_en); $c++) {
                $discount = $discount_value[array_rand($discount_value)];
                $dis_type = ['percentage', 'amount'];
                $n_package = $insurance_company1->packages()->create([
                    'name_en' => $package_name_en[$c],
                    'name_ar' => $package_name_ar[$c],
                    'price' => 880,
                    'discount' => $discount,
                    'discount_type' => $discount != '' ? $dis_type[array_rand($dis_type)] : '',
                    'coverage_type_id' => $coverage[array_rand($coverage)]
                ]);
                $n_package->features()->attach($features);
            }
            $insurancePackages = $insurance_company1->packages()->where('discount_type', '')->get();
            foreach ($insurancePackages as $package) {
                $package->offers()->create([
                    'discount_card_id' => 1,
                    'discount_type' => 'percentage',
                    'discount_value' => 77,
                    'number_of_uses_times' => 'specific_number',
                    'specific_number' => 2,
                    'notes' => 'خصم 77 % على التالي',
                ]);
            }


            $package_ids = $insurance_company1->packages()->pluck('id');
            for ($b = 0; $b < 2; $b++) {
                $city = City::inRandomOrder()->first()->id;
                $branch = $insurance_company1->branches()->create([
                    'name_en' => $insurance_company1->name_en . ' Branch ' . $b,
                    'name_ar' => $insurance_company1->name_ar . ' فرع ' . $b,
                    'country_id' => 1,
                    'city_id' => $city,
                    'area_id' => Area::where('city_id', $city)->first()->id,
                    'address_en' => 'Branch Address ' . $b,
                    'address_ar' => 'عنوان الفرع ' . $b,
                    'category_id' => null,
                    'longitude' => '26.1110447',
                    'latitude' => '50.6207331',
                ]);
                $branch->work_time()->create([
                    'from' => '9:00',
                    'to' => '18:00',
                    'duration' => 30,
                    'days' => 'Sun,Mon,Tue,Wed,Thu'
                ]);
                $branch->contact()->create([
                    'facebook_link' => 'https://www.google.com/',
                    'whatsapp_number' => '01124579105',
                    'country_code' => '+973',
                    'phone' => '01124579105',
                    'website' => 'https://www.google.com/',
                    'instagram_link' => 'https://www.google.com/',
                ]);
                $branch_user = $branch->organization_users()->create([
                    'user_name' => 'Insurance company branch user ' . $b,
                    'email' => 'broker_ba' . $b . $counter . '@gmail.com',
                    'password' => "123456",
                ]);

                $branch_role = $branch->roles()->create([
                    'name_en' => 'super admin' . ' ' . $insurance_company1->name_en . ' ' . $branch->name_en,
                    'name_ar' => 'صلاحية المدير المتميز' . ' ' . $insurance_company1->name_ar . ' ' . $branch->name_ar,
                    'display_name_ar' => 'صلاحية المدير المتميز' . ' ' . $branch->name_ar,
                    'display_name_en' => 'super admin' . ' ' . $branch->name_en,
                    'description_ar' => 'له جميع الصلاحيات',
                    'description_en' => 'has all permissions',
                    'is_super' => 1,
                ]);

                foreach (\config('laratrust_seeder.org_roles') as $key => $values) {
                    foreach ($values as $value) {
                        $permission = Permission::create([
                            'name' => $value . '-' . $key . '-' . $branch->name_en,
                            'display_name_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $branch->name_ar,
                            'display_name_en' => $value . ' ' . $key . ' ' . $branch->name_en,
                            'description_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $branch->name_ar,
                            'description_en' => $value . ' ' . $key . ' ' . $branch->name_en,
                        ]);
                        $branch_role->attachPermissions([$permission]);
                    }
                }

                $branch_user->attachRole($branch_role);

                $branch->available_features()->attach($package_ids);
                $branch->payment_methods()->attach($payment_methods);
                $branch->phones()->create([
                    'country_code' => '+973',
                    'phone' => $phone[array_rand($phone)],
                    'title_en' => $branch->name_en,
                    'title_ar' => $branch->name_ar
                ]);
            }
        }

    }
}
