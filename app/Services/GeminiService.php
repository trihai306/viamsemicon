<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class GeminiService
{
    private string $apiKey;
    private string $modelText;
    private string $modelVision;
    private int $timeout;
    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key', '');
        $this->modelText = config('services.gemini.model_text', 'gemini-2.5-flash');
        $this->modelVision = config('services.gemini.model_vision', 'gemini-2.5-flash');
        $this->timeout = config('services.gemini.timeout', 120);
    }

    public function generateArticle(string $topic, string $categoryType = 'tin-tuc'): array
    {
        $categoryLabel = $categoryType === 'tuyen-dung' ? 'tuyển dụng' : 'tin tức công nghệ';

        $prompt = <<<PROMPT
Bạn là chuyên gia viết content cho Viam Semicon - công ty phân phối thiết bị đo lường, linh kiện bán dẫn, RF Cable & Adapters và Robot vận chuyển tại Việt Nam.

Viết bài {$categoryLabel} chuyên nghiệp về chủ đề: "{$topic}"

YÊU CẦU TIẾNG VIỆT:
- Viết 1200-1800 từ, chuyên sâu, hữu ích
- HTML thuần: dùng <h2>, <h3>, <p>, <ul>, <li>, <ol>, <strong>, <em>, <blockquote>, <table>, <tr>, <th>, <td>
- KHÔNG dùng <html>, <body>, <head>, <h1>
- Cấu trúc: mở bài hấp dẫn → 4-5 phần nội dung với h2 → bảng so sánh nếu phù hợp → kết luận kêu gọi hành động
- Giọng văn chuyên nghiệp, B2B, đáng tin cậy
- Cuối bài thêm CTA liên hệ Viam Semicon

SAU ĐÓ viết phiên bản TIẾNG ANH (800-1000 từ) cùng cấu trúc.

FORMAT OUTPUT CHÍNH XÁC:
===VIETNAMESE===
[HTML tiếng Việt ở đây]
===ENGLISH===
[HTML tiếng Anh ở đây]
===EXCERPT_VI===
[Tóm tắt tiếng Việt 1-2 câu, dưới 200 ký tự, không HTML]
===EXCERPT_EN===
[English excerpt 1-2 sentences, under 200 chars, no HTML]
PROMPT;

        $raw = $this->callTextApi($prompt);
        return $this->parseArticleResponse($raw);
    }

    public function generateSeo(string $contentVi, string $titleVi = ''): array
    {
        $truncated = mb_substr(strip_tags($contentVi), 0, 2000);

        $prompt = <<<PROMPT
Bạn là chuyên gia SEO cho Viam Semicon (phân phối thiết bị đo lường, linh kiện bán dẫn Việt Nam).

Tiêu đề bài viết: {$titleVi}
Nội dung: {$truncated}

Tạo SEO tối ưu:
1. SEO Title tiếng Việt (50-60 ký tự, chứa từ khóa chính, cuối thêm "| Viam Semicon")
2. Meta Description tiếng Việt (150-160 ký tự, hấp dẫn, kêu gọi hành động)
3. SEO Title tiếng Anh (50-60 chars, with keywords)
4. Meta Description tiếng Anh (150-160 chars)

FORMAT CHÍNH XÁC:
===VI_TITLE===
[SEO title VI]
===VI_DESC===
[Meta description VI]
===EN_TITLE===
[SEO title EN]
===EN_DESC===
[Meta description EN]
PROMPT;

        $raw = $this->callTextApi($prompt);
        return $this->parseSeoResponse($raw);
    }

    public function generateProductDescription(string $productName, string $category = ''): array
    {
        $categoryContext = $category ? " thuộc danh mục \"{$category}\"" : '';

        $prompt = <<<PROMPT
Bạn là chuyên gia viết mô tả sản phẩm cho Viam Semicon - công ty phân phối thiết bị đo lường, linh kiện bán dẫn, RF Cable & Adapters, Robot vận chuyển tại Việt Nam.

Viết mô tả sản phẩm: "{$productName}"{$categoryContext}

YÊU CẦU:
1. MÔ TẢ NGẮN tiếng Việt (2-3 câu, dưới 200 ký tự, highlight tính năng chính)
2. MÔ TẢ CHI TIẾT tiếng Việt (HTML, 500-800 từ):
   - Giới thiệu sản phẩm
   - Tính năng nổi bật (dùng <ul><li>)
   - Ứng dụng thực tế
   - Lý do chọn mua tại Viam Semicon
   - Dùng thẻ <h2>, <h3>, <p>, <ul>, <li>, <strong>, <table> nếu phù hợp
   - KHÔNG dùng <h1>, <html>, <body>
3. MÔ TẢ NGẮN tiếng Anh (2-3 sentences)
4. MÔ TẢ CHI TIẾT tiếng Anh (HTML, 300-500 words)

FORMAT CHÍNH XÁC:
===SHORT_VI===
[mô tả ngắn VI, không HTML]
===DESC_VI===
[mô tả chi tiết VI, HTML]
===SHORT_EN===
[short description EN, no HTML]
===DESC_EN===
[detailed description EN, HTML]
PROMPT;

        $raw = $this->callTextApi($prompt);
        return $this->parseProductDescResponse($raw);
    }

    public function generateProductSpecs(string $productName, string $category = ''): array
    {
        $prompt = <<<PROMPT
Bạn là kỹ sư điện tử chuyên về thiết bị đo lường và linh kiện bán dẫn.

Tạo bảng thông số kỹ thuật cho sản phẩm: "{$productName}" (danh mục: {$category})

Yêu cầu:
- Liệt kê 8-15 thông số kỹ thuật quan trọng nhất
- Mỗi thông số gồm: tên thông số và giá trị
- Giá trị phải thực tế, chính xác cho loại sản phẩm này
- Bao gồm: kích thước, trọng lượng, dải tần/dải đo, độ chính xác, nguồn điện, chuẩn kết nối...

FORMAT: mỗi dòng là "tên thông số|giá trị", KHÔNG có header, KHÔNG có dòng trống thừa.
Ví dụ:
Dải tần số|9 kHz - 26.5 GHz
Độ chính xác|±0.05 dB
Trọng lượng|12.5 kg
PROMPT;

        $raw = $this->callTextApi($prompt);
        return $this->parseSpecsResponse($raw);
    }

    public function generateProductSeo(string $productName, string $shortDesc = ''): array
    {
        $prompt = <<<PROMPT
Tạo SEO cho sản phẩm "{$productName}" của Viam Semicon (phân phối thiết bị đo lường, linh kiện bán dẫn Việt Nam).
Mô tả ngắn: {$shortDesc}

FORMAT CHÍNH XÁC:
===VI_TITLE===
[SEO title VI, 50-60 ký tự, chứa tên sản phẩm + "| Viam Semicon"]
===VI_DESC===
[Meta description VI, 150-160 ký tự, hấp dẫn]
===EN_TITLE===
[SEO title EN, 50-60 chars]
===EN_DESC===
[Meta description EN, 150-160 chars]
PROMPT;

        $raw = $this->callTextApi($prompt);
        return $this->parseSeoResponse($raw);
    }

    public function enhanceImage(string $absoluteFilePath, string $enhancement = 'professional'): string
    {
        if (!file_exists($absoluteFilePath)) {
            throw new RuntimeException("File không tồn tại: {$absoluteFilePath}");
        }

        $fileSize = filesize($absoluteFilePath);
        if ($fileSize > 10 * 1024 * 1024) {
            throw new RuntimeException('File ảnh quá lớn (tối đa 10MB).');
        }

        $imageData = base64_encode(file_get_contents($absoluteFilePath));
        $mimeType = mime_content_type($absoluteFilePath) ?: 'image/jpeg';

        $enhancementPrompt = match ($enhancement) {
            'professional' => 'Enhance this product image for a professional B2B electronics website: improve brightness, contrast, sharpness, color accuracy. Make it look crisp, clean and business-appropriate. Keep the product as the main focus.',
            'bright' => 'Brighten this image significantly, enhance colors and make it vibrant for web display.',
            'background' => 'Clean up the background of this product image - make it white or neutral, keep the product sharp and centered.',
            default => 'Enhance this image for professional business website use.',
        };

        $url = "{$this->baseUrl}/{$this->modelVision}:generateContent?key={$this->apiKey}";

        $response = Http::timeout($this->timeout)
            ->post($url, [
                'contents' => [[
                    'parts' => [
                        ['text' => $enhancementPrompt],
                        [
                            'inline_data' => [
                                'mime_type' => $mimeType,
                                'data' => $imageData,
                            ],
                        ],
                    ],
                ]],
                'generationConfig' => [
                    'responseModalities' => ['TEXT', 'IMAGE'],
                ],
            ]);

        if ($response->failed()) {
            Log::error('Gemini image API error', ['status' => $response->status(), 'body' => $response->body()]);
            throw new RuntimeException('Gemini image API lỗi: ' . $response->status());
        }

        $data = $response->json();
        $parts = $data['candidates'][0]['content']['parts'] ?? [];

        foreach ($parts as $part) {
            if (isset($part['inlineData']['data'])) {
                return $part['inlineData']['data'];
            }
        }

        throw new RuntimeException('Gemini không trả về dữ liệu hình ảnh. Model có thể không hỗ trợ image output.');
    }

    public function generateImage(string $description, string $style = 'product'): string
    {
        $stylePrompt = match ($style) {
            'product' => "Create a professional product photograph for a B2B electronics company website. The image should show: {$description}. Style: clean white background, studio lighting, high resolution, commercial product photography, sharp focus.",
            'banner' => "Create a professional website banner image for an electronics company. The image should depict: {$description}. Style: modern, corporate, wide format, vibrant colors, technology-focused.",
            'thumbnail' => "Create a blog article thumbnail image about: {$description}. Style: eye-catching, modern design, technology theme, suitable for article preview card.",
            default => "Create a professional image: {$description}. Style: clean, modern, business-appropriate.",
        };

        $url = "{$this->baseUrl}/{$this->modelVision}:generateContent?key={$this->apiKey}";

        $response = Http::timeout($this->timeout)
            ->post($url, [
                'contents' => [[
                    'parts' => [
                        ['text' => $stylePrompt],
                    ],
                ]],
                'generationConfig' => [
                    'responseModalities' => ['TEXT', 'IMAGE'],
                ],
            ]);

        if ($response->failed()) {
            Log::error('Gemini generate image error', ['status' => $response->status(), 'body' => $response->body()]);
            throw new RuntimeException('Tạo ảnh AI lỗi: ' . $response->status());
        }

        $data = $response->json();
        $parts = $data['candidates'][0]['content']['parts'] ?? [];

        foreach ($parts as $part) {
            if (isset($part['inlineData']['data'])) {
                return $part['inlineData']['data'];
            }
        }

        throw new RuntimeException('Gemini không tạo được hình ảnh. Vui lòng thử lại với mô tả khác.');
    }

    private function callTextApi(string $prompt): string
    {
        if (empty($this->apiKey)) {
            throw new RuntimeException('GEMINI_API_KEY chưa được cấu hình trong .env');
        }

        $models = [$this->modelText, 'gemini-3-flash-preview', 'gemini-2.5-flash-lite'];

        $perModelTimeout = min(60, (int) ($this->timeout / count($models)));

        foreach ($models as $model) {
            $url = "{$this->baseUrl}/{$model}:generateContent?key={$this->apiKey}";

            try {
                $response = Http::timeout($perModelTimeout)
                    ->post($url, [
                        'contents' => [[
                            'parts' => [['text' => $prompt]],
                        ]],
                        'generationConfig' => [
                            'temperature' => 0.7,
                            'maxOutputTokens' => 8192,
                        ],
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    if (!empty($text)) {
                        Log::info("Gemini API success with model: {$model}");
                        return $text;
                    }
                }

                if ($response->status() === 503 || $response->status() === 429 || $response->status() === 404) {
                    Log::warning("Gemini model {$model} unavailable ({$response->status()}), trying next...");
                    continue;
                }

                Log::error('Gemini API error', ['model' => $model, 'status' => $response->status(), 'body' => $response->body()]);
                throw new RuntimeException('Gemini API lỗi: ' . $response->status() . ' - ' . $response->json('error.message', 'Unknown error'));
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                Log::warning("Gemini model {$model} timeout, trying next...");
                continue;
            }
        }

        throw new RuntimeException('Tất cả các model Gemini đều đang quá tải. Vui lòng thử lại sau vài phút.');
    }

    private function parseArticleResponse(string $raw): array
    {
        $vi = '';
        $en = '';
        $excerptVi = '';
        $excerptEn = '';

        if (preg_match('/===VIETNAMESE===\s*(.*?)\s*===ENGLISH===/s', $raw, $m)) {
            $vi = trim($m[1]);
        }
        if (preg_match('/===ENGLISH===\s*(.*?)\s*===EXCERPT_VI===/s', $raw, $m)) {
            $en = trim($m[1]);
        } elseif (preg_match('/===ENGLISH===\s*(.*?)$/s', $raw, $m)) {
            $en = trim($m[1]);
        }
        if (preg_match('/===EXCERPT_VI===\s*(.*?)\s*===EXCERPT_EN===/s', $raw, $m)) {
            $excerptVi = trim($m[1]);
        }
        if (preg_match('/===EXCERPT_EN===\s*(.*?)$/s', $raw, $m)) {
            $excerptEn = trim($m[1]);
        }

        if (empty($vi)) {
            $vi = $raw;
        }

        // Clean markdown code fences if present
        $vi = preg_replace('/^```html?\s*/m', '', $vi);
        $vi = preg_replace('/```\s*$/m', '', $vi);
        $en = preg_replace('/^```html?\s*/m', '', $en);
        $en = preg_replace('/```\s*$/m', '', $en);

        return [
            'vi' => trim($vi),
            'en' => trim($en),
            'excerpt_vi' => $excerptVi,
            'excerpt_en' => $excerptEn,
        ];
    }

    private function parseSeoResponse(string $raw): array
    {
        $extract = function (string $tag, string $text): string {
            if (preg_match("/==={$tag}===\s*(.*?)\s*(?====|$)/s", $text, $m)) {
                return trim($m[1]);
            }
            return '';
        };

        return [
            'vi' => [
                'title' => $extract('VI_TITLE', $raw),
                'description' => $extract('VI_DESC', $raw),
            ],
            'en' => [
                'title' => $extract('EN_TITLE', $raw),
                'description' => $extract('EN_DESC', $raw),
            ],
        ];
    }

    private function parseProductDescResponse(string $raw): array
    {
        $extract = function (string $tag, string $nextTag, string $text): string {
            if ($nextTag && preg_match("/==={$tag}===\s*(.*?)\s*==={$nextTag}===/s", $text, $m)) {
                return trim($m[1]);
            }
            if (preg_match("/==={$tag}===\s*(.*?)$/s", $text, $m)) {
                return trim($m[1]);
            }
            return '';
        };

        $clean = function (string $html): string {
            $html = preg_replace('/^```html?\s*/m', '', $html);
            $html = preg_replace('/```\s*$/m', '', $html);
            return trim($html);
        };

        return [
            'short_vi' => $extract('SHORT_VI', 'DESC_VI', $raw),
            'desc_vi' => $clean($extract('DESC_VI', 'SHORT_EN', $raw)),
            'short_en' => $extract('SHORT_EN', 'DESC_EN', $raw),
            'desc_en' => $clean($extract('DESC_EN', '', $raw)),
        ];
    }

    private function parseSpecsResponse(string $raw): array
    {
        $specs = [];
        $lines = explode("\n", trim($raw));
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || str_starts_with($line, '```')) continue;
            if (str_contains($line, '|')) {
                [$key, $value] = array_map('trim', explode('|', $line, 2));
                if (!empty($key) && !empty($value) && !str_contains(strtolower($key), 'thông số') && !str_contains(strtolower($key), '---')) {
                    $specs[$key] = $value;
                }
            }
        }
        return $specs;
    }
}
