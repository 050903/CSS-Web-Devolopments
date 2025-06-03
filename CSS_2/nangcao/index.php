<?php
require_once 'config.php';

// Fetch all news articles
$stmt = $pdo->query("SELECT id, title, image_url, category, publish_date, views FROM news ORDER BY publish_date DESC");
$news = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin Tức Nổi Bật</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <nav class="nav-menu">
        <ul>
            <li><a href="index.php" class="active">Tin Nổi Bật</a></li>
            <li><a href="index.php?category=The%20Thao">Thể Thao</a></li>
            <li><a href="index.php?category=Cong%20Nghe">Công Nghệ</a></li>
            <li><a href="index.php?category=Thien%20Nhien">Thiên Nhiên</a></li>
        </ul>
    </nav>

    <header class="page-header">
        <h1>Tin Tức Nổi Bật</h1>
    </header>

    <main id="tinnoibat">
        <div class="news-grid">
            <?php foreach ($news as $article): ?>
                <div class="news-card" data-id="<?php echo $article['id']; ?>">
                    <a href="news.php?id=<?php echo $article['id']; ?>" class="news-link">
                        <img src="<?php echo htmlspecialchars($article['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($article['title']); ?>" />
                        <span class="category-badge category-<?php echo strtolower(str_replace(' ', '-', $article['category'])); ?>">
                            <?php echo htmlspecialchars($article['category']); ?>
                        </span>
                        <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                        <div class="meta">
                            <span><i class="fas fa-clock"></i> <?php echo date('d/m/Y', strtotime($article['publish_date'])); ?></span>
                            <span><i class="fas fa-eye"></i> <?php echo $article['views']; ?> lượt xem</span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <div class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Về Chúng Tôi</h3>
                <p>Trang tin tức hàng đầu Việt Nam, cập nhật tin tức 24/7 với nguồn tin chính thống.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Danh Mục</h3>
                <ul>
                    <li><a href="index.php">Tin Nổi Bật</a></li>
                    <li><a href="index.php?category=The%20Thao">Thể Thao</a></li>
                    <li><a href="index.php?category=Cong%20Nghe">Công Nghệ</a></li>
                    <li><a href="index.php?category=Thien%20Nhien">Thiên Nhiên</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Liên Hệ</h3>
                <ul>
                    <li><i class="fas fa-envelope"></i> contact@yournewsportal.com</li>
                    <li><i class="fas fa-phone"></i> +84 123 456 789</li>
                    <li><i class="fas fa-map-marker-alt"></i> 123 Đường ABC, Quận XYZ, TP.HCM</li>
                </ul>
            </div>
        </div>
        <p class="copyright">&copy; 2024 Tin Tức Nổi Bật. All rights reserved.</p>
    </footer>

    <script>
        $(document).ready(function() {
            // Page transition
            $('main').addClass('page-transition');
            setTimeout(() => $('main').addClass('active'), 100);

            // Scroll handling
            $(window).scroll(function() {
                if ($(this).scrollTop() > 100) {
                    $('.nav-menu').addClass('scrolled');
                    $('.back-to-top').addClass('visible');
                } else {
                    $('.nav-menu').removeClass('scrolled');
                    $('.back-to-top').removeClass('visible');
                }
            });

            // Back to top
            $('.back-to-top').click(function() {
                $('html, body').animate({scrollTop: 0}, 800);
                return false;
            });

            // News card hover effect
            $('.news-card').hover(
                function() {
                    $(this).find('.content-overlay').css('transform', 'translateY(0)');
                },
                function() {
                    $(this).find('.content-overlay').css('transform', 'translateY(100%)');
                }
            );

            // Lazy loading images
            $('img').each(function() {
                $(this).attr('loading', 'lazy');
            });
        });
    </script>
</body>
</html> 