-- Create the news database
CREATE DATABASE IF NOT EXISTS news_portal;
USE news_portal;

-- Create the news table
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL,
    publish_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    views INT DEFAULT 0
);

-- Insert sample data
INSERT INTO news (title, content, image_url, category, publish_date) VALUES
(
    'Bóng đá Việt Nam: Những bước tiến mới',
    'Đội tuyển bóng đá Việt Nam tiếp tục gặt hái thành công trên đấu trường quốc tế, khẳng định vị thế mới trong khu vực Đông Nam Á. Với những chiến thắng quan trọng gần đây, đội tuyển đã chứng minh được sự phát triển vượt bậc về mặt chuyên môn và tinh thần thi đấu.

Những điểm nổi bật trong thời gian qua:
1. Chiến thắng trước các đối thủ mạnh trong khu vực
2. Sự phát triển của các cầu thủ trẻ
3. Chiến thuật linh hoạt của huấn luyện viên
4. Sự ủng hộ nhiệt tình từ người hâm mộ

Với những thành tích này, bóng đá Việt Nam đang từng bước khẳng định vị thế của mình trên bản đồ bóng đá châu Á.',
    'hinh/bd1.jpg',
    'The Thao',
    '2024-03-15 10:00:00'
),
(
    'Công nghệ AI: Xu hướng mới trong năm 2024',
    'Trí tuệ nhân tạo (AI) đang trở thành xu hướng công nghệ hàng đầu trong năm 2024. Với những tiến bộ vượt bậc trong lĩnh vực machine learning và deep learning, AI đang thay đổi cách chúng ta làm việc và sinh hoạt hàng ngày.

Các ứng dụng chính của AI trong năm 2024:
1. Tự động hóa trong sản xuất
2. Hỗ trợ chăm sóc sức khỏe
3. Cải thiện trải nghiệm người dùng
4. Phát triển các giải pháp bảo mật thông minh

Các chuyên gia dự đoán rằng AI sẽ tiếp tục phát triển mạnh mẽ trong những năm tới, mang lại nhiều cơ hội và thách thức mới cho doanh nghiệp và người dùng.',
    'hinh/tm1.jpg',
    'Cong Nghe',
    '2024-03-14 15:30:00'
),
(
    'Thác Cầm Ly: Kỳ quan thiên nhiên hùng vĩ',
    'Thác Cầm Ly, một trong những thác nước đẹp nhất Việt Nam, đang trở thành điểm đến hấp dẫn cho du khách trong và ngoài nước. Với vẻ đẹp hoang sơ và hùng vĩ, thác nước này mang đến trải nghiệm khó quên cho những ai đặt chân đến đây.

Đặc điểm nổi bật của Thác Cầm Ly:
1. Chiều cao ấn tượng với nhiều tầng thác
2. Khung cảnh thiên nhiên hoang sơ
3. Hệ sinh thái đa dạng
4. Các hoạt động du lịch hấp dẫn

Du khách có thể tham gia nhiều hoạt động thú vị như leo núi, khám phá rừng, và tắm thác trong khung cảnh thiên nhiên tuyệt đẹp.',
    'hinh/thac1.jpg',
    'Thien Nhien',
    '2024-03-13 09:15:00'
); 