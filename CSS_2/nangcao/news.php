<?php
require_once 'config.php';

// Get the article ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch the specific article
$stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

// If article doesn't exist, redirect to home
if (!$article) {
    header('Location: index.php');
    exit();
}

// Update view count
$stmt = $pdo->prepare("UPDATE news SET views = views + 1 WHERE id = ?");
$stmt->execute([$id]);

// Fetch related articles (same category, excluding current article)
$stmt = $pdo->prepare("SELECT id, title, image_url, publish_date, views FROM news WHERE category = ? AND id != ? ORDER BY publish_date DESC LIMIT 3");
$stmt->execute([$article['category'], $id]);
$related_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['title']); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars(substr(strip_tags($article['content']), 0, 160)); ?>">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <nav class="nav-menu">
        <ul>
            <li><a href="index.php">Tin Nổi Bật</a></li>
            <li><a href="index.php?category=The%20Thao">Thể Thao</a></li>
            <li><a href="index.php?category=Cong%20Nghe">Công Nghệ</a></li>
            <li><a href="index.php?category=Thien%20Nhien">Thiên Nhiên</a></li>
        </ul>
    </nav>

    <div class="article-detail">
        <article>
            <header class="article-header">
                <div class="article-meta">
                    <span class="category-badge category-<?php echo strtolower(str_replace(' ', '-', $article['category'])); ?>">
                        <?php echo htmlspecialchars($article['category']); ?>
                    </span>
                    <div class="meta-info">
                        <span><i class="fas fa-clock"></i> <?php echo date('d/m/Y', strtotime($article['publish_date'])); ?></span>
                        <span><i class="fas fa-eye"></i> <?php echo $article['views']; ?> lượt xem</span>
                    </div>
                </div>
                <h1><?php echo htmlspecialchars($article['title']); ?></h1>
            </header>

            <div class="article-image">
                <img src="<?php echo htmlspecialchars($article['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($article['title']); ?>" />
            </div>

            <div class="article-content">
                <?php echo nl2br(htmlspecialchars($article['content'])); ?>
            </div>

            <div class="article-share">
                <h3>Chia sẻ bài viết</h3>
                <div class="share-buttons">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" 
                       target="_blank" class="share-facebook">
                        <i class="fab fa-facebook-f"></i> Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($article['title']); ?>" 
                       target="_blank" class="share-twitter">
                        <i class="fab fa-twitter"></i> Twitter
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>&title=<?php echo urlencode($article['title']); ?>" 
                       target="_blank" class="share-linkedin">
                        <i class="fab fa-linkedin-in"></i> LinkedIn
                    </a>
                </div>
            </div>

            <?php if (!empty($related_articles)): ?>
            <div class="related-articles">
                <h3>Bài viết liên quan</h3>
                <div class="related-grid">
                    <?php foreach ($related_articles as $related): ?>
                    <div class="related-card">
                        <a href="news.php?id=<?php echo $related['id']; ?>">
                            <img src="<?php echo htmlspecialchars($related['image_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($related['title']); ?>" />
                            <h4><?php echo htmlspecialchars($related['title']); ?></h4>
                            <div class="meta">
                                <span><i class="fas fa-clock"></i> <?php echo date('d/m/Y', strtotime($related['publish_date'])); ?></span>
                                <span><i class="fas fa-eye"></i> <?php echo $related['views']; ?> lượt xem</span>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <footer class="article-footer">
                <a href="index.php" class="back-button">
                    <i class="fas fa-arrow-left"></i> Quay lại trang chủ
                </a>
            </footer>
        </article>
    </div>

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
            $('.article-detail').addClass('page-transition');
            setTimeout(() => $('.article-detail').addClass('active'), 100);

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

            // Lazy loading images
            $('img').each(function() {
                $(this).attr('loading', 'lazy');
            });

            // Share buttons hover effect
            $('.share-buttons a').hover(
                function() {
                    $(this).css('transform', 'translateY(-3px)');
                },
                function() {
                    $(this).css('transform', 'translateY(0)');
                }
            );

            // Related articles hover effect
            $('.related-card').hover(
                function() {
                    $(this).find('img').css('transform', 'scale(1.05)');
                },
                function() {
                    $(this).find('img').css('transform', 'scale(1)');
                }
            );
        });
    </script>
</body>
</html> 