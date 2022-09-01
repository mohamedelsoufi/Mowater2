<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\CarModelProduct;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\PaymentMethod;
use App\Models\Scrap;
use App\Models\SparePart;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class SparePartsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name_en = ['Bahrain Showroom', 'Nissan spare parts', 'Mexema spare parts', 'SparePart 1',];
        $name_ar = ['معرض البحرين', 'قطع غيار نيسان', 'قطع غيار مكسيما', 'قطع غيار ددسن',];
        $description_en = ['You will find both new and used parts that are in the best condition. We believe that you will find these spare parts at a discounted price compared to the open market and from dealers as well. We are here giving a chance to every individual auto spare parts dealer as well as anyone, to advertise what they t want to sell to potential clients.', 'If your Nissan car in Bahrain or any other car and you need spare parts such as a clutch box, left front fender, front right fender, right rear fender, or any other parts, you can take advantage of the Afial network by sending a request for your spare parts needs to obtain special quotations from dealers local for different types of new and used parts', 'If your car is a Maxima or any other car and you need spare parts such as crank spikes, moving spikes, thymin bushings, thymin shaft spikes, carburetor coils or any other parts, you can take advantage of the Afial network by sending a request for your spare parts needs to get your own quotations from local dealers Various types of new and used parts', 'If your Dadson or any other car needs spare parts such as Timmin shaft, top drive pulley, Timman belt pulley, small track tensioner, or any other parts, you can take advantage of the Afial network by sending a request for your spare parts needs to get special quotations from dealers local for different types of new and used parts',];
        $description_ar = ['سوف تجد كل من قطع الغيار الجديدة والمستعملة التي هي في أفضل حالة. ونحن نعتقد أن تجدوا هذه قطع الغيار بسعر مخفض بالمقارنة مع السوق المفتوحة ومن تجار كذلك. نحن هنا اعطاء فرصة لكل فرد السيارات قطع الغيار تاجر وكذلك أي شخص، للإعلان عن ما يريدون ر بيعها للعملاء المحتملين.', 'إذا سيارتك نيسان في البحرين أو أي سيارة أخرى وتحتاج قطع غيار مثل علبة كلتش أو رفرف امامي يسار أو رفرف امامي يمين أو رفرف خلفي يمين أو أي قطع أخرى فبإمكانك الاستفادة من شبكة أفيال عبر إرسال طلب لاحتياجاتك من قطع الغيار للحصول على تسعيرات خاصة بك من التجار المحليين لمختلف أنواع القطع الجديدة والمستخدمة', 'إذا سيارتك مكسيما أو أي سيارة أخرى وتحتاج قطع غيار مثل سبايك كرنك أو سبايك متحركه أو جلبه ثيمن أو سبايك عمود ثيمن أو كرتيل بلف أو أي قطع أخرى فبإمكانك الاستفادة من شبكة أفيال عبر إرسال طلب لاحتياجاتك من قطع الغيار للحصول على تسعيرات خاصة بك من التجار المحليين لمختلف أنواع القطع الجديدة والمستخدمة', 'إذا سيارتك ددسن أو أي سيارة أخرى وتحتاج قطع غيار مثل عمود تيمن بلف أو بكره سير جنزير فوق أو بكره سير تيمن أو شداد جنزير صغير أو أي قطع أخرى فبإمكانك الاستفادة من شبكة أفيال عبر إرسال طلب لاحتياجاتك من قطع الغيار للحصول على تسعيرات خاصة بك من التجار المحليين لمختلف أنواع القطع الجديدة والمستخدمة',];
        $year_founded = ['1996', '1999', '1959', '1959',];
        $logos = ['m7.png', 'm8.png', 'm9.jpg', 'm10.jpg', 'm11.jpg', 'm12.jpg'];
        $users = ['spare_parts1@gmail.com', 'spare_parts2@gmail.com', 'spare_parts3@gmail.com', 'spare_parts4@gmail.com', 'spare_parts5@gmail.com', 'spare_parts6@gmail.com'];
        $type = ['commercial', 'original'];
        $price = [1598753, 3578951, 258963, 147852, 147986325];
        $car_model_id = [1, 2, 3, 4, 5];
        $status = ['good', 'very_good', 'excellent'];
        $car_class = [1, 2, 3];
        $manufacturing_year = ['2020', '2021', '2022'];

        for ($counter = 0; $counter < 6; $counter++) {
            $spare_part = SparePart::create([
                'name_en' => $name_en[array_rand($name_en)],
                'name_ar' => $name_ar[array_rand($name_ar)],
                'description_en' => $description_en[array_rand($description_en)],
                'description_ar' => $description_ar[array_rand($description_ar)],
                'logo' => 'seeder/' . $logos[$counter],
                'active' => 1,
                'available' => 1,
                'reservation_availability' => 1,
                'delivery_availability' => 1,
                'reservation_active' => 1,
                'delivery_active' => 1,
                'country_id' => Country::where('name_en', 'Bahrain')->first()->id,
                'city_id' => City::first()->id,
                'area_id' => Area::where('city_id', City::first()->id)->first()->id,
                'year_founded' => $year_founded[array_rand($year_founded)],
            ]);

            $payment_methods = PaymentMethod::pluck('id');
            $spare_part->payment_methods()->attach($payment_methods);

            $spare_part->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '01124579105',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

            $spare_part->work_time()->create([
                'from' => '09:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sun,Mon,Tue,Wed,Thu',
            ]);

            $spare_part->organization_users()->create([
                'user_name' => 'Scarp' . $counter,
                'email' => $users[$counter],
                'password' => "123456",
            ]);

            $categories = Category::where('section_id', null)->get();

            foreach ($categories as $key => $category) {
                $brands = Brand::all();
                foreach ($brands as $brand) {
                    $car_models = CarModel::where('brand_id', $brand->id)->get();
                    foreach ($car_models as $car_model) {
                        $products = $spare_part->products()->create([
                            'name_en' => 'spare_part product' . ' ' . $brand->name_en,
                            'name_ar' => $brand->name_ar . ' ' . 'منتج قطع الغيار ',
                            'description_en' => 'Description spare_part product ' . ' ' . $brand->name_en . ', ' . $car_model->name_en,
                            'description_ar' => $brand->name_ar . ', ' . $car_model->name_ar . ' ' . 'وصف منتج قطع الغيار ',
                            'brand_id' => $car_model->brand_id,
                            'car_model_id' => $car_model->id,
                            'car_class_id' => $car_class[array_rand($car_class)],
                            'manufacturing_year' => $manufacturing_year[array_rand($manufacturing_year)],
                            'price' => $price[array_rand($price)],
                            'type' => $type[array_rand($type)],
                            'status' => $status[array_rand($status)],
                            'category_id' => $category->id,
                            'sub_category_id' => SubCategory::where('category_id', $category->id)->first()->id,
                        ]);
                        $products->files()->create([
                            'path' => 'seeder/spare_parts_cars.jpg',
                            'type' => 'image'
                        ]);

                        CarModelProduct::create([
                            'car_model_id' => $car_model_id[array_rand($car_model_id)],
                            'product_id' => $products->id,
                            'manufacturing_years' => '1998,2000,1989'
                        ]);
                    }
                }
            }
        }
    }
}
