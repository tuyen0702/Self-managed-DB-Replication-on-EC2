# Self-managed-DB-Replication-on-EC2
Demo Web PHP sử dụng MySQL Primary–Standby trên AWS EC2 với cơ chế Failover
# EC2 MySQL Primary–Standby Demo

## 1. Giới thiệu
Dự án demo triển khai hệ thống Web PHP kết hợp MySQL Primary–Standby trên AWS EC2,
mô phỏng cơ chế High Availability và Failover ở tầng ứng dụng.

## 2. Kiến trúc hệ thống
- 1 EC2 Web Server (Apache + PHP)
- 1 EC2 MySQL Primary
- 1 EC2 MySQL Standby (Replication)
- Failover được xử lý trong code PHP

![Architecture](architecture/aws-architecture.png)

## 3. Công nghệ sử dụng
- AWS EC2
- Amazon Linux 2023
- Apache + PHP
- MariaDB (MySQL compatible)

## 4. Cấu trúc thư mục


## 5. Triển khai nhanh
1. Cài MySQL trên 2 EC2
2. Cấu hình replication Primary–Standby
3. Deploy code PHP lên Web Server
4. Truy cập website và demo failover

## 6. Demo Failover
- Khi Primary DB dừng dịch vụ
- Web tự động chuyển sang Standby
- Dữ liệu không bị mất

Chi tiết xem: `demo/demo-steps.md`
