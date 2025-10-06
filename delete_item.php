<?php
session_start();
include 'config.php';

// Only allow sellers to view this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    echo "<p style='padding:20px;'>Access denied. Only sellers can delete items.</p>";
    exit();
}

$user_id = intval($_SESSION['user_id']);
$query = "SELECT * FROM food_items WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete My Items</title>
    <link rel="stylesheet" href="styles.css">
    <style>
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
        }

        /* Header */
        .header {
            /* background: linear-gradient(135deg, #8B0000, #DC143C); */
                background: linear-gradient(135deg, #923232, #ec1919);
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #FFD700;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #FFD700;
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-login {
            background: transparent;
            color: white;
            border: 1px solid white;
        }

        .btn-signup {
            background: #FFD700;
            color: #8B0000;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        /* Hero Section with Slider */
        .hero {
            position: relative;
            height: 600px;
            overflow: hidden;
        }

        .slider {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .slide {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slide.active {
            opacity: 1;
        }

        .slide1 {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('food image.avif');
            background-size: cover;
            background-position: center;
            width: 100%;
        }

        .slide2 {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('foodee.avif');
            background-size: cover;
            background-position: center;
            width: 100%;
        }

        .slide3 {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('food image 3.avif');
            background-size: cover;
            background-position: center;
            width: 100%;
        }

        .hero-content {
            text-align: center;
            color: white;
            z-index: 2;
            max-width: 600px;
            padding: 2rem;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }

        .search-container {
            display: flex;
            max-width: 500px;
            margin: 0 auto;
            background: white;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .search-input {
            flex: 1;
            padding: 1rem 1.5rem;
            border: none;
            outline: none;
            font-size: 1rem;
        }

        .search-btn {
            background: #DC143C;
            color: white;
            padding: 1rem 1.5rem;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        /* Slider Navigation */
        .slider-nav {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
        }

        .slider-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255,255,255,0.5);
            cursor: pointer;
            transition: background 0.3s;
        }

        .slider-dot.active {
            background: white;
        }

        /* Foods Section */
        .foods-section {
            padding: 4rem 2rem;
            max-width: 85vw;
            margin: 0 auto;
        }

        .foods-title {
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #333;
        }

        /* Horizontal Scroll Container */
        .foods-scroll-container {
            position: relative;
            overflow: hidden;
        }

        .foods-grid {
            display: flex;
            gap: 2rem;
            overflow-x: auto;
            padding-bottom: 1rem;
            scroll-behavior: smooth;
            /* Hide scrollbar for cleaner look */
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* Internet Explorer 10+ */
        }

        .foods-grid::-webkit-scrollbar {
            display: none; /* WebKit */
        }

        /* Scroll Navigation Buttons */
        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(220, 20, 60, 0.9);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .scroll-btn:hover {
            background: #DC143C;
            transform: translateY(-50%) scale(1.1);
        }

        .scroll-btn-left {
            left: -25px;
        }

        .scroll-btn-right {
            right: -25px;
        }

        .food-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            min-width: 300px; /* Fixed width for horizontal scroll */
            flex-shrink: 0; /* Prevent cards from shrinking */
        }

        .food-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .food-image {
            width: 100%;
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .favorite-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255,255,255,0.9);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #DC143C;
            font-size: 16px;
        }

        .food-info {
            padding: 1.5rem;
        }

        .food-name {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .food-description {
            color: #666;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .food-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .food-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #FFD700;
            background: #DC143C;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
        }

        .food-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stars {
            color: #FFD700;
        }

        .order-btn {
            width: 100%;
            background: #DC143C;
            color: white;
            padding: 0.8rem;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        .cart-btn {
            width: 100%;
            background: #dcd914ff;
            color: white;
            margin-top: 8px;
            padding: 0.8rem;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        .order-btn:hover {
            background: #B22222;
        }

        /* Features Section */
        .features {
            background: #1a1a1a;
            color: white;
            padding: 4rem 2rem;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
        }

        .feature {
            text-align: center;
            padding: 2rem;
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            background: #DC143C;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .feature h3 {
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        /* Footer */
        .footer {
            background: #DC143C;
            color: white;
            padding: 3rem 2rem 1rem;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .footer-section h3 {
            margin-bottom: 1rem;
            color: #FFD700;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section ul li a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section ul li a:hover {
            color: #FFD700;
        }

        .app-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .app-btn {
            background: #333;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        /* Food card specific backgrounds */
        .masala-poori { background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('masala puri.jpg') ; 
    background-size: cover;
            background-position: center;
            width: 100%;}
        
        .parippu-vada { background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('panin puri.jpg'); 
    background-size: cover;
            background-position: center;
            width: 100%; }
        
        .uzhunnu-vada { background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('samosa.jpg');
    background-size: cover;
            background-position: center;
            width: 100%; }
        
        .kalan { background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 200"><rect fill="%23A0522D" width="300" height="200"/><rect x="50" y="50" width="200" height="100" fill="%23F5DEB3" rx="10"/></svg>'); }
        
        .pazham-pori { background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 200"><rect fill="%23FF8C00" width="300" height="200"/><rect x="60" y="70" width="50" height="60" fill="%23FFD700" rx="5"/><rect x="125" y="70" width="50" height="60" fill="%23FFD700" rx="5"/><rect x="190" y="70" width="50" height="60" fill="%23FFD700" rx="5"/></svg>'); }
        
        .kothu-porotta { background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 200"><rect fill="%23CD853F" width="300" height="200"/><polygon points="50,50 100,50 75,100" fill="%23DEB887"/><polygon points="150,60 200,60 175,110" fill="%23DEB887"/><polygon points="100,120 150,120 125,170" fill="%23DEB887"/></svg>'); }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                gap: 1rem;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .search-container {
                flex-direction: column;
            }

            .food-card {
                min-width: 280px;
            }

            .scroll-btn {
                display: none; /* Hide scroll buttons on mobile */
            }
        }
        .delete-btn {
            margin-top: 10px;
            background: red;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            text-align: center;
        }
        .delete-btn:hover {
            background: darkred;
        }
    </style>
</head>
<body>
    <section class="foods-section">
        <h2 class="foods-title">My Added Items</h2>
        <div class="foods-scroll-container">
            <div class="foods-grid" id="foodsGrid">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="food-card" data-id="'.$row['id'].'">
                                <div class="food-image" style="background-image: url('.$row['image_url'].');"></div>
                                <div class="food-info">
                                    <h3 class="food-name">'.htmlspecialchars($row['name']).'</h3>
                                    <p class="food-description">'.htmlspecialchars($row['description']).'<br>From '.htmlspecialchars($row['vendor']).'</p>
                                    <div class="food-meta">
                                        <span class="food-price">₹'.$row['price'].'</span>
                                        <div class="food-rating">
                                            <span class="stars">'.$row['stars'].'</span>
                                            <span>'.number_format($row['rating'],1).'</span>
                                        </div>
                                    </div>
                                    <!-- Delete Button in place of Order/Add to Cart -->
                                    <button class="delete-btn" data-id="'.$row['id'].'">Delete Item</button>
                                </div>
                              </div>';
                    }
                } else {
                    echo "<p style='padding:20px;'>You haven't added any items yet.</p>";
                }
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </section>

    <script>
    // Handle delete button
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const card = this.closest('.food-card');

            if (confirm("Are you sure you want to delete this item?")) {
                fetch('delete_item_action.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + id
                })
                .then(res => res.text())
                .then(data => {
                    if (data.trim() === 'success') {
                        card.remove();
                        if (!document.querySelector('.food-card')) {
                            document.getElementById('foodsGrid').innerHTML = "<p style='padding:20px;'>You have no items left.</p>";
                        }
                    } else {
                        alert('Failed to delete item.');
                    }
                });
            }
        });
    });
    </script>
</body>
</html>
