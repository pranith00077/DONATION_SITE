<?php
$conn = new mysqli("localhost", "root", "", "ngo_site");
$settings = ["logo" => "images/logo/"]; // fallback

$result = $conn->query("SELECT logo FROM settings WHERE id = 1");
if ($row = $result->fetch_assoc()) {
    $settings['logo'] = $row['logo'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GURU RAGAVENDHRA ORPHANEG HOME | Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <style>
        /* Base Styles */
        :root {
            --primary-color: #2a5f8a;
            --secondary-color: #e67e22;
            --accent-color: #3498db;
            --text-color: #333;
            --light-text: #777;
            --bg-light: #f9f9f9;
            --white: #ffffff;
            --dark-blue: #1a3a5f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        a {
            text-decoration: none;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        a:hover {
            color: var(--secondary-color);
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: var(--dark-blue);
            color: white;
            transform: translateY(-2px);
        }

        .donate-btn {
            background-color: var(--secondary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 600;
        }

        .donate-btn:hover {
            background-color: #d35400;
            color: white;
        }

        h1, h2, h3, h4 {
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
            margin-bottom: 15px;
        }

        h1 {
            font-size: 2.5rem;
        }

        h2 {
            font-size: 2rem;
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        h2:after {
            content: '';
            display: block;
            width: 80px;
            height: 3px;
            background-color: var(--secondary-color);
            margin: 15px auto;
        }

        /* Top Bar */
        .top-bar {
            background-color: var(--primary-color);
            color: white;
            padding: 8px 0;
            font-size: 0.9rem;
        }

        .top-bar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-links a {
            color: white;
            margin-right: 20px;
        }

        .top-links a:hover {
            color: var(--secondary-color);
        }

        .social-icons a {
            color: white;
            margin-left: 15px;
            font-size: 1rem;
        }

        .social-icons a:hover {
            color: var(--secondary-color);
        }

        /* Navigation */
        .main-nav {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .main-nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo img {
            height: 90px;
            border-radius: 200px;
            position:relative;
            left:-120px;
        }

        .nav-links ul {
            display: flex;
            list-style: none;
        }

        .nav-links ul li {
            margin-left: 20px;
            position: relative;
        }

        .nav-links ul li a {
            font-weight: 600;
            color: var(--text-color);
        }

        .nav-links ul li a:hover {
            color: var(--primary-color);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 4px;
            padding: 15px 0;
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
        }

        .dropdown-menu a {
            display: block;
            padding: 8px 20px;
            color: var(--text-color);
            font-weight: 400;
        }

        .dropdown-menu a:hover {
            background-color: var(--bg-light);
            color: var(--primary-color);
        }

        .mobile-menu-btn {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            position: relative;
            height: 70vh;
            min-height: 900px;
            overflow: hidden;
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
        }

        .hero-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(42,95,138,0), rgba(42,95,138,0));
            z-index: 1;
        }
        .hero-content {
            position: absolute;
            top: 70%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            width: 85%;
            padding: 20px;
            max-width: 800px;
            background-color: rgba(0,0,0,0.2);
            border-radius: 8px;
            z-index: 2;
        }

        .hero-content h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }

        /* Impact Stats */
        .impact-stats {
            padding: 60px 0;
            background-color: var(--bg-light);
        }

        .impact-image img {
            width: 100%;
            min-height: 600px; /* Adjusted: Reduced from 400px */
            object-fit: cover;
            object-position: center;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .stats-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
            flex: 1;
            min-width: 200px;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.2rem;
            color: var(--light-text);
        }

        /* What We Do */
        .what-we-do {
            padding: 60px 0;
        }

        /* Removed .programs-grid as it's replaced by .story-slider for success stories */

        .program-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .program-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        .program-card img {
            transition: transform 0.3s ease;
        }
        .program-card:hover img {
            transform: scale(1.05);
        }

        .program-card img {
            width: 100%;
            height: 150px; /* Adjusted: Reduced from 200px */
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .program-card h3 {
            padding: 15px 20px 0;
            color: var(--primary-color);
        }

        .program-card p {
            padding: 0 20px 15px;
            color: var(--light-text);
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: opacity 0.3s ease, max-height 0.3s ease;
            display: none;
        }

        .story-slide:hover .program-card p,
        .story-slide:hover .story-content p.story-summary {
            opacity: 1;
            max-height: 200px; /* Adjust as needed */
            display: block;
        }

        /* Hide the read-more link */
        .read-more {
            display: none;
        }

        /* Success Stories */
        .success-stories {
            padding: 60px 0;
            background-color: var(--bg-light);
        }

        .story-slider {
            display: flex;
            overflow-x: auto; /* Enable horizontal scrolling */
            scroll-snap-type: x mandatory;
            gap: 30px;
            padding-bottom: 20px;
            -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
            scrollbar-width: thin; /* Firefox */
            scrollbar-color: var(--primary-color) var(--bg-light); /* Firefox */
        }

        .story-slider::-webkit-scrollbar {
            height: 8px;
        }

        .story-slider::-webkit-scrollbar-thumb {
            background-color: var(--primary-color);
            border-radius: 10px;
        }

        .story-slider::-webkit-scrollbar-track {
            background-color: var(--bg-light);
        }

        .story-slide {
            scroll-snap-align: start;
            flex: 0 0 300px; /* Fixed width for each slide */
            min-width: 300px; /* Ensure minimum width */
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .story-slide:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .story-slide img {
            width: 100%; /* Image takes full width of the card */
            height: 200px; /* Adjusted: Reduced from 250px */
            object-fit: cover;
            border-radius: 8px 8px 0 0; /* Apply border-radius to top corners */
            transition: transform 0.3s ease;
        }
        .story-slide:hover img {
            transform: scale(1.05);
        }

        .story-content {
            padding: 20px;
            flex-grow: 1; /* Allows content to take available space */
            display: flex;
            flex-direction: column;
        }

        .story-content h3 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .story-content p {
            color: var(--light-text);
            margin-bottom: 15px;
            flex-grow: 1; /* Allows paragraph to take available space */
            display: none;
        }

        /* Get Involved */
        .get-involved {
            padding: 60px 0;
        }

        .involvement-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            width: 500px;
            gap: 30px;
            margin-top: 30px;
            margin-left:325px;
            justify-content: center; /* Center items if there's only one */
        }

        .option-card {
            text-align: center;
            padding: 30px 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .option-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .option-card i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .option-card h3 {
            color: var(--primary-color);
        }

        .option-card p {
            margin-bottom: 20px;
            color: var(--light-text);
        }

        /* Donation Specific Styles */
        .option-image {
            margin: -30px -20px 20px;
        }
        .option-image img {
            width: 100%;
            height: 120px; /* Adjusted: Reduced from 180px */
            object-fit: cover;
            border-radius: 8px 8px 0 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .donation-options {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .impact-image img {
            width: 100%;
            max-height: 300px; /* Adjusted: Reduced from 400px */
            object-fit: cover;
            object-position: center;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* Newsletter */
        .newsletter {
            padding: 60px 0;
            background-color: var(--primary-color);
            color: white;
            text-align: center;
        }

        .newsletter h2 {
            color: white;
        }

        .newsletter h2:after {
            background-color: var(--secondary-color);
        }

        .newsletter p {
            max-width: 600px;
            margin: 0 auto 30px;
        }

        .newsletter-form {
            display: flex;
            flex-direction: column; /* Stack items vertically */
            align-items: center; /* Center items horizontally */
            max-width: 500px;
            margin: 0 auto;
            gap: 15px; /* Space between contact details */
        }

        .contact-detail {
            text-align: center;
        }

        .contact-detail h3 {
            margin-bottom: 5px;
            font-size: 1.1rem;
            color: white; /* Ensure heading color is white */
        }

        .contact-detail p {
            margin-bottom: 0;
            font-size: 1rem;
            color: rgba(255,255,255,0.9); /* Slightly lighter text for details */
        }

        /* Footer */
        .main-footer {
            background-color: var(--dark-blue);
            color: white;
            padding: 60px 0 0;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .footer-col h3 {
            color: white;
            margin-bottom: 20px;
            font-size: 1.3rem;
        }

        .footer-col p {
            margin-bottom: 20px;
            opacity: 0.8;
        }

        .footer-logo {
            height: 60px;
            margin-bottom: 20px;
            border-radius: 200px;
        }

        .footer-social a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background-color: rgba(255,255,255,0.1);
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .footer-social a:hover {
            background-color: var(--secondary-color);
            color: white;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 10px;
        }

        .footer-col ul li a {
            color: rgba(255,255,255,0.8);
            transition: all 0.3s ease;
        }

        .footer-col ul li a:hover {
            color: var(--secondary-color);
            padding-left: 5px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
        }
        

        .copyright {
            opacity: 0.8;
        }

        .footer-links a {
            color: rgba(255,255,255,0.8);
            margin-left: 20px;
        }

        .footer-links a:hover {
            color: var(--secondary-color);
        }

        /* Responsive CSS will be in responsive.css */

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 2000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.7); /* Black w/ opacity */
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 700px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            position: relative;
            animation: fadeIn 0.3s ease-out;
        }

        .modal-content h3 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 1.8rem;
        }

        .modal-content p {
            color: var(--text-color);
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .close-button {
            color: #aaa;
            position: absolute;
            top: 15px;
            right: 25px;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .close-button:hover,
        .close-button:focus {
            color: var(--secondary-color);
            text-decoration: none;
            cursor: pointer;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
        
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="main-nav">
        <div class="container">
            <div class="logo">
                <a href="index.php">
                    <img src="<?= htmlspecialchars($settings['logo']) ?>" alt="NGO Logo" style="max-height: 80px;">
                </a>
            </div>
            <div class="nav-links">
                <ul><li><a href="index.php">Home</a></li>
                    <li><a href="about1.html">About</a></li>
                    <li class="dropdown">
                        <div class="dropdown-menu">
                           
                        </div>
                    </li>
                    
                
                    <li class="dropdown">
                        <a href="#">Media <i class="fas fa-chevron-down"></i></a>
                        <div class="dropdown-menu">
                        
                            <a href="news.html">News</a>
                            <a href="publications.html">Notifications</a>
                            <a href="gallery.php">Gallery</a>
                        </div>
                    </li>
                    <li><a href="donate.html" class="donate-btn">Donate Now</a></li>
                </ul>
            </div>
            <div class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-image">
            <img src="images/img/img9.jpg">
        </div>
        <div class="hero-content">
            <h1>Transforming Lives</h1>
        </div>
    </section>

    <!-- Impact Stats -->
    <section class="impact-stats">
        <div class="impact-image">
            <img src="images/hero3.jpg" alt="Visualizing how donations create impact in rural communities">
        </div>

    </section>

    <!-- What We Do Section (Renamed to "Success Stories" in the HTML, but fetching from 'story' table) -->
    <section class="what-we-do">
        <div class="container">
            <h2>What We Do</h2>
            <div class="story-slider"> <!-- Changed from programs-grid to story-slider -->
                <?php
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $result = $conn->query("SELECT * FROM story ORDER BY created_at DESC");

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='story-slide'>";
                        echo "<img src='images/" . htmlspecialchars($row['image']) . "' alt='Story'>";
                        echo "<div class='story-content'>";
                        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                        echo "<p class='story-summary'>" . htmlspecialchars($row['summary']) . "</p>";
                        
                        // Removed the Read More link as per new requirement
                        // echo "<a href='admin/get_success_stories.php?id=" . htmlspecialchars($row['id']) . "' class='read-more story-read-more' data-title='" . htmlspecialchars($row['title']) . "' data-summary='" . htmlspecialchars($row['summary']) . "'>Read More</a>";
                        echo "</div></div>";
                    }
                } else {
                    echo "<p>No stories found.</p>";
                }
                ?>
            </div>
        </div>
    </section>

   


    <!-- Get Involved -->
    <section class="get-involved">
        <div class="container">
            <h2>Get Involved</h2>
            <div class="involvement-options">
                <div class="option-card">
                    <div class="option-image">
                        <img src="images/img/img5.jpg" alt="Demonstrating impact of donations on communities">
                    </div>
                    <h3>Donate</h3>
                    <p>Your contribution helps provide education, healthcare and livelihoods to rural communities.</p>
                    <div class="donation-options">
                        <a href="donate.html#monthly" class="btn">Monthly Giving</a>
                        <a href="donate.html#one-time" class="btn">One-Time Gift</a>
                    </div>
                </div>
                <!-- Removed Volunteer Section -->
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">
        <div class="container">
            <h2>CONTACT US</h2>
            <div class="newsletter-form"> <!-- Changed from form to div for contact details -->
              <div class="contact-detail">
                <h3>MOBILE NUMBER:</h3>
                <p>9493495259</p>
              </div>
              <div class="contact-detail">
                <h3>EMAIL:</h3>
                <p>guruoldagehome@gmail.com</p>
              </div>
              <div class="contact-detail">
                <h3>ADDRESS:</h3>
                <p>ANANTAPURAMU</p>
              </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <img src="<?= htmlspecialchars($settings['logo']) ?>" alt="NGO Logo" style="max-height: 80px;">
                    <p>This is a non-profit organization working for the orphans and old peoples .</p>
                    <div class="footer-social">
                <a href="https://www.facebook.com" class="social-link" data-platform="facebook">
                            <img src="images/fb.jpg" alt="" width="40" height="40">
                        </a>
                        <a href="https://www.x.com" class="social-link" data-platform="twitter">
                            <img src="images/x.jpg" alt="Twitter" width="40" height="40">
                        </a>
                        <a href="https://www.instagram.com" class="social-link" data-platform="instagram">
                            <img src="images/insta.jpg" alt="Instagram" width="40" height="40">
                        </a>
                        <a href="https://www.youtube.com" class="social-link" data-platform="youtube">
                            <img src="images/yt.jpg" alt="YouTube" width="40" height="40">
                        </a>
                    </div>
                </div>
                <div class="footer-col">
           
                <div class="footer-col">
                
                </div>
                <div class="footer-col">
                    
                </div>
            </div>
            <div class="footer-bottom">
                <div class="copyright">
                    &copy; 2025 . All Rights Reserved.
                </div>
                <div class="footer-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Use</a>
                    <a href="#">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- The Modal Structure -->
    <div id="programModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h3 id="modalTitle"></h3>
            <p id="modalContent"></p>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Menu Toggle
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            const navLinks = document.querySelector('.nav-links');

            if (mobileMenuBtn && navLinks) {
                mobileMenuBtn.addEventListener('click', function() {
                    navLinks.classList.toggle('active');
                    mobileMenuBtn.classList.toggle('active');
                });
            }

            // Dropdown Menus for Mobile
            const dropdowns = document.querySelectorAll('.dropdown');

            dropdowns.forEach(dropdown => {
                const link = dropdown.querySelector('a');
                const menu = dropdown.querySelector('.dropdown-menu');

                link.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768) { // Apply only on mobile
                        e.preventDefault();
                        menu.classList.toggle('active');
                    }
                });
            });

            // Animate Stats Counter
            const statNumbers = document.querySelectorAll('.stat-number');

            function animateStats() {
                statNumbers.forEach(stat => {
                    const target = parseInt(stat.getAttribute('data-count'));
                    const duration = 2000;
                    const step = target / (duration / 16);
                    let current = 0;

                    const counter = setInterval(() => {
                        current += step;
                        if (current >= target) {
                            clearInterval(counter);
                            stat.textContent = target.toLocaleString(); // Use toLocaleString for comma separation
                        } else {
                            stat.textContent = Math.floor(current).toLocaleString();
                        }
                    }, 16);
                });
            }

            // Only animate when stats are in viewport
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateStats();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 }); // Trigger when 50% of the element is visible

            const impactStats = document.querySelector('.impact-stats');
            if (impactStats) {
                observer.observe(impactStats);
            }

            // Simple Story Slider (Drag to scroll)
            const storySlider = document.querySelector('.story-slider');
            if (storySlider) {
                let isDown = false;
                let startX;
                let scrollLeft;

                storySlider.addEventListener('mousedown', (e) => {
                    isDown = true;
                    storySlider.classList.add('active');
                    startX = e.pageX - storySlider.offsetLeft;
                    scrollLeft = storySlider.scrollLeft;
                });

                storySlider.addEventListener('mouseleave', () => {
                    isDown = false;
                    storySlider.classList.remove('active');
                });

                storySlider.addEventListener('mouseup', () => {
                    isDown = false;
                    storySlider.classList.remove('active');
                });

                storySlider.addEventListener('mousemove', (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - storySlider.offsetLeft;
                    const walk = (x - startX) * 2; //scroll-fast
                    storySlider.scrollLeft = scrollLeft - walk;
                });
            }

            // Newsletter Form Submission (frontend only) - Removed as it's now a contact section
            // const newsletterForm = document.querySelector('.newsletter-form');
            // if (newsletterForm) {
            //     newsletterForm.addEventListener('submit', function(e) {
            //         e.preventDefault();
            //         const emailInput = this.querySelector('input[type="email]');
            //         if (emailInput.value) {
            //             alert('Thank you for subscribing to our newsletter!');
            //             emailInput.value = '';
            //         }
            //     });
            // }

            // Program Card Pop-up Functionality (now also for Success Stories)
            // Select all elements with the class 'read-more'
            const allReadMoreButtons = document.querySelectorAll('.read-more');
            const programModal = document.getElementById('programModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalContent = document.getElementById('modalContent');
            const closeButton = document.querySelector('.close-button');

            allReadMoreButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent default link behavior
                    const title = this.getAttribute('data-title');
                    const summary = this.getAttribute('data-summary');
                    const url = this.href;

                    // Fetch full story content from the API
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                console.warn(data.error);
                                // Fallback to summary if full content not available
                                modalTitle.textContent = title;
                                modalContent.textContent = summary;
                            } else {
                                modalTitle.textContent = data.title;
                                modalContent.textContent = data.content || data.summary;
                            }
                            programModal.style.display = 'flex'; // Show the modal
                        })
                        .catch(error => {
                            console.error('Error fetching story:', error);
                            // Fallback to summary
                            modalTitle.textContent = title;
                            modalContent.textContent = summary;
                            programModal.style.display = 'flex';
                        });
                });
            });

            // Close the modal when the close button is clicked
            closeButton.addEventListener('click', function() {
                programModal.style.display = 'none';
            });

            // Close the modal when clicking outside the modal content
            window.addEventListener('click', function(event) {
                if (event.target == programModal) {
                    programModal.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>

