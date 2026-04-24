<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class HikrobotSataSeeder extends Seeder
{
    public function run(): void
    {
        // === HIKROBOT Categories ===
        $mvCategory = Category::updateOrCreate(
            ['slug' => 'machine-vision'],
            [
                'name' => ['vi' => 'Machine Vision', 'en' => 'Machine Vision'],
                'description' => ['vi' => 'Camera công nghiệp, cảm biến 3D, đầu đọc mã, phần mềm thị giác máy Hikrobot', 'en' => 'Industrial cameras, 3D sensors, code readers, machine vision software by Hikrobot'],
                'is_active' => true,
                'sort_order' => 20,
            ]
        );

        $mrCategory = Category::updateOrCreate(
            ['slug' => 'mobile-robot-hikrobot'],
            [
                'name' => ['vi' => 'Mobile Robot Hikrobot', 'en' => 'Hikrobot Mobile Robot'],
                'description' => ['vi' => 'Robot di động tự hành AMR Hikrobot: LMR, CMR, FMR, CTU, HMR', 'en' => 'Hikrobot Autonomous Mobile Robots: LMR, CMR, FMR, CTU, HMR'],
                'is_active' => true,
                'sort_order' => 21,
            ]
        );

        $sataCategory = Category::updateOrCreate(
            ['slug' => 'dung-cu-cam-tay-sata'],
            [
                'name' => ['vi' => 'Dụng cụ cầm tay SATA', 'en' => 'SATA Hand Tools'],
                'description' => ['vi' => 'Dụng cụ cầm tay chuyên nghiệp SATA: cờ lê, tuýp, tua vít, kìm, bộ dụng cụ', 'en' => 'SATA professional hand tools: wrenches, sockets, screwdrivers, pliers, tool sets'],
                'is_active' => true,
                'sort_order' => 22,
            ]
        );

        // === HIKROBOT Machine Vision Products ===
        $mvProducts = [
            [
                'name' => ['vi' => 'Camera công nghiệp Area Scan Hikrobot', 'en' => 'Hikrobot Area Scan Industrial Camera'],
                'short_description' => ['vi' => 'Camera quét vùng công nghiệp độ phân giải 0.3MP - 600MP, hỗ trợ GigE, 10GigE, USB3.0, Camera Link, CoaXPress', 'en' => 'Industrial area scan camera with 0.3MP to 600MP resolution, supporting GigE, 10GigE, USB3.0, Camera Link, CoaXPress'],
                'description' => ['vi' => '<p>Camera quét vùng công nghiệp Hikrobot với độ phân giải từ 0.3 đến 600 megapixel. Hỗ trợ đa dạng giao tiếp: GigE, 10GigE, USB3.0, Camera Link, CoaXPress và X-over-Fiber. Chất lượng hình ảnh xuất sắc, tương thích đa hệ thống MVS, đáp ứng nhu cầu đa dạng của khách hàng.</p><p>Ứng dụng: kiểm tra chất lượng sản phẩm, đo lường kích thước, nhận dạng vật thể trong sản xuất công nghiệp.</p>', 'en' => '<p>Hikrobot industrial area scan camera with resolution from 0.3 to 600 megapixels. Supporting multiple interfaces: GigE, 10GigE, USB3.0, Camera Link, CoaXPress and X-over-Fiber. Excellent image quality, multi-system MVS compatible.</p>'],
                'specifications' => [
                    ['key' => 'Độ phân giải', 'value' => '0.3MP - 600MP'],
                    ['key' => 'Giao tiếp', 'value' => 'GigE, 10GigE, USB3.0, Camera Link, CoaXPress'],
                    ['key' => 'Loại cảm biến', 'value' => 'CCD / CMOS'],
                    ['key' => 'Hãng', 'value' => 'Hikrobot'],
                ],
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => ['vi' => 'Camera Line Scan Hikrobot', 'en' => 'Hikrobot Line Scan Camera'],
                'short_description' => ['vi' => 'Camera quét dòng công nghiệp, độ phân giải 2K-16K, tốc độ quét cao cho kiểm tra liên tục', 'en' => 'Industrial line scan camera, 2K-16K resolution, high scan speed for continuous inspection'],
                'description' => ['vi' => '<p>Camera quét dòng Hikrobot với độ phân giải từ 2K đến 16K, thiết kế cho các ứng dụng kiểm tra liên tục trên dây chuyền sản xuất. Tốc độ quét cao, chất lượng hình ảnh sắc nét, phù hợp cho kiểm tra bề mặt, in ấn, dệt may và sản xuất điện tử.</p>', 'en' => '<p>Hikrobot line scan camera with 2K to 16K resolution, designed for continuous inspection on production lines.</p>'],
                'specifications' => [
                    ['key' => 'Độ phân giải', 'value' => '2K - 16K'],
                    ['key' => 'Giao tiếp', 'value' => 'GigE, Camera Link, CoaXPress'],
                    ['key' => 'Ứng dụng', 'value' => 'Kiểm tra bề mặt, in ấn, dệt may'],
                    ['key' => 'Hãng', 'value' => 'Hikrobot'],
                ],
                'is_featured' => false,
                'sort_order' => 2,
            ],
            [
                'name' => ['vi' => 'Camera 3D Laser Profiler Hikrobot', 'en' => 'Hikrobot 3D Laser Profiler'],
                'short_description' => ['vi' => 'Cảm biến 3D laser profiler đo lường chính xác cao, tạo point cloud và depth map thời gian thực', 'en' => '3D laser profiler sensor for high-precision measurement, real-time point cloud and depth map generation'],
                'description' => ['vi' => '<p>3D Laser Profiler Hikrobot dựa trên nguyên lý tam giác laser, xuất dữ liệu point cloud và depth map thời gian thực với độ chính xác micro-level. Ứng dụng rộng rãi trong đo lường 3D không tiếp xúc cho điện tử tiêu dùng, pin lithium-ion, PCB và nhiều ngành công nghiệp khác.</p>', 'en' => '<p>Hikrobot 3D Laser Profiler based on laser triangulation principle, outputs real-time point cloud and depth map with micro-level precision.</p>'],
                'specifications' => [
                    ['key' => 'Nguyên lý', 'value' => 'Laser triangulation'],
                    ['key' => 'Độ chính xác', 'value' => 'Micro-level'],
                    ['key' => 'Đầu ra', 'value' => 'Point cloud, Depth map, Luminance map'],
                    ['key' => 'Hãng', 'value' => 'Hikrobot'],
                ],
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => ['vi' => 'Camera 3D Stereo RGB-D Hikrobot', 'en' => 'Hikrobot RGB-D Stereo Camera'],
                'short_description' => ['vi' => 'Camera stereo 3D RGB-D cho hướng dẫn robot, hỗ trợ structured light và multi-line laser', 'en' => 'RGB-D stereo camera for robotic guidance, supporting structured light and multi-line laser'],
                'description' => ['vi' => '<p>Camera stereo 3D RGB-D Hikrobot sử dụng công nghệ binocular stereo imaging kết hợp camera màu. Hỗ trợ nhiều chế độ: structured light, vibrating mirror, multi-line laser. Đa dạng model để phủ nhiều trường quan sát khác nhau. Lý tưởng cho ứng dụng hướng dẫn robot pick-and-place.</p>', 'en' => '<p>Hikrobot RGB-D stereo camera using active binocular stereo imaging technology combined with color camera output.</p>'],
                'specifications' => [
                    ['key' => 'Công nghệ', 'value' => 'Active binocular stereo imaging'],
                    ['key' => 'Chế độ chiếu sáng', 'value' => 'Structured light, Vibrating mirror, Multi-line laser'],
                    ['key' => 'Ứng dụng', 'value' => 'Robotic vision guidance, Pick-and-place'],
                    ['key' => 'Hãng', 'value' => 'Hikrobot'],
                ],
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'name' => ['vi' => 'Smart Camera & ID Code Reader Hikrobot', 'en' => 'Hikrobot Smart Camera & ID Code Reader'],
                'short_description' => ['vi' => 'Camera thông minh và đầu đọc mã công nghiệp, AI decoding, deep learning OCR, tỷ lệ nhận dạng 99.99%', 'en' => 'Smart camera and industrial code reader with AI decoding, deep learning OCR, 99.99% recognition rate'],
                'description' => ['vi' => '<p>Dòng sản phẩm Smart & ID của Hikrobot bao gồm Smart Camera, Handheld Scanner, ID Code Reader và Vision Controller. Tích hợp thuật toán AI decoding và Deep Learning OCR với tỷ lệ nhận dạng lên đến 99.99%. Thiết kế nhỏ gọn, hiệu suất cao cho các ứng dụng nhận diện, phát hiện khuyết tật và đọc mã trong sản xuất.</p>', 'en' => '<p>Hikrobot Smart & ID product line includes Smart Camera, Handheld Scanner, ID Code Reader and Vision Controller with AI decoding and 99.99% recognition rate.</p>'],
                'specifications' => [
                    ['key' => 'Sản phẩm', 'value' => 'Smart Camera, Handheld Scanner, ID Code Reader, Vision Controller'],
                    ['key' => 'Tỷ lệ nhận dạng', 'value' => '99.99%'],
                    ['key' => 'Công nghệ', 'value' => 'AI decoding, Deep Learning OCR'],
                    ['key' => 'Hãng', 'value' => 'Hikrobot'],
                ],
                'is_featured' => false,
                'sort_order' => 5,
            ],
            [
                'name' => ['vi' => 'Frame Grabber Hikrobot', 'en' => 'Hikrobot Frame Grabber'],
                'short_description' => ['vi' => 'Card thu hình ảnh công nghiệp hỗ trợ GigE, 10GigE, USB3.0, Camera Link, CoaXPress', 'en' => 'Industrial frame grabber supporting GigE, 10GigE, USB3.0, Camera Link, CoaXPress'],
                'description' => ['vi' => '<p>Frame Grabber Hikrobot hỗ trợ đa giao tiếp: GigE, 10GigE, USB3.0, Camera Link, CoaXPress và X-over-Fiber. Tích hợp công nghệ non-packet loss và ToE độc quyền, đảm bảo truyền dữ liệu ổn định. Giải pháp FPGA cho card thu giúp giải phóng CPU, giải quyết vấn đề mất gói tin GigE.</p>', 'en' => '<p>Hikrobot frame grabber with GigE, 10GigE, USB3.0, Camera Link, CoaXPress and X-over-Fiber interfaces.</p>'],
                'specifications' => [
                    ['key' => 'Giao tiếp', 'value' => 'GigE, 10GigE, USB3.0, Camera Link, CoaXPress, X-over-Fiber'],
                    ['key' => 'Công nghệ', 'value' => 'Non-packet loss, ToE, FPGA'],
                    ['key' => 'Đồng bộ', 'value' => 'ToE trigger, độ chính xác 10ns'],
                    ['key' => 'Hãng', 'value' => 'Hikrobot'],
                ],
                'is_featured' => false,
                'sort_order' => 6,
            ],
        ];

        foreach ($mvProducts as $p) {
            Product::updateOrCreate(
                ['slug' => \Str::slug($p['name']['vi'])],
                array_merge($p, [
                    'category_id' => $mvCategory->id,
                    'price_text' => 'Liên hệ',
                    'is_active' => true,
                ])
            );
            echo "MV Product: {$p['name']['vi']}\n";
        }

        // === HIKROBOT Mobile Robot Products ===
        $mrProducts = [
            [
                'name' => ['vi' => 'Robot LMR - Latent Mobile Robot Hikrobot', 'en' => 'Hikrobot LMR - Latent Mobile Robot'],
                'short_description' => ['vi' => 'Robot di động ẩn dưới (chui gầm) Hikrobot, cơ chế nâng hạ tối ưu, bảo vệ an toàn nâng cao', 'en' => 'Hikrobot latent mobile robot with optimized lifting mechanism and enhanced safety protection'],
                'description' => ['vi' => '<p>LMR (Latent Mobile Robot) là dòng robot di động hàng đầu của Hikrobot, đặc trưng bởi cơ chế nâng hạ. Robot chui dưới kệ hàng, nâng và di chuyển toàn bộ kệ đến vị trí cần thiết. Hiệu suất di chuyển tối ưu, bảo vệ an toàn nâng cao. Ứng dụng trong e-commerce, 3PL, kho hàng, sản xuất.</p>', 'en' => '<p>LMR (Latent Mobile Robot) is Hikrobot\'s leading mobile robot product characterized by its lifting mechanism.</p>'],
                'specifications' => [
                    ['key' => 'Loại', 'value' => 'Latent Mobile Robot (LMR)'],
                    ['key' => 'Cơ chế', 'value' => 'Nâng hạ kệ hàng'],
                    ['key' => 'Điều hướng', 'value' => 'QR Code, SLAM'],
                    ['key' => 'Chứng nhận', 'value' => 'CE, KC'],
                    ['key' => 'Hãng', 'value' => 'Hikrobot'],
                ],
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => ['vi' => 'Robot CMR/HMR - Conveyor/Heavy-duty Mobile Robot Hikrobot', 'en' => 'Hikrobot CMR/HMR - Conveyor/Heavy-duty Mobile Robot'],
                'short_description' => ['vi' => 'Robot vận chuyển băng tải và tải nặng Hikrobot, đa dạng loại: conveyor, lifting, traction, heavy-duty', 'en' => 'Hikrobot conveyor and heavy-duty mobile robot with multiple types: conveyor, lifting, traction, heavy-duty'],
                'description' => ['vi' => '<p>CMR/HMR bao gồm nhiều loại: conveyor type, lifting type, traction type và heavy-duty type. Nhờ cơ chế tùy chỉnh cao, robot có thể tự động kết nối với các thiết bị trong nhiều kịch bản khác nhau. Ứng dụng trong ô tô, năng lượng mới, điện tử, dược phẩm.</p>', 'en' => '<p>CMR/HMR covers conveyor type, lifting type, traction type and heavy-duty type for different scenarios.</p>'],
                'specifications' => [
                    ['key' => 'Loại', 'value' => 'Conveyor, Lifting, Traction, Heavy-duty'],
                    ['key' => 'Tải trọng', 'value' => 'Tùy model (lên đến hàng tấn)'],
                    ['key' => 'Điều hướng', 'value' => 'SLAM, QR Code, Magnetic'],
                    ['key' => 'Hãng', 'value' => 'Hikrobot'],
                ],
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => ['vi' => 'Robot FMR - Forklift Mobile Robot Hikrobot', 'en' => 'Hikrobot FMR - Forklift Mobile Robot'],
                'short_description' => ['vi' => 'Robot xe nâng tự hành Hikrobot, vận chuyển pallet/thùng tiêu chuẩn, laser SLAM và vision navigation', 'en' => 'Hikrobot autonomous forklift robot for standard bins/pallets transfer with laser SLAM and vision navigation'],
                'description' => ['vi' => '<p>FMR (Forklift Mobile Robot) tập trung vào vận chuyển tự động các thùng và pallet tiêu chuẩn. Sử dụng laser SLAM navigation và vision navigation với độ chính xác cao. Phù hợp cho kho hàng, nhà máy sản xuất, logistics.</p>', 'en' => '<p>FMR focuses on automatic transfer of standard bins/pallets with high precision laser SLAM and vision navigation.</p>'],
                'specifications' => [
                    ['key' => 'Loại', 'value' => 'Forklift Mobile Robot (FMR)'],
                    ['key' => 'Vận chuyển', 'value' => 'Pallet, thùng tiêu chuẩn'],
                    ['key' => 'Điều hướng', 'value' => 'Laser SLAM, Vision navigation'],
                    ['key' => 'Hãng', 'value' => 'Hikrobot'],
                ],
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => ['vi' => 'Robot CTU - Carton Transfer Unit Hikrobot', 'en' => 'Hikrobot CTU - Carton Transfer Unit'],
                'short_description' => ['vi' => 'Robot vận chuyển thùng carton Hikrobot, lưu trữ mật độ cao, xuất nhập hàng chính xác', 'en' => 'Hikrobot carton transfer unit for high-density storage with precise inbound/outbound operations'],
                'description' => ['vi' => '<p>CTU (Carton Transfer Unit) có khả năng vận chuyển và lưu trữ đơn/đa thùng carton. Hệ thống xuất nhập hàng chính xác với lưu trữ mật độ cao, cung cấp khả năng picking hiệu quả. Phù hợp cho e-commerce, retail, dược phẩm.</p>', 'en' => '<p>CTU can transport or storage single/multiple bins with precise inbound/outbound and high-density storage.</p>'],
                'specifications' => [
                    ['key' => 'Loại', 'value' => 'Carton Transfer Unit (CTU)'],
                    ['key' => 'Tính năng', 'value' => 'High-density storage, Precise picking'],
                    ['key' => 'Ứng dụng', 'value' => 'E-commerce, Retail, Dược phẩm'],
                    ['key' => 'Hãng', 'value' => 'Hikrobot'],
                ],
                'is_featured' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($mrProducts as $p) {
            Product::updateOrCreate(
                ['slug' => \Str::slug($p['name']['vi'])],
                array_merge($p, [
                    'category_id' => $mrCategory->id,
                    'price_text' => 'Liên hệ',
                    'is_active' => true,
                ])
            );
            echo "MR Product: {$p['name']['vi']}\n";
        }

        // === SATA Hand Tools Products ===
        $sataProducts = [
            [
                'name' => ['vi' => 'Bộ dụng cụ tổng hợp SATA 150 chi tiết', 'en' => 'SATA 150-Piece Mechanic Tool Set'],
                'short_description' => ['vi' => 'Bộ dụng cụ chuyên nghiệp SATA 150 chi tiết: cờ lê, tuýp, tua vít, kìm, búa, lục giác', 'en' => 'SATA 150-piece professional tool set: wrenches, sockets, screwdrivers, pliers, hammers, hex keys'],
                'description' => ['vi' => '<p>Bộ dụng cụ tổng hợp SATA 150 chi tiết bao gồm đầy đủ các dụng cụ chuyên nghiệp: cờ lê X-beam ergonomic, tuýp socket 1/4" và 1/2", tua vít đa năng, kìm các loại, búa, cờ lê lục giác. Thiết kế X-beam ergonomic giúp tăng diện tích tiếp xúc tay gấp 5 lần, giảm mỏi tay khi sử dụng lâu.</p>', 'en' => '<p>SATA 150-piece comprehensive tool set with X-beam ergonomic wrenches, 1/4" and 1/2" sockets, screwdrivers, pliers, and more.</p>'],
                'specifications' => [
                    ['key' => 'Số chi tiết', 'value' => '150 chi tiết'],
                    ['key' => 'Bao gồm', 'value' => 'Cờ lê, Tuýp, Tua vít, Kìm, Búa, Lục giác'],
                    ['key' => 'Thiết kế', 'value' => 'X-beam ergonomic'],
                    ['key' => 'Hãng', 'value' => 'SATA (APEX Tool Group)'],
                ],
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => ['vi' => 'Bộ tuýp và cần siết SATA Socket & Ratchet', 'en' => 'SATA Socket & Ratchet Wrench Set'],
                'short_description' => ['vi' => 'Bộ tuýp socket và cần siết ratchet SATA chuyên nghiệp, 1/4", 3/8", 1/2" Dr.', 'en' => 'SATA professional socket and ratchet wrench set, 1/4", 3/8", 1/2" Dr.'],
                'description' => ['vi' => '<p>Bộ tuýp và cần siết ratchet SATA chất lượng cao với đa dạng kích cỡ 1/4", 3/8" và 1/2" Drive. Tuýp 6 cạnh (6Pt) cho khả năng bám chắc, cần siết quick-release ratchet tiện lợi. Chất liệu Chrome Vanadium thép cao cấp, mạ chrome chống rỉ.</p>', 'en' => '<p>SATA high-quality socket and ratchet set with 1/4", 3/8" and 1/2" Drive options.</p>'],
                'specifications' => [
                    ['key' => 'Kích cỡ Drive', 'value' => '1/4", 3/8", 1/2"'],
                    ['key' => 'Loại tuýp', 'value' => '6Pt Standard & Deep Socket'],
                    ['key' => 'Chất liệu', 'value' => 'Chrome Vanadium Steel'],
                    ['key' => 'Hãng', 'value' => 'SATA'],
                ],
                'is_featured' => false,
                'sort_order' => 2,
            ],
            [
                'name' => ['vi' => 'Cờ lê lực SATA Torque Wrench', 'en' => 'SATA Torque Wrench'],
                'short_description' => ['vi' => 'Cờ lê lực chính xác SATA, đo và kiểm soát mô-men xoắn cho lắp ráp công nghiệp', 'en' => 'SATA precision torque wrench for accurate torque control in industrial assembly'],
                'description' => ['vi' => '<p>Cờ lê lực SATA với khả năng đo và kiểm soát mô-men xoắn chính xác cao. Thiết kế cho ứng dụng lắp ráp ô tô, công nghiệp và bảo trì. Đa dạng dải đo phù hợp nhiều yêu cầu công việc.</p>', 'en' => '<p>SATA torque wrench with high-precision torque measurement and control for automotive and industrial applications.</p>'],
                'specifications' => [
                    ['key' => 'Loại', 'value' => 'Torque Wrench'],
                    ['key' => 'Ứng dụng', 'value' => 'Lắp ráp ô tô, công nghiệp, bảo trì'],
                    ['key' => 'Chất liệu', 'value' => 'Chrome Vanadium Steel'],
                    ['key' => 'Hãng', 'value' => 'SATA'],
                ],
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'name' => ['vi' => 'Bộ tua vít SATA Screwdriver Set', 'en' => 'SATA Screwdriver Set'],
                'short_description' => ['vi' => 'Bộ tua vít chuyên nghiệp SATA đa năng: dẹt, phillips, torx, precision', 'en' => 'SATA professional screwdriver set: flat, phillips, torx, precision'],
                'description' => ['vi' => '<p>Bộ tua vít SATA chuyên nghiệp bao gồm nhiều loại đầu: dẹt (flat), chữ thập (phillips), torx, và precision cho điện tử. Tay cầm ergonomic chống trượt, lưỡi thép Chrome Vanadium bền bỉ.</p>', 'en' => '<p>SATA professional screwdriver set with multiple tip types and ergonomic anti-slip handles.</p>'],
                'specifications' => [
                    ['key' => 'Loại đầu', 'value' => 'Flat, Phillips, Torx, Precision'],
                    ['key' => 'Tay cầm', 'value' => 'Ergonomic chống trượt'],
                    ['key' => 'Chất liệu', 'value' => 'Chrome Vanadium Steel'],
                    ['key' => 'Hãng', 'value' => 'SATA'],
                ],
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'name' => ['vi' => 'Kìm các loại SATA Pliers', 'en' => 'SATA Pliers Set'],
                'short_description' => ['vi' => 'Kìm chuyên nghiệp SATA: kìm cắt, kìm mỏ nhọn, kìm tổ hợp, kìm bấm', 'en' => 'SATA professional pliers: cutting, needle-nose, combination, locking pliers'],
                'description' => ['vi' => '<p>Bộ kìm chuyên nghiệp SATA bao gồm kìm cắt, kìm mỏ nhọn, kìm tổ hợp, kìm bấm (locking pliers). Chất liệu thép cao cấp, lưỡi cắt sắc bén, tay cầm bọc nhựa chống trượt. Đạt tiêu chuẩn công nghiệp quốc tế.</p>', 'en' => '<p>SATA professional pliers including cutting, needle-nose, combination and locking pliers.</p>'],
                'specifications' => [
                    ['key' => 'Loại', 'value' => 'Kìm cắt, Kìm mỏ nhọn, Kìm tổ hợp, Kìm bấm'],
                    ['key' => 'Chất liệu', 'value' => 'Thép cao cấp Chrome Vanadium'],
                    ['key' => 'Tay cầm', 'value' => 'Bọc nhựa chống trượt'],
                    ['key' => 'Hãng', 'value' => 'SATA'],
                ],
                'is_featured' => false,
                'sort_order' => 5,
            ],
            [
                'name' => ['vi' => 'Tủ dụng cụ SATA Tool Storage', 'en' => 'SATA Tool Storage Cabinet'],
                'short_description' => ['vi' => 'Tủ đựng dụng cụ SATA chuyên nghiệp: tủ di động, tủ công nghiệp, hộp dụng cụ', 'en' => 'SATA professional tool storage: roller cabinets, industrial cabinets, toolboxes'],
                'description' => ['vi' => '<p>Hệ thống tủ đựng dụng cụ SATA chuyên nghiệp bao gồm tủ di động (roller cabinet), tủ công nghiệp thông minh (intelligent industrial storage cabinet), hộp dụng cụ kim loại và nhôm. Tủ công nghiệp thông minh quản lý đến 448 loại vật tư, tiết kiệm 80% thời gian nhận vật tư.</p>', 'en' => '<p>SATA professional tool storage system including roller cabinets, intelligent industrial storage cabinets and toolboxes.</p>'],
                'specifications' => [
                    ['key' => 'Loại', 'value' => 'Roller Cabinet, Industrial Cabinet, Toolbox'],
                    ['key' => 'Chất liệu', 'value' => 'Thép 1.2mm, Hợp kim nhôm'],
                    ['key' => 'Tủ thông minh', 'value' => 'Quản lý 448 loại vật tư, tiết kiệm 80% thời gian'],
                    ['key' => 'Hãng', 'value' => 'SATA'],
                ],
                'is_featured' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($sataProducts as $p) {
            Product::updateOrCreate(
                ['slug' => \Str::slug($p['name']['vi'])],
                array_merge($p, [
                    'category_id' => $sataCategory->id,
                    'price_text' => 'Liên hệ',
                    'is_active' => true,
                ])
            );
            echo "SATA Product: {$p['name']['vi']}\n";
        }

        echo "\nDone! Added " . count($mvProducts) . " Machine Vision + " . count($mrProducts) . " Mobile Robot + " . count($sataProducts) . " SATA products\n";
    }
}
