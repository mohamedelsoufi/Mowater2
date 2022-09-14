<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Broker;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class BrokerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name_ar = ['مارينا لوسطاء التأمبن', 'ماسترز لوسطاء التأمين', 'فنتشيرتش فارس ليمتد'];

        $name_en = ['Marina Insurance Brokers', 'Masters Insurance Brokers LLC', 'Fenchurch Faris Limited'];

        $description_en = ['The United Insurance Company was established in 1986 with a capital of one million Bahraini dinars. The company carries out insurance business on all types of cars that cross the King Fahd Causeway in accordance with the insurance laws in force in the Kingdom of Bahrain and in the signatory countries to the Unified Insurance Card Agreement on the movement of cars across the Arab countries, which is the company The only one that has this feature.', 'The United Insurance Company was established in 1986 with a capital of one million Bahraini dinars. The company carries out insurance business on all types of cars that cross the King Fahd Causeway in accordance with the insurance laws in force in the Kingdom of Bahrain and in the signatory countries to the Unified Insurance Card Agreement on the movement of cars across the Arab countries, which is the company The only one that has this feature.', 'The United Insurance Company was established in 1986 with a capital of one million Bahraini dinars. The company carries out insurance business on all types of cars that cross the King Fahd Causeway in accordance with the insurance laws in force in the Kingdom of Bahrain and in the signatory countries to the Unified Insurance Card Agreement on the movement of cars across the Arab countries, which is the company The only one that has this feature.'];

        $description_ar = ['تأسست الشركة المتحدة للتأمين في عام 1986 برأسمال وقدره مليون دينار بحريني, تمارس الشركة أعمال التأمين على جميع أنواع السيارات التي تعبر جسر الملك فهد وفقاً لقوانين التأمين النافذة في مملكة البحرين وفي الدول الموقعة على اتفاقية بطاقة التأمين الموحدة عن سير السيارات عبر البلاد العربية, وهي الشركة الوحيدة التي تنفرد بهذه الخاصية.', 'تأسست الشركة المتحدة للتأمين في عام 1986 برأسمال وقدره مليون دينار بحريني, تمارس الشركة أعمال التأمين على جميع أنواع السيارات التي تعبر جسر الملك فهد وفقاً لقوانين التأمين النافذة في مملكة البحرين وفي الدول الموقعة على اتفاقية بطاقة التأمين الموحدة عن سير السيارات عبر البلاد العربية, وهي الشركة الوحيدة التي تنفرد بهذه الخاصية.', 'تأسست الشركة المتحدة للتأمين في عام 1986 برأسمال وقدره مليون دينار بحريني, تمارس الشركة أعمال التأمين على جميع أنواع السيارات التي تعبر جسر الملك فهد وفقاً لقوانين التأمين النافذة في مملكة البحرين وفي الدول الموقعة على اتفاقية بطاقة التأمين الموحدة عن سير السيارات عبر البلاد العربية, وهي الشركة الوحيدة التي تنفرد بهذه الخاصية.'];

        $requirements_ar = ['فيما يتعلق بالمسؤوليات المدنية ضد الغير تلتزم الشركة بقانون التأمين الإلزامي في الدول المبينة في الشهادة وحسب ما هي موضحة في صفحة تأمين البطاقة البرتقالية.
يلتزم المؤمن له بالإبلاغ الفوري للجهة الممثلة للشركة المتحدة للتأمين في بلد الحادث ( والمشار إليها في قسم اتصل بنا ) لدى وقوعه ليتسنى لها اتخاذ الإجراءات اللازمة في حينه وأن لا يقوم بأي تسوية تتعلق بالحادث دون الرجوع إليها.
يسقط حق المؤمن له في التعويض ويحق للشركة المتحدة للتأمين أو من يمثلها أن يرجع على المؤمن له بما يكون قد أداه من تعويض', 'فيما يتعلق بالمسؤوليات المدنية ضد الغير تلتزم الشركة بقانون التأمين الإلزامي في الدول المبينة في الشهادة وحسب ما هي موضحة في صفحة تأمين البطاقة البرتقالية.
يلتزم المؤمن له بالإبلاغ الفوري للجهة الممثلة للشركة المتحدة للتأمين في بلد الحادث ( والمشار إليها في قسم اتصل بنا ) لدى وقوعه ليتسنى لها اتخاذ الإجراءات اللازمة في حينه وأن لا يقوم بأي تسوية تتعلق بالحادث دون الرجوع إليها.
يسقط حق المؤمن له في التعويض ويحق للشركة المتحدة للتأمين أو من يمثلها أن يرجع على المؤمن له بما يكون قد أداه من تعويض                  ', 'فيما يتعلق بالمسؤوليات المدنية ضد الغير تلتزم الشركة بقانون التأمين الإلزامي في الدول المبينة في الشهادة وحسب ما هي موضحة في صفحة تأمين البطاقة البرتقالية.
يلتزم المؤمن له بالإبلاغ الفوري للجهة الممثلة للشركة المتحدة للتأمين في بلد الحادث ( والمشار إليها في قسم اتصل بنا ) لدى وقوعه ليتسنى لها اتخاذ الإجراءات اللازمة في حينه وأن لا يقوم بأي تسوية تتعلق بالحادث دون الرجوع إليها.
يسقط حق المؤمن له في التعويض ويحق للشركة المتحدة للتأمين أو من يمثلها أن يرجع على المؤمن له بما يكون قد أداه من تعويض              '];

        $requirements_en = ['With regard to civil liabilities against third parties, the company complies with the mandatory insurance law in the countries indicated in the certificate and as indicated on the orange card insurance page.
The insured is obligated to immediately inform the entity representing the United Insurance Company in the country of the accident (referred to in the Contact Us section) when it occurs so that it can take the necessary measures at the time and not to make any settlement related to the accident without referring to it.
The right of the insured to compensation shall be forfeited, and the United Insurance Company or its representative shall have the right to have recourse against the insured for the compensation he may have paid.', 'With regard to civil liabilities against third parties, the company complies with the mandatory insurance law in the countries indicated in the certificate and as indicated on the orange card insurance page.
                The insured is obligated to immediately inform the entity representing the United Insurance Company in the country of the accident (referred to in the Contact Us section) when it occurs so that it can take the necessary measures at the time and not to make any settlement related to the accident without referring to it.
                The right of the insured to compensation shall be forfeited, and the United Insurance Company or its representative shall have the right to have recourse against the insured for the compensation he may have paid.', 'With regard to civil liabilities against third parties, the company complies with the mandatory insurance law in the countries indicated in the certificate and as indicated on the orange card insurance page.
                The insured is obligated to immediately inform the entity representing the United Insurance Company in the country of the accident (referred to in the Contact Us section) when it occurs so that it can take the necessary measures at the time and not to make any settlement related to the accident without referring to it.
                The right of the insured to compensation shall be forfeited, and the United Insurance Company or its representative shall have the right to have recourse against the insured for the compensation he may have paid.'];

        $logo = ['seeder/logobroker.jpg', 'seeder/logobroker2.jpg', 'seeder/logobroker3.jpg'];
        $users = ['broker1@gmail.com', 'broker2@gmail.com', 'broker3@gmail.com'];
        $law_en = ['Inform the insurance company of the accident caused by the vehicle', 'Submit to the insurance company all papers and documents related to the accidentYou should be in bahrain'];
        $law_ar = ['إبلاغ شركة التأمين بالحادث الذى تسببت فيه المركبة', 'قدم إلى شركة التأمين جميع الأوراق والمستندات المتعلقة بالحادث'];
        $phone = ['3366 7714', '1311 2262', '1725 3470', '1773 2426', '3838 7468', ''];
        $year_founded = [1990, 1995, 1980, 1991, 1985, 1996, 1997, 1998, 1984];


        for ($counter = 0; $counter < 3; $counter++) {
            $broker = Broker::create([
                'name_ar' => $name_ar[$counter],
                'name_en' => $name_en[$counter],
                'description_en' => $description_en[$counter],
                'description_ar' => $description_ar[$counter],
//                'requirements_ar' => $requirements_ar[$counter],
//                'requirements_en' => $requirements_en[$counter],
                'tax_number' => 'B' . rand(1000, 1000000),
                'country_id' => 1,
                'city_id' => 1,
                'area_id' => 2,
                'logo' => $logo[$counter],
                'year_founded' => $year_founded[array_rand($year_founded)],
            ]);
            $broker->discount_cards()->attach(1);

            $payment_methods = PaymentMethod::pluck('id');

            $broker->phones()->create([
                'country_code' => '+973',
                'phone' => $phone[array_rand($phone)],
                'title_en' => $name_en[$counter],
                'title_ar' => $name_en[$counter]
            ]);

            $broker->payment_methods()->attach($payment_methods);

            $broker->laws()->create([
                'law_en' => $law_en[array_rand($law_en)],
                'law_ar' => $law_ar[array_rand($law_ar)],
            ]);

            $broker->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '+9955563228',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

            $broker->work_time()->create([
                'from' => '09:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sun,Mon,Tue,Wed,Thu',
            ]);
            $broker->organization_users()->create([
                'user_name' => 'Broker' . $counter,
                'email' => $users[$counter],
                'password' => "123456",
            ]);


            $packages = $broker->packages;
            foreach ($packages as $package){
                $package->offers()->create([
                    'discount_card_id' => 1,
                    'discount_type' => 'percentage',
                    'discount_value' => 88,
                    'number_of_uses_times' => 'specific_number',
                    'specific_number' => 2,
                    'notes' => 'خصم 88 % على التالي',
                ]);
            }
            $package_ids = $broker->packages()->pluck('id');

            for ($b = 0; $b < 2; $b++) {
                $branch = $broker->branches()->create([
                    'name_en' => 'Branch ' . $b,
                    'name_ar' => 'فرع ' . $b,
                    'area_id' => Area::first()->id,
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
                $branch->organization_users()->create([
                    'user_name' => 'Broker branch user ' . $b,
                    'email' => 'insurance_ba' . $b . $counter . '@gmail.com',
                    'password' => "123456",
                ]);

                $branch->available_features()->attach($package_ids);
                $branch->payment_methods()->attach($payment_methods);
                $branch->phones()->create([
                    'country_code' => '+973',
                    'phone' => $phone[array_rand($phone)],
                    'title_en' => $name_en[$b],
                    'title_ar' => $name_en[$b]
                ]);
            }
        }

    }
}
