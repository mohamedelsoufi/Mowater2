<?php

namespace Database\seeders;

use App\Models\Area;
use App\Models\Brand;
use App\Models\CarClass;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\City;
use App\Models\DeliveryMan;
use App\Models\DeliveryManCategory;
use App\Models\PaymentMethod;
use App\Models\Section;
use Illuminate\Database\Seeder;

class   DeliverySeeder extends Seeder
{

    public function run()
    {
        $brands = Brand::pluck('id')->toArray();
        $car_classes = CarClass::pluck('id')->toArray();
        $brand = $brands[array_rand($brands)];
        $car_model = CarModel::where('brand_id', $brand)->first();
        $vehicle_images = ['seeder/v1.jpg', 'seeder/sliders/second/9.jpg', 'seeder/v2.jpg', 'seeder/sliders/second/10.jpg', 'seeder/v3.jpg'];

        $name_en = ['Ahmed Salah', 'Mohamed Ahmed', 'Omnia Ahmed', 'Esraa Ahmed', 'Youssef Ahmed'];
        $name_ar = ['أحمد صلاح', 'محمد أحمد', 'أمنية أحمد', 'اسراء أحمد', 'يوسف أحمد'];
        $gender = ['male', 'male', 'female', 'female', 'male'];
        $description_en = ['Delivery Workers description', 'Student Delivery description', 'Goods Delivery description',
            'Delivery Request description', 'Delivery Outside Bahrain description'];
        $description_ar = ['توصيل عمال', 'توصيل طلاب', 'توصيل بضائع', 'توصيل خارج البحرين', 'طلب توصيل'];
        $vehicle_type = ['cars', 'motorcycles', 'cars', 'motorcycles', 'cars'];
        $manufacturing_year = ['2019', '2011', '2020', '2000', '2018'];
        $birth_date = ['1993-07-23', '1993-08-20', '1995-05-30', '1994-01-30', '1996-02-26'];
        $conveyor_type = ['automatic', 'manual', 'manual', 'manual', 'automatic'];
        $profile_picture = ['seeder/trainer.jpg', 'seeder/male1.jpg', 'seeder/female1.jpg', 'seeder/female2.jpg', 'seeder/male2.jpg'];
        $users = ['delivery_man_1@gmail.com', 'delivery_man_2@gmail.com', 'delivery_man_3@gmail.com', 'delivery_man_4@gmail.com', 'delivery_man_5@gmail.com'];

        $status = ['available', 'busy', 'not_available'];

        $section = Section::where('ref_name', 'DeliveryMan')->first()->id;
        $phone = ['3366 7714', '1311 2262', '1725 3470', '1773 2426', '3838 7468', ''];

        $cat_name_en = ['Delivery Workers', 'Student Delivery', 'Goods Delivery', 'Delivery Outside Bahrain', 'Delivery Request'];
        $cat_name_ar = ['توصيل عمال', 'توصيل طلاب', 'توصيل بضائع', 'توصيل خارج البحرين', 'طلب توصيل'];

        $is_negotiable = [0, 1];
        $price = [500, 1000, 1500, 2000, 2300];

        for ($c = 0; $c < 5; $c++) {
            $category = Category::create([
                'name_en' => $cat_name_en[$c],
                'name_ar' => $cat_name_ar[$c],
                'section_id' => $section
            ]);

        }
        for ($i = 0; $i < 5; $i++) {

            $delivery1 = DeliveryMan::create([
                'gender' => $gender[$i],
                'name_en' => $name_en[$i],
                'name_ar' => $name_ar[$i],
                'description_en' => $description_en[$i],
                'description_ar' => 'وصف ' . $description_ar[$i],
                'vehicle_type' => $vehicle_type[$i],
                'manufacturing_year' => $manufacturing_year[$i],
                'country_id' => '1',
                'city_id' => '1',
                'area_id' => '1',
                'car_model_id' => $car_model->id,
                'car_class_id' => $car_classes[array_rand($car_classes)],
                'brand_id' => $brand,
                'birth_date' => $birth_date[$i],
                'conveyor_type' => $conveyor_type[$i],
                'active' => 1,
                'available' => 1,
                'profile_picture' => $profile_picture[$i],
                'status' => $status[array_rand($status)]

            ]);

            $delivery1->file()->create([
                'path' => $vehicle_images[$i],
                'type' => 'vehicle_image',
            ]);
            $delivery1->file()->create([
                'path' => 'seeder/driving_license.jpg',
                'type' => 'driving_license',
            ]);
            $delivery1->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '01124579105',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

            $delivery1->phones()->create([
                'country_code' => '+973',
                'phone' => $phone[array_rand($phone)],
                'title_en' => $name_en[$i],
                'title_ar' => $name_ar[$i]
            ]);


            $payment_methods = PaymentMethod::pluck('id');
            $delivery1->payment_methods()->attach($payment_methods);

            $delivery1->organization_users()->create([
                'user_name' => 'delivery user' . $i,
                'email' => $users[$i],
                'password' => "123456",
            ]);

            $delivery1->work_time()->create([
                'from' => '09:00',
                'to' => '17:00',
                'duration' => '120',
                'days' => 'Sun,Sat,Mon,Tue,Wed,Thu',
            ]);

            $delivery1->discount_cards()->attach(1);

            $delivery_categories = category::where('section_id', $section)->pluck('id')->toArray();
            foreach ($delivery_categories as $category) {
                $delivery1->categories()->attach([$category]);
            }

            $delivery_man_categories = DeliveryManCategory::where('delivery_man_id', $delivery1->id)->get();
            foreach ($delivery_man_categories as $type) {
                $type->offers()->create([
                    'discount_card_id' => 1,
                    'discount_type' => 'percentage',
                    'discount_value' => 5,
                    'number_of_uses_times' => 'specific_number',
                    'specific_number' => 2,
                    'notes' => 'خصم 5 % على التالي',
                ]);
            }
            $condition_ar = [
                'يجب على العميل استلام البضائع بحلول الموعد النهائي للتسليم المتفق عليه أو ، إذا لم يتم الاتفاق على الموعد النهائي للتسليم ، دون تأخير لا داعي له بعد استلام الإخطار بأن البضاعة جاهزة للتحصيل في مكان الأداء المتفق عليه. إذا تخلف العميل عن استلام البضائع ، يجوز لنا ، بناءً على خيارنا الخاص وعلى نفقة العميل ، شحن البضائع إلى عنوان العميل ، وتخزين البضائع (طالما أنه لا توجد إمكانية أخرى ، في الهواء الطلق أيضًا إذا لزم الأمر. ) أو فسخ العقد ، وتأكيد الأضرار. إذا تخلف العميل عن استلام البضائع ، فلن نكون مسؤولين عن التدمير العرضي للبضائع أو ضياعها أو تلفها. في حالة تخزين البضائع ، يُعتبر التسليم قد تم ، ويحق لنا الحصول على فاتورة للبضائع بعد أسبوع واحد.',
                'إذا تم الاتفاق ، خلافًا للقسم الفرعي 1 ، على أننا سنقوم بشحن البضائع ، فسيتم النقل على نفقة العميل ، وسنختار ، في حالة عدم وجود تعليمات محددة ، وسيلة النقل والمسار على أساس حرية التصرف. تنتقل المخاطرة إلى العميل في الوقت الذي نسلم فيه البضائع إلى شركة النقل.',
                'يجب أن تكون فترات التسليم المحددة غير ملزمة دائمًا. يجب أن تتطلب المواعيد النهائية للتسليم الثابت في حالة تسليم البضائع في حاويات مستعارة ، يجب إعادة الأخيرة إلينا فارغة تمامًا ودفع رسوم النقل في غضون 90 يومًا من استلام التسليم. يتحمل العميل تكاليف فقدان أو تلف العبوة المعارة في حالة كونه مسؤولاً عنها. لا يجوز استخدام الحاويات المعارة لأية أغراض أخرى ، ولا لاستلام منتجات أخرى ، وهي مخصصة حصريًا لنقل البضائع المسلمة. لا يجوز إزالة الملصقات والنقوش.',
                'الاضطرابات التشغيلية الرئيسية غير المتوقعة ، والتأخير في التسليم أو عدم التسليم من قبل موردينا ، بالإضافة إلى الانقطاعات التشغيلية بسبب نقص المواد الخام أو الطاقة أو العمال ، والإضرابات ، والإغلاق ، وتعطل حركة المرور ، وتدابير الرقابة الرسمية وحالات القوة القاهرة. يجب أن تتسبب الشركة أو موردينا في تأجيل الموعد النهائي للتسليم بسبب مدة عرقلة الأداء ، بقدر ما تكون هذه الأحداث ذات صلة بقدرتنا على تسليم البضائع. سنقوم دون تأخير لا داعي له بإخطار العميل عندما تبدأ هذه العوائق وتنتهي. إذا تأخر التسليم لأكثر من شهر نتيجة لذلك ، يحق لنا وللعميل ، باستثناء مطالبات التلف ، إلغاء العقد فيما يتعلق بالكمية المتأثرة بهذا التعطل في التسليم.',
                'إذا تم الاتفاق على موعد نهائي للتسليم ، فيجوز للعميل ، في حالة التخلف عن التسليم الذي نكون مخطئين فيه ، أن يحدد كتابةً فترة سماح معقولة لا تقل عن 10 أيام ، وبعد انتهاء فترة السماح هذه إلى لا. الاستفادة ، قم بإلغاء جزء العقد الذي لم يتم تنفيذه. في أي حال ، يتم استبعاد مطالبات التلف بسبب التقصير في التسليم.'
            ];
            $condition_en = [
                'The customer shall collect the goods by the agreed delivery deadline or, if a delivery deadline has not been firmly agreed upon, without undue delay after receipt of notification that the goods are ready for collection at the agreed place of performance. If the customer defaults on taking receipt of the goods, we may at our own option and at the customer\'s expense, ship the goods to the customer\'s address, store the goods (insofar as no other possibility exists, also in the open air if need be) or rescind the contract, and assert damages. If the customer defaults on taking receipt of the goods, we shall not be liable for accidental destuction of, loss of or damage to the goods. In the event that the goods are stored, the delivery shall be deemed to have been made, and we shall be entitled to invoice for the goods after one week. ',
                'If, contrary to subsection 1, it is agreed that we shall ship the goods, transportation shall occur at the customer\'s expense, and we shall, in the absence of a specific instruction, choose the means of transportation and the route on the basis of our discretion. The risk shall pass to the customer at the time when we hand over the goods to the carrier. ',
                'Delivery periods specified shall always be non-binding. Fixed delivery Deadlines shall requireIn the case that goods are delivered in loaned containers, the latter must be returned to us completely empty and carriage paid within 90 days of receipt of delivery. The costs of loss of or damages to loaned packaging will be borne by the customer in the case that he/she is responsible for it/them. Loaned containers shall not be employed for any other purposes, nor for the reception of other products, and are intended exclusively for the transport of the delivered goods. Labels and inscriptions shall not be removed.',
                'Major unforeseeable operational disruptions, delays in delivery or non-delivery by our suppliers, as well as operational interruptions owing to a shortage of raw materials, energy or workers, strikes, lockouts, traffic disruptions, official control measures and cases of force majeure at our company or our suppliers shall cause the delivery deadline to be postponed by the duration of the hindrance to performance, insofar as such events are relevant to our ability to deliver the goods. We shall without undue delay notify the customer when such hindrances begin and end. If delivery is delayed by more than one month as a result thereof, both we and the customer shall be entitled, with the exclusion of damage claims, to rescind the contract in respect of the quantity affected by such disruption to delivery. ',
                'If a fixed delivery deadline has been agreed upon, the customer may, in the event of default in delivery for which we are at fault, set in writing a reasonable grace period of a least 10 days and, after this grace period has expired to no avail, rescind the part of the contract that has not been performed. In any event, damage claims due to default in delivery shall be excluded. '
            ];

            for ($c = 0; $c < 5; $c++){
                $delivery1->conditions()->create([
                    'description_ar' => $condition_ar[$c],
                    'description_en' => $condition_en[$c],
                ]);
            }

            $cities = City::pluck('id')->toArray();

            for ($d = 0; $d < 4; $d++){
                $random_city = $cities[array_rand($cities)];
                $delivery1->deliveryAreas()->create([
                    'country_id' => 1,
                    'city_id' => $random_city,
                    'area_id' => Area::where('city_id', $random_city)->inRandomOrder()->first()->id,
                ]);
            }

        }


    }

}
