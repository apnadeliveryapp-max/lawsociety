<?php 
include 'connection.php'; 

// Fetch Top Banners
$banner_query = "SELECT * FROM banners WHERE position IN ('top_left', 'top_right')";
$banners_result = $conn->query($banner_query);
$banners = [];
while($row = $banners_result->fetch_assoc()) {
    $banners[$row['position']] = $row['image_url'];
}

// Fetch Latest Posts
$posts_query = "SELECT * FROM posts ORDER BY created_at DESC";
$posts_result = $conn->query($posts_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LawSociety - For Students of Law</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <header class="top-nav">
        <div class="container">
            <div class="logo-section">
                <img src="https://www.lawctopus.com/wp-content/uploads/2021/01/Lawctopus-Logo-New.png" alt="Law Society" class="logo">
            </div>
            
            <nav class="main-links">
                <div class="dropdown">
                    <a href="#" class="dropbtn">Learn <i class="fa fa-chevron-down"></i></a>
                    <div class="dropdown-content">
                        <a href="#">Live Courses</a>
                        <a href="#">Test-prep Courses</a>
                        <a href="#">Comprehensive Courses</a>
                    </div>
                </div>

                <a href="#">Jobs</a>
                <a href="#">Internship Opportunities</a>

                <div class="dropdown">
                    <a href="#" class="dropbtn">Internship Experiences <i class="fa fa-chevron-down"></i></a>
                    <div class="dropdown-content">
                        <a href="#">Company</a>
                        <a href="#">Government</a>
                        <a href="#">IPR</a>
                        <a href="#">Law Firm</a>
                    </div>
                </div>

                <a href="#">Call for Papers</a>
                <a href="#" class="advertise-btn"><i class="fa fa-shopping-cart"></i> Advertise with us</a>
            </nav>

            <div class="header-actions">
                <i class="fa fa-search"></i>
                <a href="#" class="contact-link">Contact</a>
                <button class="submit-btn">Submit Post</button>
                <i class="fa fa-user-circle profile-icon"></i>
            </div>
        </div>
    </header>

    <div class="category-bar">
        <div class="container flex-nav">
            <div class="dropdown">
                <a href="#">Conferences and Seminars <i class="fa fa-chevron-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Webinar</a>
                    <a href="#">Conference</a>
                </div>
            </div>

            <div class="dropdown">
                <a href="#">Courses and Workshops <i class="fa fa-chevron-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Online Workshops</a>
                    <a href="#">Skill Bootcamps</a>
                </div>
            </div>

            <div class="dropdown">
                <a href="#">Blogs, News, Advice <i class="fa fa-chevron-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Legal News</a>
                    <a href="#">Career Advice</a>
                </div>
            </div>

            <a href="#">Lawctopus Law School</a>
            <a href="#">Surprise Me!</a>
        </div>
    </div>

    <div class="container top-ads-container">
        <p class="ad-label-small">Ad</p>
        <div class="dual-banners">
            <div class="ad-banner banner-left">
                <img src="<?php echo $banners['top_left'] ?? 'https://via.placeholder.com/600x120'; ?>" alt="Ad Left">
            </div>
            <div class="ad-banner banner-right">
                <img src="<?php echo $banners['top_right'] ?? 'https://via.placeholder.com/600x120'; ?>" alt="Ad Right">
            </div>
        </div>
    </div>

    <main class="container main-layout">
        <section class="feed">
            <h2 class="section-title">Latest Updates</h2>
            
            <?php if ($posts_result->num_rows > 0): ?>
                <?php while($post = $posts_result->fetch_assoc()): ?>
                    <article class="post-card">
                        <div class="post-img">
                            <img src="<?php echo htmlspecialchars($post['image_url']); ?>" alt="post">
                        </div>
                        <div class="post-content">
                            <div class="post-meta">
                                <span class="category"><?php echo strtoupper(htmlspecialchars($post['category'])); ?></span> / 
                                <span class="author"><?php echo strtoupper(htmlspecialchars($post['author'])); ?></span> . 
                                <?php echo date("F d, Y", strtotime($post['created_at'])); ?>
                                <span class="status-badge">
    <?php echo htmlspecialchars($post['status_badge'] ?? $post['status'] ?? 'Ongoing'); ?>
</span></div>
                            <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No updates found.</p>
            <?php endif; ?>
        </section>

        <aside class="sidebar">
            <p class="ad-label">Advertisements</p>
            <?php
            $sidebar_ads = $conn->query("SELECT * FROM banners WHERE position = 'sidebar' LIMIT 2");
            while($ad = $sidebar_ads->fetch_assoc()):
            ?>
                <div class="ad-box">
                    <img src="<?php echo $ad['image_url']; ?>" alt="Sidebar Ad">
                </div>
            <?php endwhile; ?>
        </aside>
    </main>

    <section class="container social-subscription">
        <div class="newsletter-card">
            <div class="newsletter-info">
                <div class="newsletter-icon"><i class="fa-regular fa-envelope-open"></i></div>
                <div>
                    <h3>Never miss an opportunity</h3>
                    <p>Subscribe to our newsletter</p>
                </div>
            </div>
            <form class="subscribe-form" action="subscribe.php" method="POST">
                <input type="email" name="email" placeholder="Enter Email" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>

        <div class="sticky-social">
            <div class="whatsapp" id="whatsappBtn"><i class="fab fa-whatsapp"></i></div>
            <div class="phone" id="phoneBtn"><i class="fa fa-phone-alt"></i></div>
        </div>
    </section>

    <footer class="main-footer">
    <div class="container footer-grid">
        
        <div class="footer-col">
            <img src="https://www.lawctopus.com/wp-content/uploads/2021/01/Lawctopus-Logo-New.png" alt="Law Society" class="footer-logo">
            
            <div class="footer-contact-item">
                <h4>For submitting a Post</h4>
                <a href="mailto:contact@lawctopus.com"><i class="fa-regular fa-envelope"></i> contact@lawctopus.com</a>
            </div>
            
            <hr class="footer-divider">
            
            <div class="footer-contact-item">
                <h4>For banner ads & admission campaigns</h4>
                <a href="mailto:rohit.bhutani@lawctopus.com"><i class="fa-regular fa-envelope"></i> rohit.bhutani@lawctopus.com</a>
            </div>
            
            <p class="hours"><i class="fa-regular fa-clock"></i> Hours: 11 AM - 7 PM (Mon-Fri)</p>
        </div>

        <div class="footer-col">
            <h3>Reach <strong>3.5 lakh+</strong> law students, aspirants, and young lawyers</h3>
            <div class="footer-btns">
                <a href="#" class="outline-btn">Advertise on Lawctopus</a>
                <a href="#" class="outline-btn orange-border">Submit Post</a>
            </div>
            
            <hr class="footer-divider">
            
            <div class="link-lists">
                <ul>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Contact us</a></li>
                    <li><a href="#">Our Team</a></li>
                    <li><a href="#">Our Services</a></li>
                    <li><a href="#">Institutional Partnerships</a></li>
                </ul>
                <ul>
                    <li><a href="#">Singular Events</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#"><i class="fa-solid fa-fire"></i> Moot Suite</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-col">
            <h4 class="school-title">LAWCTOPUS LAW SCHOOL</h4>
            <p>The law school you always wanted! Learn practical legal skills.</p>
            <a href="mailto:courses@lawctopus.com" class="school-link"><i class="fa-regular fa-envelope"></i> courses@lawctopus.com</a>
            <a href="#" class="school-link"><i class="fa-solid fa-arrow-up-right-from-square"></i> Visit site</a>
            
            <hr class="footer-divider">
            
            <div class="social-follow">
                <p>Follow us on:</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            
            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" class="play-store">
        </div>
    </div>

    <div class="footer-bottom">
        <p>© 2025 – Lawctopus</p>
    </div>

    <div class="back-to-top">
        <i class="fa-solid fa-arrow-up"></i>
    </div>
</footer>

    <script src="script.js"></script>
</body>
</html>