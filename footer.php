<!-- Enhanced Footer Design -->
<footer class="enhanced-footer">
    <div class="footer-container">
        <div class="footer-grid">
            <!-- Brand Column -->
            <div class="footer-brand">
                <div class="brand-icon">BR</div>
                <h3>Book Rental</h3>
                <p>Online Books for rent</p>
                <p class="tagline">Rent novels, academic & bestsellers at affordable prices.</p>
            </div>

            <!-- Quick Links Column -->
            <div class="footer-links">
                <div class="footer-col">
                    <h5>Explore</h5>
                    <a href="index.php"><i class="fas fa-home"></i> Home</a>
                    <a href="bookCategory.php"><i class="fas fa-book"></i> Categories</a>
                    <a href="aboutUs.php"><i class="fas fa-info-circle"></i> About Us</a>
                    <a href="contactUs.php"><i class="fas fa-envelope"></i> Contact</a>
                </div>

                <!-- Legal Column with Conditional Admin Link -->
                <div class="footer-col">
                    <h5>Legal</h5>
                    <a href="termsAndCondition.php"><i class="fas fa-file-contract"></i> Terms & Conditions</a>
                    <a href="#"><i class="fas fa-lock"></i> Privacy Policy</a>
                    <?php
                    if (!isset($_SESSION['USER_LOGIN'])) {
                        echo '<a href="Admin/login.php"><i class="fas fa-user-shield"></i> Admin Login</a>';
                    }
                    ?>
                </div>

                <!-- Contact / Social Column -->
                <div class="footer-col">
                    <h5>Connect</h5>
                    <a href="mailto:contact@bookrental.com"><i class="fas fa-envelope"></i> contact@bookrental.com</a>
                    <a href="tel:+911234567890"><i class="fas fa-phone-alt"></i> +91 1234567890</a>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="copyright">
            &copy; <?php echo date('Y'); ?> <strong>Book Rental</strong>. All Rights Reserved.
        </div>
    </div>
</footer>

<!-- Scroll Up Button (enhanced style) -->
<div id="scrollBtn">
    <button onclick="topFunction()" id="ScrollUpBtn" title="Go to top">
        <i class="fas fa-chevron-up"></i>
    </button>
</div>

<!-- Dark Mode Toggle (enhanced style) -->
<div id="dark-btn">
    <button onclick="DarkMode()" id="dark-btn" title="Toggle Light/Dark Mode">
        <i class="fas fa-adjust"></i>
    </button>
</div>

<style>
    /* Enhanced Footer Styles - Design Only */
    .enhanced-footer {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #94a3b8;
        padding: 3rem 1rem 2rem;
        margin-top: 4rem;
        border-top: 1px solid rgba(255,255,255,0.08);
    }
    .footer-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    .footer-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 2rem;
        margin-bottom: 2rem;
    }
    .footer-brand {
        flex: 2;
        min-width: 200px;
    }
    .brand-icon {
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.6rem;
        color: white;
        margin-bottom: 1rem;
        box-shadow: 0 6px 12px rgba(0,0,0,0.2);
    }
    .footer-brand h3 {
        color: white;
        font-size: 1.3rem;
        margin-bottom: 0.25rem;
        font-weight: 700;
    }
    .footer-brand p {
        font-size: 0.85rem;
        margin-bottom: 0.3rem;
    }
    .tagline {
        font-size: 0.75rem;
        opacity: 0.7;
    }
    .footer-links {
        flex: 3;
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        justify-content: flex-end;
    }
    .footer-col {
        min-width: 140px;
    }
    .footer-col h5 {
        color: #e2e8f0;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1rem;
        letter-spacing: 0.5px;
        position: relative;
        display: inline-block;
    }
    .footer-col h5:after {
        content: '';
        position: absolute;
        bottom: -6px;
        left: 0;
        width: 30px;
        height: 2px;
        background: #3b82f6;
        border-radius: 2px;
    }
    .footer-col a {
        display: block;
        color: #94a3b8;
        text-decoration: none;
        margin-bottom: 0.6rem;
        transition: 0.2s;
        font-size: 0.85rem;
    }
    .footer-col a i {
        width: 1.4rem;
        margin-right: 0.3rem;
        font-size: 0.85rem;
    }
    .footer-col a:hover {
        color: #60a5fa;
        transform: translateX(4px);
    }
    .social-icons {
        margin-top: 1rem;
        display: flex;
        gap: 1rem;
    }
    .social-icons a {
        display: inline-flex;
        width: 32px;
        height: 32px;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transition: 0.2s;
        margin-bottom: 0;
    }
    .social-icons a:hover {
        background: #3b82f6;
        transform: translateY(-2px);
    }
    .copyright {
        text-align: center;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(255,255,255,0.08);
        font-size: 0.75rem;
    }

    /* Scroll Up Button */
    #scrollBtn {
        position: fixed;
        bottom: 80px;
        right: 20px;
        z-index: 99;
    }
    #ScrollUpBtn {
        background: #2563eb;
        border: none;
        border-radius: 50px;
        width: 44px;
        height: 44px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: 0.2s;
        display: none;
        color: white;
        font-size: 1.2rem;
    }
    #ScrollUpBtn:hover {
        background: #1d4ed8;
        transform: translateY(-3px);
    }

    /* Dark Mode Button */
    #dark-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 99;
    }
    #dark-btn button {
        background: #1e293b;
        border: none;
        border-radius: 50px;
        width: 44px;
        height: 44px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        cursor: pointer;
        transition: 0.2s;
        color: white;
        font-size: 1.2rem;
    }
    #dark-btn button:hover {
        transform: scale(1.05);
        background: #0f172a;
    }

    /* Dark Mode Overrides for Footer */
    body.dark-mode .enhanced-footer {
        background: linear-gradient(135deg, #0a0f1a, #0f172a);
        border-top-color: #1e293b;
    }
    body.dark-mode .footer-col a {
        color: #6b7280;
    }
    body.dark-mode .footer-col a:hover {
        color: #3b82f6;
    }
    body.dark-mode #dark-btn button {
        background: #334155;
    }
    body.dark-mode #dark-btn button i {
        color: #f1f5f9;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .footer-grid {
            flex-direction: column;
            text-align: center;
        }
        .footer-links {
            justify-content: center;
            text-align: center;
        }
        .footer-col h5:after {
            left: 50%;
            transform: translateX(-50%);
        }
        .footer-col a {
            display: inline-block;
            margin: 0 0.75rem 0.5rem;
        }
        .footer-col a i {
            width: auto;
            margin-right: 0.3rem;
        }
        .footer-col a:hover {
            transform: translateY(-2px);
        }
        .brand-icon {
            margin: 0 auto 1rem;
        }
        .social-icons {
            justify-content: center;
        }
    }
</style>

<script>
    // Scroll button logic (preserved)
    let mybutton = document.getElementById("ScrollUpBtn");
    window.onscroll = function() { scrollFunction(); };
    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }

    // Dark Mode function (preserved, with localStorage optional but keeping original)
    function DarkMode() {
        let element = document.body;
        element.classList.toggle("dark-mode");
        if (element.classList.contains("dark-mode")) {
            localStorage.setItem("darkMode", "enabled");
        } else {
            localStorage.setItem("darkMode", "disabled");
        }
    }
    // Load saved preference (optional addition, does not break original)
    if (localStorage.getItem("darkMode") === "enabled") {
        document.body.classList.add("dark-mode");
    }
</script>