<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeaturesSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            [
                'title' => ['vi' => 'KIỂM TRA CHẤT LƯỢNG', 'en' => 'QUALITY INSPECTION'],
                'description' => [
                    'vi' => 'Kiểm tra chất lượng đóng một vai trò quyết định trong việc đảm bảo rằng mỗi sản phẩm tuân thủ các tiêu chuẩn nghiêm ngặt. Sự tin tưởng vào chất lượng của sản phẩm và dịch vụ được củng cố thông qua quy trình này, đảm bảo một sự hài lòng đồng thời định đoạt sự thịnh vượng của doanh nghiệp một cách vững chắc và bền vững.',
                    'en' => 'Quality inspection plays a decisive role in ensuring that each product complies with strict standards. Trust in the quality of products and services is strengthened through this process.',
                ],
                'icon' => 'shield-check',
                'sort_order' => 1,
            ],
            [
                'title' => ['vi' => 'CHUYÊN GIA KINH NGHIỆM', 'en' => 'EXPERT EXPERIENCE'],
                'description' => [
                    'vi' => 'Đội ngũ chuyên gia tận tâm và giàu kinh nghiệm của chúng tôi trong lĩnh vực điện tử sở hữu kiến thức sâu rộng và luôn đam mê công việc. Sự chuyên nghiệp và hiểu biết của đội ngũ chúng tôi là một nguồn tài nguyên vô cùng quý báu, đảm bảo giúp quý khách hàng vượt qua mọi khó khăn và đạt được những thành công bền vững.',
                    'en' => 'Our dedicated and experienced team of experts in the electronics field possesses extensive knowledge and is always passionate about their work.',
                ],
                'icon' => 'users',
                'sort_order' => 2,
            ],
            [
                'title' => ['vi' => 'CÔNG CỤ – DỤNG CỤ HỖ TRỢ', 'en' => 'SUPPORT TOOLS'],
                'description' => [
                    'vi' => 'Công cụ và dụng cụ hỗ trợ công nghiệp luôn là đối tác đáng tin cậy trong quá trình sản xuất. Chúng tôi giúp tối ưu hóa hiệu suất, tăng độ chính xác và giảm nguy cơ lỗi. Đó là Sự kết hợp của sáng tạo và công nghệ tiên tiến trong từng sản phẩm mang lại yên tâm cho các doanh nghiệp.',
                    'en' => 'Industrial support tools are always reliable partners in the production process. We help optimize performance, increase accuracy and reduce risk of errors.',
                ],
                'icon' => 'wrench',
                'sort_order' => 3,
            ],
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
}
