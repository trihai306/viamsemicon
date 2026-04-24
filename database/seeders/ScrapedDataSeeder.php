<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ScrapedDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSettings();
        $this->seedCategories();
        $this->seedProducts();
        $this->seedPosts();
        $this->seedSliders();
        $this->seedPartners();
        $this->seedPages();
    }

    private function seedSettings(): void
    {
        $settings = [
            ['group' => 'general', 'key' => 'site_name', 'value' => 'Viam Semicon', 'type' => 'text'],
            ['group' => 'general', 'key' => 'company_name', 'value' => 'Công ty TNHH VIAM GLOBAL', 'type' => 'text'],
            ['group' => 'general', 'key' => 'address', 'value' => 'Số 251 Đường Dục Tú, Xã Dục Tú, Huyện Đông Anh, Thành phố Hà Nội, Việt Nam', 'type' => 'text'],
            ['group' => 'general', 'key' => 'phone', 'value' => '0986020896', 'type' => 'text'],
            ['group' => 'general', 'key' => 'hotline', 'value' => '0886160579', 'type' => 'text'],
            ['group' => 'general', 'key' => 'email', 'value' => 'sale@viamsemicon.com', 'type' => 'text'],
            ['group' => 'general', 'key' => 'contact_person', 'value' => 'Alex Nguyen', 'type' => 'text'],
            ['group' => 'general', 'key' => 'zalo', 'value' => '0335488393', 'type' => 'text'],
            ['group' => 'social', 'key' => 'facebook', 'value' => '#', 'type' => 'text'],
            ['group' => 'social', 'key' => 'instagram', 'value' => '#', 'type' => 'text'],
            ['group' => 'social', 'key' => 'twitter', 'value' => '#', 'type' => 'text'],
            ['group' => 'social', 'key' => 'youtube', 'value' => '#', 'type' => 'text'],
            ['group' => 'seo', 'key' => 'seo_title', 'value' => 'Viam Semicon - Thiết bị đo lường, Robot vận chuyển, RF Cable & Adapters', 'type' => 'text'],
            ['group' => 'seo', 'key' => 'seo_description', 'value' => 'Viam Semicon cung cấp thiết bị đo lường, robot vận chuyển, RF Cable & Adapters chất lượng cao. Hotline: 0886 160 579', 'type' => 'text'],
            ['group' => 'seo', 'key' => 'seo_keywords', 'value' => 'thiết bị đo lường, robot vận chuyển, RF cable, adapter, Viam Semicon', 'type' => 'text'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(
                ['key' => $s['key']],
                ['group' => $s['group'], 'value' => $s['value'], 'type' => $s['type']]
            );
        }

        $this->command->info('Settings seeded.');
    }

    private function seedCategories(): void
    {
        $categories = [
            ['name' => ['vi' => 'RF CABLE & ADAPTERS', 'en' => 'RF Cable & Adapters'], 'slug' => 'rf-cable-adapters', 'sort_order' => 1],
            ['name' => ['vi' => 'THIẾT BỊ ĐO LƯỜNG', 'en' => 'Measuring Equipment'], 'slug' => 'thiet-bi-do-luong', 'sort_order' => 2],
            ['name' => ['vi' => 'THIẾT BỊ PHÂN TÍCH MẠNG CŨ', 'en' => 'Network Analyzer Equipment'], 'slug' => 'thiet-bi-phan-tich-mang-cu', 'sort_order' => 3],
            ['name' => ['vi' => 'ROBOT VẬN CHUYỂN', 'en' => 'Transport Robots'], 'slug' => 'robot-van-chuyen', 'sort_order' => 4],
            ['name' => ['vi' => 'ĐIỆN TRỞ NHIỆT', 'en' => 'Thermal Resistors'], 'slug' => 'dien-tro-nhiet', 'sort_order' => 5],
            ['name' => ['vi' => 'Máy quét mã vạch', 'en' => 'Barcode Scanner'], 'slug' => 'may-quet-ma-vach', 'sort_order' => 6],
            ['name' => ['vi' => 'Que dính bụi', 'en' => 'Dust Sticky Roller'], 'slug' => 'que-dinh-bui', 'sort_order' => 7],
        ];

        $subCategories = [
            'rf-cable-adapters' => [
                ['name' => ['vi' => 'Coax Adapters', 'en' => 'Coax Adapters'], 'slug' => 'coax-adapters', 'sort_order' => 1],
                ['name' => ['vi' => 'DC Block', 'en' => 'DC Block'], 'slug' => 'dc-block', 'sort_order' => 2],
                ['name' => ['vi' => 'Fixed Attenuators', 'en' => 'Fixed Attenuators'], 'slug' => 'fixed-attenuators', 'sort_order' => 3],
                ['name' => ['vi' => 'Flexible Cable Assemblies', 'en' => 'Flexible Cable Assemblies'], 'slug' => 'flexible-cable-assemblies', 'sort_order' => 4],
                ['name' => ['vi' => 'Power Dividers', 'en' => 'Power Dividers'], 'slug' => 'power-dividers', 'sort_order' => 5],
                ['name' => ['vi' => 'Terminations', 'en' => 'Terminations'], 'slug' => 'terminations', 'sort_order' => 6],
            ],
            'thiet-bi-do-luong' => [
                ['name' => ['vi' => 'Antenna Kits', 'en' => 'Antenna Kits'], 'slug' => 'antenna-kits', 'sort_order' => 1],
                ['name' => ['vi' => 'Antennas', 'en' => 'Antennas'], 'slug' => 'antennas', 'sort_order' => 2],
                ['name' => ['vi' => 'Bộ cấp nguồn', 'en' => 'Power Supply'], 'slug' => 'bo-cap-nguon', 'sort_order' => 3],
                ['name' => ['vi' => 'Comb Generators', 'en' => 'Comb Generators'], 'slug' => 'comb-generators', 'sort_order' => 4],
                ['name' => ['vi' => 'Đồng hồ đo nhiệt độ, độ ẩm', 'en' => 'Temperature & Humidity Meters'], 'slug' => 'dong-ho-do-nhiet-do-do-am', 'sort_order' => 5],
            ],
        ];

        foreach ($categories as $data) {
            $cat = Category::updateOrCreate(['slug' => $data['slug']], $data);
            if (isset($subCategories[$data['slug']])) {
                foreach ($subCategories[$data['slug']] as $sub) {
                    $sub['parent_id'] = $cat->id;
                    Category::updateOrCreate(['slug' => $sub['slug']], $sub);
                }
            }
        }

        $this->command->info('Categories seeded.');
    }

    private function seedProducts(): void
    {
        $wpCatToSlug = [
            40 => 'rf-cable-adapters',
            22 => 'thiet-bi-do-luong',
            41 => 'thiet-bi-phan-tich-mang-cu',
            43 => 'robot-van-chuyen',
            44 => 'dien-tro-nhiet',
            45 => 'may-quet-ma-vach',
            46 => 'que-dinh-bui',
            // Sub-categories
            33 => 'coax-adapters',
            24 => 'dc-block',
            27 => 'fixed-attenuators',
            31 => 'flexible-cable-assemblies',
            32 => 'power-dividers',
            28 => 'terminations',
            29 => 'antenna-kits',
            30 => 'antennas',
            34 => 'bo-cap-nguon',
            23 => 'comb-generators',
            26 => 'dong-ho-do-nhiet-do-do-am',
        ];

        $products = [
            [
                'name' => ['vi' => 'Robot vận chuyển đeo lưng', 'en' => 'Back-mounted Transport Robot'],
                'slug' => 'robot-van-chuyen-deo-lung',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_21.jpg',
                'wp_cats' => [22],
                'content' => '<div class="product-short-description"><p>Dòng robot S Series được trang bị chức năng vận chuyển đeo lưng, có khả năng tự động nhận diện kệ hàng, hỗ trợ tích hợp MES, ERP, WMS. Phù hợp với nhiều loại hình nhà máy sản xuất.</p></div>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'Robot vận chuyển ẩn dưới (chui gầm)', 'en' => 'Undercarriage Transport Robot'],
                'slug' => 'robot-van-chuyen-an-duoi-chui-gam',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_14-1.jpg',
                'wp_cats' => [43],
                'content' => '<div class="product-short-description"><p>Dòng robot S Series được trang bị chức năng nâng hạ, có khả năng tự động nhận diện kệ hàng, hỗ trợ tích hợp MES, ERP, WMS. Robot di chuyển linh hoạt bên dưới kệ hàng, tiết kiệm không gian nhà xưởng.</p></div>',
                'is_featured' => true,
            ],
            [
                'name' => ['vi' => 'Robot vận chuyển nâng hạ dòng L', 'en' => 'L-Series Lifting Transport Robot'],
                'slug' => 'robot-van-chuyen-nang-ha-dong-l',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_8-3.jpg',
                'wp_cats' => [43],
                'content' => '<div class="product-short-description"><p>Dòng robot S Series được trang bị chức năng nâng hạ, có khả năng tự động nhận diện kệ hàng, hỗ trợ tích hợp MES, ERP, WMS. Robot vận chuyển nâng hạ dòng L với tải trọng lớn.</p></div>',
                'is_featured' => true,
            ],
            [
                'name' => ['vi' => 'SR-XYWA-010', 'en' => 'SR-XYWA-010'],
                'slug' => 'sr-xywa-010',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_1-4.jpg',
                'wp_cats' => [46],
                'content' => '<div class="product-short-description"><p>Que dính bụi SR-XYWA-010 chất lượng cao, dùng trong phòng sạch và quy trình sản xuất bán dẫn. Độ dính ổn định, không để lại dư lượng keo trên bề mặt sản phẩm.</p></div>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'SR-XYWA-008', 'en' => 'SR-XYWA-008'],
                'slug' => 'sr-xywa-008',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_8-2.jpg',
                'wp_cats' => [46],
                'content' => '<div class="product-short-description"><p>Que dính bụi SR-XYWA-008 dùng trong phòng sạch, sản xuất bán dẫn. Chất liệu silicon cao cấp, độ bền cao, sử dụng lâu dài.</p></div>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'SR-XYWA-007', 'en' => 'SR-XYWA-007'],
                'slug' => 'sr-xywa-007',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_4-3.jpg',
                'wp_cats' => [46],
                'content' => '<div class="product-short-description"><p>Que dính bụi SR-XYWA-007 chất lượng cao, dùng trong phòng sạch và quy trình sản xuất bán dẫn. Phù hợp với nhiều ứng dụng công nghiệp khác nhau.</p></div>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'SR-XYWA-006', 'en' => 'SR-XYWA-006'],
                'slug' => 'sr-xywa-006',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_1-3.jpg',
                'wp_cats' => [46],
                'content' => '<div class="product-short-description"><p>Que dính bụi SR-XYWA-006 chất lượng cao, dùng trong phòng sạch. Thiết kế phù hợp cho các ứng dụng làm sạch bề mặt chính xác.</p></div>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'SR-XYWA-005', 'en' => 'SR-XYWA-005'],
                'slug' => 'sr-xywa-005',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_4-2.jpg',
                'wp_cats' => [46],
                'content' => '<div class="product-short-description"><p>Que dính bụi SR-XYWA-005 chất lượng cao, dùng trong phòng sạch và quy trình sản xuất bán dẫn.</p></div>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'SR-XYWA-004', 'en' => 'SR-XYWA-004'],
                'slug' => 'sr-xywa-004',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_1-2.jpg',
                'wp_cats' => [46],
                'content' => '<div class="product-short-description"><p>Que dính bụi SR-XYWA-004 chất lượng cao, dùng trong phòng sạch và quy trình sản xuất bán dẫn. Độ dính ổn định, hiệu quả cao.</p></div>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'SR-XYWA-003', 'en' => 'SR-XYWA-003'],
                'slug' => 'sr-xywa-003',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_4-1.jpg',
                'wp_cats' => [46],
                'content' => '<div class="product-short-description"><p>Que dính bụi SR-XYWA-003 chất lượng cao, dùng trong phòng sạch và quy trình sản xuất bán dẫn.</p></div>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'SR-XYWA-002', 'en' => 'SR-XYWA-002'],
                'slug' => 'sr-xywa-002',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_1-1.jpg',
                'wp_cats' => [46],
                'content' => '<div class="product-short-description"><p>Que dính bụi SR-XYWA-002 chất lượng cao, dùng trong phòng sạch và quy trình sản xuất bán dẫn.</p></div>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'SR-XYWA-001', 'en' => 'SR-XYWA-001'],
                'slug' => 'sr-xywa-001',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_8-1.jpg',
                'wp_cats' => [22],
                'content' => '<div class="product-short-description"><p>Que dính bụi SR-XYWA-001 chất lượng cao, dùng trong phòng sạch và quy trình sản xuất bán dẫn.</p></div>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'SR-XYRS-002', 'en' => 'SR-XYRS-002'],
                'slug' => 'sr-xyrs-002',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_4.jpg',
                'wp_cats' => [46],
                'content' => '<div class="product-short-description"><p>Que dính bụi SR-XYRS-002 dòng RS chất lượng cao, dùng trong phòng sạch và quy trình sản xuất bán dẫn.</p></div>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'SR-XYRS-003', 'en' => 'SR-XYRS-003'],
                'slug' => 'sr-xyrs-003',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_1.jpg',
                'wp_cats' => [46],
                'content' => '<div class="product-short-description"><p>Que dính bụi SR-XYRS-003 dòng RS chất lượng cao, dùng trong phòng sạch.</p></div>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'SR-XJBS-003', 'en' => 'SR-XJBS-003'],
                'slug' => 'sr-xjbs-003',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_16.jpg',
                'wp_cats' => [46],
                'content' => '<div class="product-short-description"><p>Que dính bụi SR-XJBS-003 dòng JBS chất lượng cao, dùng trong phòng sạch và quy trình sản xuất bán dẫn.</p></div>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'SR-XJBS-002', 'en' => 'SR-XJBS-002'],
                'slug' => 'sr-xjbs-002',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_15.jpg',
                'wp_cats' => [46],
                'content' => '<div class="product-short-description"><p>Que dính bụi SR-XJBS-002 dòng JBS chất lượng cao, dùng trong phòng sạch.</p></div>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'SR-XJBS-001', 'en' => 'SR-XJBS-001'],
                'slug' => 'sr-xjbs-001',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_12.jpg',
                'wp_cats' => [46],
                'content' => '<div class="product-short-description"><p>Que dính bụi SR-XJBS-001 dòng JBS chất lượng cao, dùng trong phòng sạch và quy trình sản xuất bán dẫn.</p></div>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'SH-800-GHD', 'en' => 'SH-800-GHD'],
                'slug' => 'sh-800-ghd',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Screenshot_8.jpg',
                'wp_cats' => [45],
                'content' => '<div class="product-short-description"><p>Máy quét mã vạch SH-800-GHD, quét nhanh chính xác, tương thích nhiều loại mã vạch 1D và 2D. Thiết kế công nghiệp bền bỉ.</p></div>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'MV-L600', 'en' => 'MV-L600'],
                'slug' => 'mv-l600',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/05/S600.png',
                'wp_cats' => [43],
                'content' => '<h2>MV-L600 - Robot vận chuyển nâng hạ</h2><p>Robot vận chuyển MV-L600 dòng cao cấp với tải trọng 600kg, điều khiển tự động hoàn toàn. Tích hợp hệ thống SLAM navigation, cảm biến LiDAR, và khả năng tránh vật cản thông minh.</p><h3>Thông số kỹ thuật</h3><ul><li>Tải trọng: 600kg</li><li>Tốc độ: 1.5m/s</li><li>Pin: Lithium 48V</li><li>Thời gian sạc: 2h</li><li>Thời gian hoạt động: 8h</li></ul>',
                'is_featured' => true,
            ],
            [
                'name' => ['vi' => 'AMR-MARS', 'en' => 'AMR-MARS'],
                'slug' => 'amr-mars',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/05/MARS.png',
                'wp_cats' => [43],
                'content' => '<h2>AMR-MARS - Robot tự hành thông minh</h2><p>Robot tự hành AMR-MARS với công nghệ SLAM tiên tiến, di chuyển linh hoạt trong nhà máy. Thiết kế module hóa cho phép tùy biến theo nhu cầu sản xuất.</p><h3>Tính năng nổi bật</h3><ul><li>Công nghệ SLAM navigation</li><li>Cảm biến LiDAR 360°</li><li>Tích hợp MES/WMS</li><li>Đa dạng module đầu cuối</li></ul>',
                'is_featured' => true,
            ],
            [
                'name' => ['vi' => 'AMR COBOT CONVEYOR MV-ACC25', 'en' => 'AMR COBOT CONVEYOR MV-ACC25'],
                'slug' => 'amr-cobot-conveyor-mv-acc25',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/05/ACC25_05.png',
                'wp_cats' => [43],
                'content' => '<h2>MV-ACC25 - Robot băng tải kết hợp Cobot</h2><p>Robot băng tải kết hợp cobot MV-ACC25, tự động hóa dây chuyền sản xuất. Kết hợp khả năng vận chuyển tự hành AMR với cánh tay robot cộng tác (Cobot) và băng tải tích hợp.</p>',
                'is_featured' => true,
            ],
            [
                'name' => ['vi' => 'MV-D150', 'en' => 'MV-D150'],
                'slug' => 'mv-d150',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/05/6112_D150.png',
                'wp_cats' => [43],
                'content' => '<h2>MV-D150 - Robot vận chuyển nhỏ gọn</h2><p>Robot vận chuyển MV-D150 nhỏ gọn, phù hợp không gian hẹp. Tải trọng 150kg, thiết kế cho khách sạn, nhà hàng, bệnh viện và các không gian dịch vụ.</p>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'MV-2112', 'en' => 'MV-2112'],
                'slug' => 'mv-2112',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/05/2112_Hotel.png',
                'wp_cats' => [43],
                'content' => '<h2>MV-2112 - Robot phục vụ khách sạn</h2><p>Robot vận chuyển MV-2112, thiết kế cho ngành khách sạn và dịch vụ. Khả năng di chuyển giữa các tầng bằng thang máy, giao hàng tự động đến phòng khách.</p>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'Máy kiểm tra đặc tính linh kiện bán dẫn KEITHLEY 2612B', 'en' => 'Semiconductor Component Tester KEITHLEY 2612B'],
                'slug' => 'may-kiem-tra-dac-tinh-linh-kien-ban-dan-keithley-2612b',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/04/f0f91f6077cb2a4b0785b079a55d9e5f95e1ff0c.png',
                'wp_cats' => [22, 40, 41],
                'content' => '<h2>KEITHLEY 2612B - Máy kiểm tra đặc tính linh kiện bán dẫn</h2><p>Máy kiểm tra đặc tính linh kiện bán dẫn KEITHLEY 2612B, 2 kênh đo, độ chính xác cao. Ứng dụng trong kiểm tra IV curve, đo đặc tính transistor, diode và các linh kiện bán dẫn khác.</p>',
                'is_featured' => true,
            ],
            [
                'name' => ['vi' => 'ZPH R&S®Cable Rider', 'en' => 'ZPH R&S®Cable Rider'],
                'slug' => 'zph-rscable-rider',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/03/ZPH.png',
                'wp_cats' => [22],
                'content' => '<h2>ZPH R&S®Cable Rider</h2><p>Thiết bị đo cáp ZPH R&S Cable Rider, cầm tay gọn nhẹ, đo nhanh chính xác. Dải tần 2MHz đến 4GHz, đo DTF, Return Loss, VSWR và Cable Loss.</p>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'R&S Cable and Antenna Analyzer', 'en' => 'R&S Cable and Antenna Analyzer'],
                'slug' => 'van-keo-htv-gv-3810',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/03/RS®ZVH.png',
                'wp_cats' => [41],
                'content' => '<h2>R&S Cable and Antenna Analyzer</h2><p>Thiết bị phân tích cáp và anten R&S, kiểm tra đường truyền RF. Đo lường chính xác các thông số cáp và anten trong dải tần rộng.</p>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'Keysight Digital Multimeter', 'en' => 'Keysight Digital Multimeter'],
                'slug' => 'keysight-digital-multimeter',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/03/Agilent-U3606A.png',
                'wp_cats' => [41],
                'content' => '<h2>Keysight Digital Multimeter</h2><p>Đồng hồ vạn năng kỹ thuật số Keysight, đo đa năng chính xác cao. Đo điện áp AC/DC, dòng điện, điện trở, tần số và nhiều thông số khác.</p>',
                'is_featured' => true,
            ],
            [
                'name' => ['vi' => 'Keysight Network Analyzer', 'en' => 'Keysight Network Analyzer'],
                'slug' => 'keysight-network-analyzer',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/03/N4444A.png',
                'wp_cats' => [41],
                'content' => '<h2>Keysight Network Analyzer</h2><p>Máy phân tích mạng Keysight, phân tích RF và vi sóng chuyên nghiệp. Đo S-parameters, impedance matching, và các thông số mạng khác với độ chính xác cao.</p>',
                'is_featured' => true,
            ],
            [
                'name' => ['vi' => 'Keysight VNA', 'en' => 'Keysight VNA'],
                'slug' => 'keysight-vna',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/03/N3383A.png',
                'wp_cats' => [41],
                'content' => '<h2>Keysight VNA - Vector Network Analyzer</h2><p>Máy phân tích mạng vector Keysight VNA cho đo lường chính xác. Dải tần rộng, phân tích S-parameter toàn diện.</p>',
                'is_featured' => false,
            ],
            [
                'name' => ['vi' => 'Máy cấp và vặn vít tích hợp cầm tay HTV-BSF-01', 'en' => 'Handheld Screw Feeder HTV-BSF-01'],
                'slug' => 'may-cap-va-van-vit-tich-hop-cam-tay-htv-bsf-01',
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/03/may-cap-va-van-vit-tich-hop-cam-tay-htv-bsf-01-r1.webp',
                'wp_cats' => [23, 24, 27, 28],
                'content' => '<h2>HTV-BSF-01 - Máy cấp và vặn vít tích hợp</h2><p>Máy cấp và vặn vít tích hợp cầm tay HTV-BSF-01, tăng năng suất lắp ráp. Thiết kế nhỏ gọn, dễ sử dụng, phù hợp với nhiều loại vít từ M1 đến M5.</p><h3>Thông số</h3><ul><li>Loại vít: M1-M5</li><li>Tốc độ: 20-30 vít/phút</li><li>Mô-men xoắn: 0.2-2.0 N·m</li></ul>',
                'is_featured' => true,
            ],
        ];

        foreach ($products as $i => $data) {
            $categorySlug = null;
            if (!empty($data['wp_cats'])) {
                $firstCat = $data['wp_cats'][0];
                $categorySlug = $wpCatToSlug[$firstCat] ?? null;
            }

            $category = $categorySlug ? Category::where('slug', $categorySlug)->first() : null;
            $imagePath = $this->downloadImage($data['image_url'], 'products');

            $contentVi = $data['content'];
            $shortDesc = strip_tags(Str::limit($contentVi, 200));

            Product::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name' => $data['name'],
                    'category_id' => $category?->id,
                    'short_description' => ['vi' => $shortDesc, 'en' => $shortDesc],
                    'description' => ['vi' => $contentVi, 'en' => $contentVi],
                    'price_text' => 'Liên hệ',
                    'image' => $imagePath,
                    'is_featured' => $data['is_featured'] ?? false,
                    'is_active' => true,
                    'sort_order' => $i,
                ]
            );

            $this->command->info("Product: {$data['name']['vi']}");
        }

        $this->command->info('Products seeded: ' . count($products));
    }

    private function seedPosts(): void
    {
        $jsonPath = database_path('seeders/data/posts.json');
        $postsData = json_decode(file_get_contents($jsonPath), true);

        foreach ($postsData as $data) {
            $imagePath = $this->downloadImage($data['image'] ?? '', 'posts');

            $title = html_entity_decode($data['title'], ENT_QUOTES, 'UTF-8');
            $excerptText = strip_tags(html_entity_decode($data['excerpt'], ENT_QUOTES, 'UTF-8'));
            $excerptText = trim($excerptText);

            Post::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => ['vi' => $title, 'en' => $title],
                    'content' => ['vi' => $data['content'], 'en' => $data['content']],
                    'excerpt' => ['vi' => $excerptText, 'en' => $excerptText],
                    'image' => $imagePath,
                    'category_type' => 'tin-tuc',
                    'is_published' => true,
                    'published_at' => substr($data['date'], 0, 10),
                ]
            );

            $this->command->info("Post: {$title}");
        }

        $this->command->info('Posts seeded: ' . count($postsData));
    }

    private function seedSliders(): void
    {
        $sliders = [
            [
                'title' => ['vi' => 'Thiết bị đo lường', 'en' => 'Measuring Equipment'],
                'subtitle' => ['vi' => 'Cung cấp thiết bị đo lường chính xác cao cho ngành công nghiệp bán dẫn', 'en' => 'Providing high-precision measuring equipment for the semiconductor industry'],
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Thiet-bi-do-luong-1024x307.jpg',
                'link' => '/danh-muc-san-pham/thiet-bi-do-luong',
                'sort_order' => 1,
            ],
            [
                'title' => ['vi' => 'Thiết bị test EMC', 'en' => 'EMC Test Equipment'],
                'subtitle' => ['vi' => 'Giải pháp kiểm tra tương thích điện từ toàn diện', 'en' => 'Comprehensive electromagnetic compatibility testing solutions'],
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Thiet-bi-test-EMC-1024x307.jpg',
                'link' => '/san-pham',
                'sort_order' => 2,
            ],
            [
                'title' => ['vi' => 'Thiết bị kiểm tra sóng', 'en' => 'Wave Testing Equipment'],
                'subtitle' => ['vi' => 'Thiết bị kiểm tra và phân tích sóng RF chuyên nghiệp', 'en' => 'Professional RF wave testing and analysis equipment'],
                'image_url' => 'https://viamsemicon.com/wp-content/uploads/2025/10/Thiet-bi-kiem-tra-song-1024x307.jpg',
                'link' => '/san-pham',
                'sort_order' => 3,
            ],
        ];

        foreach ($sliders as $data) {
            $imagePath = $this->downloadImage($data['image_url'], 'sliders');

            Slider::updateOrCreate(
                ['sort_order' => $data['sort_order']],
                [
                    'title' => $data['title'],
                    'subtitle' => $data['subtitle'],
                    'image' => $imagePath ?: 'sliders/placeholder.jpg',
                    'link' => $data['link'],
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('Sliders seeded: ' . count($sliders));
    }

    private function seedPartners(): void
    {
        $partners = [
            ['name' => 'Emzer', 'logo_url' => 'https://viamsemicon.com/wp-content/uploads/2025/04/emzer-1.png', 'link' => null],
            ['name' => 'Com-Power', 'logo_url' => 'https://viamsemicon.com/wp-content/uploads/2025/04/Com-Power.png', 'link' => null],
            ['name' => 'AnaPico', 'logo_url' => 'https://viamsemicon.com/wp-content/uploads/2025/04/anapico.jpg', 'link' => null],
            ['name' => 'AFJ', 'logo_url' => 'https://viamsemicon.com/wp-content/uploads/2025/04/AFJ_1.png', 'link' => null],
            ['name' => 'Keysight', 'logo_url' => 'https://viamsemicon.com/wp-content/uploads/2025/03/partner_2.webp', 'link' => null],
            ['name' => 'Rohde & Schwarz', 'logo_url' => 'https://viamsemicon.com/wp-content/uploads/2025/03/partner_3.webp', 'link' => null],
            ['name' => 'Aaronia AG', 'logo_url' => 'https://viamsemicon.com/wp-content/uploads/2025/04/Aaronia-AG.png', 'link' => null],
            ['name' => 'LitePoint', 'logo_url' => 'https://viamsemicon.com/wp-content/uploads/2025/04/litepoint-logo.png', 'link' => null],
            ['name' => 'L2 Microwave', 'logo_url' => 'https://viamsemicon.com/wp-content/uploads/2025/04/l2-microwave.png', 'link' => null],
            ['name' => 'ISP', 'logo_url' => 'https://viamsemicon.com/wp-content/uploads/2025/04/ISP-logo.png', 'link' => null],
            ['name' => 'Giga', 'logo_url' => 'https://viamsemicon.com/wp-content/uploads/2025/04/giga.png', 'link' => null],
        ];

        foreach ($partners as $i => $data) {
            $logoPath = $this->downloadImage($data['logo_url'], 'partners');

            Partner::updateOrCreate(
                ['name' => $data['name']],
                [
                    'logo' => $logoPath ?: 'partners/placeholder.png',
                    'link' => $data['link'],
                    'sort_order' => $i,
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('Partners seeded: ' . count($partners));
    }

    private function seedPages(): void
    {
        $pages = [
            [
                'title' => ['vi' => 'Giới thiệu', 'en' => 'About Us'],
                'slug' => 'gioi-thieu',
                'content' => [
                    'vi' => '<h2>Về Viam Semicon</h2><p>Công ty TNHH VIAM GLOBAL là nhà phân phối chuyên nghiệp trong lĩnh vực thiết bị đo lường, robot vận chuyển và RF Cable & Adapters. Chúng tôi cung cấp các giải pháp toàn diện cho ngành công nghiệp bán dẫn và điện tử.</p><h3>Tầm nhìn</h3><p>Trở thành nhà cung cấp thiết bị đo lường và giải pháp tự động hóa hàng đầu Việt Nam.</p><h3>Sứ mệnh</h3><p>Mang đến cho khách hàng những sản phẩm chất lượng cao, dịch vụ chuyên nghiệp và giải pháp tối ưu nhất.</p>',
                    'en' => '<h2>About Viam Semicon</h2><p>VIAM GLOBAL Co., Ltd is a professional distributor of measuring equipment, transport robots, and RF Cable & Adapters.</p>',
                ],
                'template' => 'default',
                'seo_title' => ['vi' => 'Giới thiệu về Viam Semicon - Nhà phân phối thiết bị đo lường', 'en' => 'About Viam Semicon'],
                'seo_description' => ['vi' => 'Công ty TNHH VIAM GLOBAL - Chuyên cung cấp thiết bị đo lường, robot vận chuyển, RF cable chính hãng tại Việt Nam.', 'en' => 'VIAM GLOBAL - Professional distributor of measuring equipment and transport robots.'],
            ],
        ];

        foreach ($pages as $data) {
            Page::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'content' => $data['content'],
                    'template' => $data['template'],
                    'is_active' => true,
                    'seo_title' => $data['seo_title'],
                    'seo_description' => $data['seo_description'],
                ]
            );
        }

        $this->command->info('Pages seeded: ' . count($pages));
    }

    private function downloadImage(string $url, string $folder): string
    {
        if (empty($url)) {
            return '';
        }

        try {
            $filename = $folder . '/' . Str::random(10) . '_' . basename(parse_url($url, PHP_URL_PATH));
            $response = Http::timeout(30)->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
            ])->get($url);

            if ($response->successful()) {
                Storage::disk('public')->put($filename, $response->body());
                return $filename;
            }
        } catch (\Exception $e) {
            $this->command->warn("Failed to download: {$url} - {$e->getMessage()}");
        }

        return '';
    }
}
