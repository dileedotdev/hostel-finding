# Hướng dẫn cài đặt phiển bản demo

## Môi trường yêu cầu

- Sản phẩm được phát triển trên môi trừng Ubuntu (Window có thể phát sinh lỗi không mong muốn)
- PHP phiên bản 8.2 và đã cài các extension cho laravel (openssl php8.1-common php8.2-bcmath php8.2-curl php8.2-json php8.2-mbstring php8.2-mysql php8.2-tokenizer php8.2-xml php8.2-zip)
- Composer phiển bản 2
- MySQL phiên bản 8

## Bước 1 - Cài đặt các gói phụ thuộc (packages)

Đầu tiên cần cd vào thư mục source-code -> Đối với php ta sử dụng composer

```bash
composer install
```

## Bước 2 - Cài đặt biến môi trường cho Database MySQL và migration database

Đầu tiên ta vào trong file `.env` và thay các giá trị thích hợp vào các biến môi trường dưới đây

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hostel_finding
DB_USERNAME=root
DB_PASSWORD=
```

Tiếp theo ta cần migration database (tạo các bảng thích hợp trên MySQL) và fake dữ liệu cho dự án demo bằng câu lệnh sau (cần `cd` vào thư mục của dự án)

```bash
php artisan migrate:fresh --seed --force
```

Nếu không chạy thành công có thể là do các biến môi trường của MySQL sai

## Bước 3 - tạo liên kết storage

Chạy câu lệnh sau đây

```bash
php artisan storage:link
```

## Bước 3 - Chạy dự án

Chạy dự án bằng câu lệnh sau

```bash
php artisan serve --port=8000
```

Theo mặc định dự án sẽ chạy ở localhost và port 8000 nhưng nếu port đó đã sử dụng thì ta có thể thay port khác nhưng cần cập nhật `APP_URL`, `FACEBOOK_REDIRECT_URI`, `GOOGLE_REDIRECT_URI` ở file `.env` thành port tương ứng

## Bước 4 - truy cập dự án

Khi dự án chạy thành công bạn có thể truy cập dự án bằng đường dẫn http://localhost:8000 (bắt buộc là http và localhost tại vì dự án sử dụng nhiều dịch vụ bên ngoài nên chỉ có thể sử dùng miễn phí tại localhost)

## Các tài khoản có sẵn cho demo

- Tài khoản Admin: admin@admin.admin – mật khẩu: password
- Tài khoản supervisor: supervisor@example.com – mật khẩu: password
- Tài khoản chủ nhà trọ: hosteller@example.com – mật khẩu: password








