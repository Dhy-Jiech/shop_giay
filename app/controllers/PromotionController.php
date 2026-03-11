<?php
// app/controllers/PromotionController.php

class PromotionController extends Controller
{
    public function check()
    {
        // Nhận dữ liệu JSON từ request
        $input = json_decode(file_get_contents('php://input'), true);
        
        $code = $input['code'] ?? '';
        $total = $input['total'] ?? 0;
        
        if (empty($code)) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Vui lòng nhập mã khuyến mãi'
            ]);
        }

        $promotionModel = $this->model('Promotion');
        $result = $promotionModel->calculateDiscount($code, $total);
        
        return $this->jsonResponse([
            'success' => $result['success'],
            'message' => $result['message'] ?? null,
            'discount_amount' => $result['discount'] ?? 0
        ]);
    }

    protected function jsonResponse($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}