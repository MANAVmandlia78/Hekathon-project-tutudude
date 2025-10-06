<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Street Food - Order Now</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Dosis:wght@200..800&family=Playwrite+AU+QLD:wght@100..400&family=Roboto:ital,wght@0,100..900;1,100..900&family=Winky+Sans:ital,wght@0,300..900;1,300..900&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
        }

        .playwrite{
  font-family: "Playwrite AU QLD", cursive;
  font-optical-sizing: auto;
  font-weight: <weight>;
  font-style: normal;
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
    </style>
</head>
<body>
<header class="header">
    <div class="nav-container">
        <div class="logo playwrite">Market Mitra</div>
        <nav>
            <ul class="nav-links">
                <li><a href="street_food_website.php">Home</a></li>
                <li><a href="grocery_store.php">Nearby</a></li>
                <li><a href="aboutup.html">About Us</a></li>
                <li><a href="cart.php">Cart</a></li>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'seller'): ?>
    <li><a href="add_item.php">Add Item</a></li>
    <li><a href="delete_item.php">Manage My Items</a></li>
<?php endif; ?>

            </ul>
        </nav>
        <div class="auth-buttons">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="login.php" class="btn btn-login">Log in</a>
                <a href="register.php" class="btn btn-signup">Sign up</a>
            <?php else: ?>
                <a href="logout.php" class="btn btn-login">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</header>


    <!-- Hero Section with Slider -->
    <section class="hero" id="home">
        <div class="slider">
            <div class="slide slide1 active">
                <div class="hero-content">
                    <h1>Raw Material now at your home</h1>
                    <p>Order Raw Material from favourite supplier shop near you.</p>
                    
                </div>
            </div>
            <div class="slide slide2">
                <div class="hero-content">
                    <h1>Fresh Indian Spices</h1>
                    <p>Explore the magical masalas of India</p>
                   
                </div>
            </div>
            <div class="slide slide3">
                <div class="hero-content">
                    <h1>Traditional Flavors</h1>
                    <p>Experience the authentic taste of locally sourced ingredients.</p>
                   
                </div>
            </div>
        </div>
        <div class="slider-nav">
            <div class="slider-dot active" onclick="currentSlide(1)"></div>
            <div class="slider-dot" onclick="currentSlide(2)"></div>
            <div class="slider-dot" onclick="currentSlide(3)"></div>
        </div>
    </section>
    

    <!-- Foods Section -->
 <section class="foods-section">
    <h2 class="foods-title">Foods</h2>
    <div class="foods-scroll-container">
        <div class="foods-grid" id="foodsGrid">
            <?php
            include 'config.php';
            $query = "SELECT * FROM food_items ORDER BY created_at DESC";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="food-card">
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
                            <!-- Existing Order Button -->
                            <button class="order-btn" 
                                data-price="'.$row['price'].'" 
                                data-name="'.htmlspecialchars($row['name']).'">Order Now</button>
                                <br>
                            <!-- New Add to Cart Button -->
                            <button class="cart-btn" data-id="'.$row['id'].'">Add to Cart</button>
                        </div>
                    </div>';
            }
            mysqli_close($conn);
            ?>
        </div>
    </div>
</section>


      <!-- Foods Section vegitable-->
    <section class="foods-section">
        <h2 class="foods-title">Vegitable</h2>
        <div class="foods-scroll-container">
            <div class="foods-grid" id="foodsGrid">
                <?php
include 'config.php';
$query = "SELECT * FROM food_items WHERE category = 'vegitables' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="food-card">
            <div class="food-image" style="background-image: url('.$row['image_url'].');">
            </div>
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
                <button class="order-btn" 
    data-price="'.$row['price'].'" 
    data-name="'.htmlspecialchars($row['name']).'">
    Order Now
</button>
 <br>
                            <!-- New Add to Cart Button -->
                            <button class="cart-btn" data-id="'.$row['id'].'">Add to Cart</button>

            </div>
        </div>';
}
mysqli_close($conn);
?>

</div>
</div>
</div>
</section>

<section class="foods-section">
        <h2 class="foods-title">Fruits</h2>
        <div class="foods-scroll-container">
            <div class="foods-grid" id="foodsGrid">
                <?php
include 'config.php';
$query = "SELECT * FROM food_items WHERE category = 'fruits' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="food-card">
            <div class="food-image" style="background-image: url('.$row['image_url'].');">
            </div>
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
                <button class="order-btn" 
    data-price="'.$row['price'].'" 
    data-name="'.htmlspecialchars($row['name']).'">
    Order Now
</button>
 <br>
                            <!-- New Add to Cart Button -->
                            <button class="cart-btn" data-id="'.$row['id'].'">Add to Cart</button>

            </div>
        </div>';
}
mysqli_close($conn);
?>

</div>
</div>
</div>
</section>

<!-- Foods Section spicies-->
    <section class="foods-section">
        <h2 class="foods-title">Spices</h2>
        <div class="foods-scroll-container">
            <div class="foods-grid" id="foodsGrid">
                <?php
include 'config.php';
$query = "SELECT * FROM food_items WHERE category = 'spicies' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="food-card">
            <div class="food-image" style="background-image: url('.$row['image_url'].');">
            </div>
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
                <button class="order-btn" 
    data-price="'.$row['price'].'" 
    data-name="'.htmlspecialchars($row['name']).'">
    Order Now
</button>
 <br>
                            <!-- New Add to Cart Button -->
                            <button class="cart-btn" data-id="'.$row['id'].'">Add to Cart</button>

            </div>
        </div>';
}
mysqli_close($conn);
?>

</div>
</div>
</div>
</section>


<!-- Foods Section Oil-->
    <section class="foods-section">
        <h2 class="foods-title">Oils</h2>
        <div class="foods-scroll-container">
            <div class="foods-grid" id="foodsGrid">
                <?php
include 'config.php';
$query = "SELECT * FROM food_items WHERE category = 'oil' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="food-card">
            <div class="food-image" style="background-image: url('.$row['image_url'].');">
            </div>
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
                <button class="order-btn" 
    data-price="'.$row['price'].'" 
    data-name="'.htmlspecialchars($row['name']).'">
    Order Now
</button>
 <br>
                            <!-- New Add to Cart Button -->
                            <button class="cart-btn" data-id="'.$row['id'].'">Add to Cart</button>

            </div>
        </div>';
}
mysqli_close($conn);
?>

</div>
</div>
</div>
</section>

<!-- Foods Section Bakery-->
    <section class="foods-section">
        <h2 class="foods-title">Bakery & Namkeen</h2>
        <div class="foods-scroll-container">
            <div class="foods-grid" id="foodsGrid">
                <?php
include 'config.php';
$query = "SELECT * FROM food_items WHERE category = 'bakery items' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="food-card">
            <div class="food-image" style="background-image: url('.$row['image_url'].');">
            </div>
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
                <button class="order-btn" 
    data-price="'.$row['price'].'" 
    data-name="'.htmlspecialchars($row['name']).'">
    Order Now
</button>
 <br>
                            <!-- New Add to Cart Button -->
                            <button class="cart-btn" data-id="'.$row['id'].'">Add to Cart</button>

            </div>
        </div>';
}
mysqli_close($conn);
?>

</div>
</div>
</div>
</section>


<!-- Foods Section Sauses-->
    <section class="foods-section">
        <h2 class="foods-title">Sauses</h2>
        <div class="foods-scroll-container">
            <div class="foods-grid" id="foodsGrid">
                <?php
include 'config.php';
$query = "SELECT * FROM food_items WHERE category = 'sauses' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="food-card">
            <div class="food-image" style="background-image: url('.$row['image_url'].');">
            </div>
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
                <button class="order-btn" 
    data-price="'.$row['price'].'" 
    data-name="'.htmlspecialchars($row['name']).'">
    Order Now
</button>
 <br>
                            <!-- New Add to Cart Button -->
                            <button class="cart-btn" data-id="'.$row['id'].'">Add to Cart</button>

            </div>
        </div>';
}
mysqli_close($conn);
?>

</div>
</div>
</div>
</section>

<!-- Features Section -->
    <section class="features">
        <div class="features-container">
            <div class="feature">
                <div class="feature-icon">📦</div>
                <h3>No Minimum Order</h3>
                <p>Order in for yourself or for the group, with no restrictions on order value</p>
            </div>
            <div class="feature">
                <div class="feature-icon">📱</div>
                <h3>Live Order Tracking</h3>
                <p>Know where your order is at all times, from the restaurant to your doorstep</p>
            </div>
            <div class="feature">
                <div class="feature-icon">⚡</div>
                <h3>Lightning Fast Delivery</h3>
                <p>Experience Swiggy's superfast delivery for food delivered fresh & on time</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>COMPANY</h3>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Team</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>CONTACT</h3>
                <ul>
                    <li><a href="#">Help & Support</a></li>
                    <li><a href="#">Partner with us</a></li>
                    <li><a href="#">Ride with us</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>DOWNLOAD APP</h3>
                <div class="app-buttons">
                    <a href="#" class="app-btn">
                        📱 Google Play
                    </a>
                    <a href="#" class="app-btn">
                        🍎 App Store
                    </a>
                    </div>
                </div>
            </div>
        </footer>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
// Handle Add to Cart
document.querySelectorAll('.cart-btn').forEach(button => {
    button.addEventListener('click', function() {
        const itemId = this.getAttribute('data-id');
        
        fetch('update_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + itemId
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Notify user
        });
    });
});
</script>
<script>
document.querySelectorAll('.order-btn').forEach(button => {
    button.addEventListener('click', function() {
        const price = this.getAttribute('data-price');  // Food price
        const name = this.getAttribute('data-name');    // Food name

        const options = {
            "key": "rzp_test_qrz9HPerbzz5cy", // Your Razorpay test key
            "amount": price * 100, // Amount is in paise (₹1 = 100 paise)
            "currency": "INR",
            "name": "Street Food Order",
            "description": "Payment for " + name,
            "image": "https://yourwebsite.com/logo.png", // Optional logo
            "handler": function (response){
                alert("Payment Successful! Payment ID: " + response.razorpay_payment_id);
                // You can make an AJAX call here to save payment info in your DB
            },
            "prefill": {
                "name": "Customer Name",
                "email": "customer@example.com",
                "contact": "9999999999"
            },
            "theme": {
                "color": "#F37254"
            }
        };

        const rzp1 = new Razorpay(options);
        rzp1.open();
    });
});
</script>

         <script>
        let slideIndex = 1;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.slider-dot');

        function showSlide(n) {
            if (n > slides.length) { slideIndex = 1; }
            if (n < 1) { slideIndex = slides.length; }
            
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            
            slides[slideIndex - 1].classList.add('active');
            dots[slideIndex - 1].classList.add('active');
        }

        function currentSlide(n) {
            slideIndex = n;
            showSlide(slideIndex);
        }

        function nextSlide() {
            slideIndex++;
            showSlide(slideIndex);
        }

        // Auto slide every 5 seconds
        setInterval(nextSlide, 5000);

        // Add click functionality to order buttons
        document.querySelectorAll('.order-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const foodName = this.closest('.food-card').querySelector('.food-name').textContent;
                alert(`Added ${foodName} to cart!`);
            });
        });

        // Add click functionality to favorite buttons
        document.querySelectorAll('.favorite-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.style.color = this.style.color === 'red' ? '#DC143C' : 'red';
            });
        });

        // Search functionality
        document.querySelector('.search-btn').addEventListener('click', function() {
            const location = document.querySelector('.search-input').value;
            if (location.trim()) {
                alert(`Searching for restaurants near: ${location}`);
            } else {
                alert('Please enter your location');
            }
        });

        // Enter key for search
        document.querySelector('.search-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.querySelector('.search-btn').click();
            }
        });
    </script>
</body>
</html>