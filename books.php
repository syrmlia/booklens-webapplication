<?php
// Array Data Koleksi Buku (Dummy Database)
$books_collection = [
    [
        "id" => 1,
        "title" => "Hujan",
        "author" => "Tere Liye",
        "cover" => "hujan.png",
        "rating" => "5.0",
        "genres" => ["Sci-Fi", "Romance"]
    ],
    [
        "id" => 2,
        "title" => "Di Tanah Lada",
        "author" => "Ziggy Zezsyazeoviennazabrizkie",
        "cover" => "ditanah.png",
        "rating" => "5.0",
        "genres" => ["Mystery", "Drama"]
    ],
    [
        "id" => 3,
        "title" => "Dilan 1990",
        "author" => "Pidi Baiq",
        "cover" => "dilan.png",
        "rating" => "5.0",
        "genres" => ["Romance", "Drama"]
    ],
    [
        "id" => 4,
        "title" => "Pukul Setengah Lima",
        "author" => "Rintik Sedu",
        "cover" => "pukul.png",
        "rating" => "5.0",
        "genres" => ["Romance", "Mystery"]
    ],
    [
        "id" => 5,
        "title" => "Dompet Ayah Sepatu Ibu",
        "author" => "J.S. Khairen",
        "cover" => "dompet.png",
        "rating" => "5.0",
        "genres" => ["Drama", "Family"]
    ],
    [
        "id" => 6,
        "title" => "A Gentle Reminder",
        "author" => "Bianca Sparacino",
        "cover" => "gentle.png",
        "rating" => "5.0",
        "genres" => ["Self Help", "Poetry"]
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Books - BookLens</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./main.css?v=1.3">
</head>
<body>

    <nav class="navbar">
        <div class="logo-brand">
            <a href="index.php" class="brand-link">
                <img src="assets/images/ui/Vector-landingpage.png" alt="BookLens Logo" class="nav-logo-img">
                <span class="brand-text">BookLens</span>
            </a>
        </div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="books.php" class="active">Books</a>
        </div>
        <div class="nav-auth-buttons">
            <a href="login.php" class="btn-login">Login</a>
            <a href="register.php" class="btn-register">Register</a>
        </div>
    </nav>

    <main class="container explore-section">
        
        <div class="explore-header">
            <div class="header-text">
                <h1>Explore Books</h1>
                <p>Discover thousands of books from various genres and find your next favorite read.</p>
            </div>
            <div class="search-box-wrapper">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" placeholder="Search for titles, author..." class="search-input">
            </div>
        </div>

        <div class="explore-layout">
            
            <aside class="filter-sidebar">
                <div class="filter-group">
                    <h3><i class="fa-solid fa-layer-group"></i> Genre</h3>
                    <label class="checkbox-container">Fantasy <input type="checkbox"><span class="checkmark"></span></label>
                    <label class="checkbox-container">Mystery <input type="checkbox"><span class="checkmark"></span></label>
                    <label class="checkbox-container">Romance <input type="checkbox"><span class="checkmark"></span></label>
                    <label class="checkbox-container">Horor <input type="checkbox"><span class="checkmark"></span></label>
                    <label class="checkbox-container">Thriller <input type="checkbox"><span class="checkmark"></span></label>
                    <label class="checkbox-container">Sci-Fi <input type="checkbox"><span class="checkmark"></span></label>
                    <label class="checkbox-container">Self Help <input type="checkbox"><span class="checkmark"></span></label>
                    <label class="checkbox-container">Business <input type="checkbox"><span class="checkmark"></span></label>
                </div>

                <div class="filter-group">
                    <h3><i class="fa-solid fa-star"></i> Rating</h3>
                    <label class="radio-container">All Rating <input type="radio" name="rating" checked><span class="radiomark"></span></label>
                    <label class="radio-container">5 Star <input type="radio" name="rating"><span class="radiomark"></span></label>
                    <label class="radio-container">4+ Star <input type="radio" name="rating"><span class="radiomark"></span></label>
                    <label class="radio-container">3+ Star <input type="radio" name="rating"><span class="radiomark"></span></label>
                </div>

                <button class="btn-reset">Reset</button>
            </aside>

            <section class="books-display-area">
                <div class="books-explore-grid">
                    
                    <?php foreach ($books_collection as $item): ?>
                    <div class="explore-book-card">
                        <span class="badge-rating"><i class="fa-solid fa-star"></i> <?php echo $item['rating']; ?></span>
                        <div class="explore-cover-box">
                             <img src="assets/images/books/<?php echo $item['cover']; ?>" alt="<?php echo $item['title']; ?>">
                        </div>
                        <div class="explore-book-info">
                            <div class="genres-tags">
                                <?php foreach ($item['genres'] as $g): ?>
                                    <span class="tag"><?php echo $g; ?></span>
                                <?php endforeach; ?>
                            </div>
                            <h4><?php echo $item['title']; ?></h4>
                            <p class="author-name"><?php echo $item['author']; ?></p>
                            
                            <button class="btn-detail" onclick="window.open('detail.php?id=<?php echo $item['id']; ?>', '_blank')">Detail</button>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>

                <div class="pagination">
                    <a href="#" class="page-arrow"><i class="fa-solid fa-chevron-left"></i></a>
                    <a href="#" class="page-num active">1</a>
                    <a href="#" class="page-num">2</a>
                    <span class="page-dots">...</span>
                    <a href="#" class="page-num">5</a>
                    <a href="#" class="page-num"><i class="fa-solid fa-chevron-right"></i></a>
                </div>
            </section>

        </div>
    </main>

   <footer class="explore-footer">
    <div class="container footer-content">
        <div class="footer-left">
            <strong>BookLens</strong>
            <p>&copy; 2026 BookLens. All rights reserved.</p>
        </div>
        <div class="footer-right">
            <a href="#">About</a>
            <a href="#">Contact</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms</a>
        </div>
    </div>
</footer>

</body>
</html>