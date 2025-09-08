<?php
session_start();
$login_error = '';
if (isset($_SESSION['login_error'])) {
    $login_error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VolunteerConnect - Volunteer Coordination System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav>
                <!-- Logo -->
                <a href="index.php" class="logo">
                    <img src="images/Logo.png" alt="VolunteerConnect Logo">
                </a>
                
                <ul class="nav-links">
                    <li><a href="#top" id="top">Home</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#events">Events</a></li>
                    <li><a href="#testimonials">Testimonials</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <div class="auth-buttons">
                    <a href="#" class="btn" id="loginBtn">Login</a>
                    <a href="form.html" class="btn btn-secondary" id="signupBtn">Sign Up</a>
                    <!-- Help Button -->
                    <a href="help.php" class="btn btn-info">Help</a>

                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Connect, Volunteer, Make a Difference</h1>
            <p>Our platform makes it easy to find volunteer opportunities, manage events, and track your impact in the community.</p>
            
            <!-- CTA Buttons -->
            <div class="hero-buttons">
                <a href="#events" class="btn btn-primary">Find Opportunities</a>
                <a href="organization_overview.html" class="btn btn-secondary">Organize Volunteers</a>
            </div>
        </div>
    </div>
</section>
    <!-- Features Section -->
    <section id="features">
        <div class="container">
            <div class="section-title">
                <h2>What We Do!</h2>
                <p>We do everything you need to coordinate volunteers and make a positive impact in your community.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card feature-1">
                    <h3>Easy Event Creation</h3>
                    <p>Create volunteer events in minutes with our simple form. Add details, requirements, and needed roles.</p>
                </div>
                <div class="feature-card feature-2">
                    <h3>Volunteer Matching</h3>
                    <p>Our system matches volunteers with opportunities based on their skills, interests, and availability.</p>
                </div>
                <div class="feature-card feature-3">
                    <h3>Impact Tracking</h3>
                    <p>Track hours volunteered, tasks completed, and the overall impact your organization is making.</p>
                </div>
                <div class="feature-card feature-4">
                    <h3>Mobile Access</h3>
                    <p>Volunteers can sign up for events and receive updates on the go with our mobile-friendly platform.</p>
                </div>
                <div class="feature-card feature-5">
                    <h3>Automated Communications</h3>
                    <p>Send automatic reminders, updates, and thank you messages to keep volunteers engaged.</p>
                </div>
                <div class="feature-card feature-6">
                    <h3>Reporting & Analytics</h3>
                    <p>Generate detailed reports on volunteer participation, hours contributed, and event success.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section id="events" class="events-section">
        <div class="container">
            <div class="section-title">
                <h2>Upcoming Volunteer Events</h2>
                <p>Join these upcoming opportunities to make a difference in your community</p>
            </div>
        
            <div class="events-container" id="eventsContainer">
                <!-- Events will be loaded by JavaScript -->
            </div>
          <!--  <div style="text-align: center; margin-top: 40px;">
                <a href="#" class="btn btn-secondary">View All Events</a>
            </div>-->
            
        </div>
    </section>


     <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials">
        <div class="container">
            <div class="section-title">
                <h2>What People Are Saying</h2>
                <p>Hear from organizations and volunteers who have used our platform</p>
            </div>
            <div class="testimonial-container">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "This platform has revolutionized how we manage our volunteer program. We've seen a 40% increase in volunteer retention since we started using VolunteerConnect."
                    </div>
                    <div class="testimonial-author">
                        <img src="images/testimonial2.jpg" alt="Sarah Johnson" class="author-image">
                        <div class="author-details">
                            <h4>Sarah Johnson</h4>
                            <p>Nonprofit Director</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "I love how easy it is to find volunteering opportunities that match my skills and schedule. I've discovered causes I'm passionate about that I never knew existed."
                    </div>
                    <div class="testimonial-author">
                        <img src="images/testimonial1.jpg" alt="Michael Chen" class="author-image">
                        <div class="author-details">
                            <h4>Michael Chen</h4>
                            <p>Volunteer</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "The impact tracking features have been invaluable for reporting to our board and donors. We can now clearly demonstrate the difference our volunteers are making."
                    </div>
                     <div class="testimonial-author">
                        <img src="images/testimonial3.jpg" alt="Jessica Williams" class="author-image">
                        <div class="author-details">
                            <h4>Jessica Williams</h4>
                            <p>Nonprofit Executive Director</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Ready to Make a Difference?</h2>
            <p>Join thousands of volunteers and organizations who are using our platform to create positive change in communities around the world.</p>
            <a href="form.html" class="btn btn-accent">Sign Up as Volunteer</a>
            <a href="form.html" class="btn">Register Your Organization</a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>VolunteerConnect</h3>
                    <p>Making volunteer coordination simple and effective for organizations and volunteers alike.</p>
                    
                </div>
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#top">Home</a></li>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#events">Events</a></li>
                        <li><a href="#testimonials">Testimonials</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Resources</h3>
                    <ul class="footer-links">
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Volunteer Guidelines</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <ul class="footer-links">
                        <li>Email: info@volunteerconnect.org</li>
                        <li>Phone: (555) 123-4567</li>
                        <li>Address: 123 Volunteer Street, Community City</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2023 VolunteerConnect. All rights reserved.</p>
            </div>
        </div>
    </footer>


    <!-- Placeholder for Login Modal -->
    <div id="loginModalContainer"></div>
    <!-- Login Modal -->
<div class="modal" id="loginModal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Login to Your Account</h2>
        <form id="loginForm" action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
         <?php if (!empty($login_error)) : ?>
    <div id="loginError" style="color:red; margin-bottom:10px;">
        <?= htmlspecialchars($login_error) ?>
    </div>
<?php else: ?>
    <div id="loginError" style="color:red; margin-bottom:10px; display:none;"></div>

<?php endif; ?>


            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</div>


    <script src="script.js"></script>
    <script src="script_event.js"></script>
    <!-- Hidden Admin Login Button -->
<a href="#" class="btn" id="adminLoginBtn">Admin Login</a>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Show modal automatically if there’s an error
    <?php if (!empty($login_error)) : ?>
        const loginModal = document.getElementById("loginModal");
        if (loginModal) {
            loginModal.style.display = "block";
        }
    <?php endif; ?>
    // Footer double-click → open modal
     const adminBtn = document.getElementById("adminLoginBtn");
    const loginModal = document.getElementById("loginModal");

    if (adminBtn) {
        adminBtn.addEventListener("click", function(e) {
            e.preventDefault();
            
            // Show message
            alert("You must log in as Admin to access admin.php");

            // Open login modal
            if (loginModal) {
                loginModal.style.display = "block";
            }
        });
    }
});
</script>


</body>
</html>
