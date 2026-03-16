<?php

class AiController extends Controller {
    private $productModel;

    public function __construct() {
        $this->productModel = $this->model('Product'); 
    }

    public function chat() {
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $userMessage = $input['message'] ?? '';

            if (empty($userMessage)) {
                echo json_encode(['reply' => 'Chào bạn! ĐỚ Store có thể giúp gì cho bạn?']);
                return;
            }

            $apiKey = "AIzaSyAyfLiVJ2Ukmtf1E_foFBi9sCXKNI54ndU"; 
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.1-flash-lite-preview:generateContent?key=" . $apiKey;

            $productListString = "";
            if ($this->productModel) {
                $products = $this->productModel->getAll(); 
                foreach($products as $p) {
                    /**
                     * SỬA LỖI TẠI ĐÂY: 
                     * Lấy cột 'slug' thay vì 'id' để khớp với hàm detail($slug) trong ProductController
                     *
                     */
                    $slug = $p['slug'] ?? ''; 
                    $productUrl = "index.php?url=product/detail/" . $slug;
                    
                    $productListString .= "- {$p['name']}: " . number_format($p['price']) . "đ. <a href='{$productUrl}' style='color: #d32f2f; font-weight: bold;'>[Xem chi tiết]</a>\n";
                }
            }

            $prompt = "Bạn là trợ lý ảo thân thiện của ĐỚ Store (Doha Sneaker Store). " .
                      "Dựa vào danh sách sau để tư vấn cho khách:\n\n" . 
                      $productListString . 
                      "\n\nYÊU CẦU QUAN TRỌNG:\n" .
                      "- Trả lời thật ngắn gọn.\n" .
                      "- Mỗi sản phẩm nằm trên một dòng riêng.\n" .
                      "- GIỮ NGUYÊN thẻ <a href='...'>[Xem chi tiết]</a> ở cuối mỗi sản phẩm.\n\n" .
                      "Câu hỏi khách: " . $userMessage;

            $data = ["contents" => [["parts" => [["text" => $prompt]]]]];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            
            $response = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($response, true);
            $aiResponse = $result['candidates'][0]['content']['parts'][0]['text'] ?? "Hệ thống AI đang bận.";

            echo json_encode(['reply' => nl2br(trim($aiResponse))]);

        } catch (Exception $e) {
echo json_encode(['reply' => 'Lỗi kết nối: ' . $e->getMessage()]);
        }
        exit; 
    }
}
