# DANH SÁCH CÁC ĐƯỜNG DẪN GIAO DIỆN - ĐỚ STORE

Tài liệu này tổng hợp các đường dẫn (Router) chính để truy cập vào các giao diện tính năng của website Đớ Store.

## 1. Khu vực Người dùng (Frontend)

Hệ thống sử dụng mô hình MVC với Router tự động: `domain/controller/method/params`.

| Tính năng | Đường dẫn (URL) | Mô tả |
| :--- | :--- | :--- |
| **Trang chủ** | `/home/index` hoặc `/` | Trang chủ hiển thị banner, sản phẩm mới và bộ sưu tập. |
| **Giới thiệu** | `/home/about` | Trang thông tin giới thiệu về thương hiệu Đớ Store. |
| **Sản phẩm** | `/product/index` | Danh sách toàn bộ sản phẩm. Hỗ trợ tìm kiếm (`?q=...`) và lọc theo danh mục, giới tính. |
| **Chi tiết sản phẩm** | `/product/detail/{slug}` | Xem chi tiết một sản phẩm cụ thể, chọn size và thêm vào giỏ hàng. |
| **Giỏ hàng** | `/cart/index` | Xem và quản lý các sản phẩm đã thêm vào giỏ hàng. |
| **Thanh toán** | `/order/checkout` | Nhập thông tin khách hàng và chọn phương thức thanh toán. (Yêu cầu đăng nhập). |
| **Theo dõi đơn hàng** | `/order/tracking` | Tra cứu trạng thái đơn hàng. Có thể truy cập trực tiếp qua `/order/tracking/{order_code}`. |
| **Đăng nhập** | `/auth/login` | Giao diện đăng nhập cho khách hàng. |
| **Đăng ký** | `/auth/register` | Giao diện đăng ký tài khoản mới. |
| **Trang cá nhân** | `/user/profile` | Quản lý thông tin cá nhân và xem lịch sử đơn hàng. (Yêu cầu đăng nhập). |

## 2. Thông tin Kỹ thuật

### Cấu trúc thư mục chính:
- **Controllers**: `app/controllers/` (Xử lý logic điều hướng)
- **Models**: `app/models/` (Tương tác với cơ sở dữ liệu)
- **Views**: `app/views/` (Giao diện người dùng)
- **Public Assets**: `public/` (Chứa CSS, JS, hình ảnh sản phẩm)

### Cách chạy dự án (Localhost):
1. Copy thư mục `shop_giay` vào thư mục `htdocs` của XAMPP.
2. Khởi động Apache và MySQL.
3. Import file `schema.sql` vào MySQL (Tạo database `shop_giay_admin`).
4. Truy cập: `http://localhost/shop_giay/`

---
*Lưu ý: Một số liên kết trong menu (như Tin tức, Liên hệ, Quản trị) hiện đang là placeholder hoặc đang trong quá trình phát triển.*
