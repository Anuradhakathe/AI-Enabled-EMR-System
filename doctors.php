<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <!-- Meta Tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="keywords" content="Site keywords here">
		<meta name="description" content="">
		<meta name='copyright' content=''>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<!-- Title -->
        <title>AI Powered EMR System</title>
		
		<!-- Favicon -->
        <link rel="icon" href="img/favicon.png">
		
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Nice Select CSS -->
		<link rel="stylesheet" href="css/nice-select.css">
		<!-- Font Awesome CSS -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- icofont CSS -->
        <link rel="stylesheet" href="css/icofont.css">
		<!-- Slicknav -->
		<link rel="stylesheet" href="css/slicknav.min.css">
		<!-- Owl Carousel CSS -->
        <link rel="stylesheet" href="css/owl-carousel.css">
		<!-- Datepicker CSS -->
		<link rel="stylesheet" href="css/datepicker.css">
		<!-- Animate CSS -->
        <link rel="stylesheet" href="css/animate.min.css">
		<!-- Magnific Popup CSS -->
        <link rel="stylesheet" href="css/magnific-popup.css">
		
		<!-- Medipro CSS -->
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="css/responsive.css">
		
    </head>
    <body>
	
		<!-- Header Area -->
		<header class="header" >
			<!-- Header Inner -->
			<div class="header-inner">
				<div class="container">
					<div class="inner">
						<div class="row">
							<div class="col-lg-3 col-md-3 col-12">
								<!-- Mobile Nav -->
								<div class="mobile-nav"></div>
								<!-- End Mobile Nav -->
							</div>
							<div class="col-lg-7 col-md-9 col-12">
								<!-- Main Menu -->
								<div class="main-menu">
									<nav class="navigation">
										<ul class="nav menu">
											<li><a href="index.php">Home</a></li>
											<li><a href="Doctors.php">Doctors </a></li>
											<li><a href="Services.php">Services </a></li>
											<li><a href="backend/doc/index.php">login</a></li>
											<li><a href="backend/admin/index.php">Admin login</a></li>
											<li><a href="contact.html">Contact Us</a></li>
										</ul>
									</nav>
								</div>
								<!--/ End Main Menu -->
							</div>
							<div class="col-lg-2 col-12">
								<div class="get-quote">
									<a href="backend/doc/index.php" class="btn">Book Appointment</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Header Inner -->
		</header>
		<!-- End Header Area -->

    <!-- Breadcrumbs -->
    <section class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Meet Our Expert Doctors</h2>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><i class="fa fa-angle-right"></i></li>
                        <li>Doctors</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- End Breadcrumbs -->

<!-- Floating Chatbot Button -->
<div id="chatbot-container">
    <button id="chatbot-btn" onclick="toggleChatbot()">💬 Chat with AI</button>
    <div id="chatbot-box">
        <iframe src="chatbot.html" id="chatbot-frame"></iframe>
    </div>
</div>

<!-- Chatbot Styles -->
<style>
    #chatbot-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }
    #chatbot-btn {
        background: #007bff;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 50px;
        cursor: pointer;
    }
    #chatbot-box {
        display: none;
        position: fixed;
        bottom: 70px;
        right: 20px;
        width: 350px;
        height: 500px;
        background: white;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }
    #chatbot-frame {
        width: 100%;
        height: 100%;
        border: none;
    }
</style>

<!-- Chatbot Script -->
<script>
    function toggleChatbot() {
        var box = document.getElementById("chatbot-box");
        box.style.display = (box.style.display === "block") ? "none" : "block";
    }
</script>


    <!-- Doctors Section -->
<section class="doctors section py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center text-center mb-4">
            <div class="col-lg-8">
                <h2 class="mb-3">Meet Our Experts</h2>
                <p class="text-muted">Our team of specialists is here to provide exceptional care and support across a wide range of medical fields.</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Doctor Card Template -->
            <?php
            $doctors = [
                ['name' => 'Dr. Emily Johnson', 'spec' => 'Cardiologist', 'desc' => 'Specializing in heart health and cardiovascular treatments.'],
                ['name' => 'Dr. Michael Smith', 'spec' => 'Orthopedic Surgeon', 'desc' => 'Expert in joint replacements and bone health.'],
                ['name' => 'Dr. Sarah Lee', 'spec' => 'Neurologist', 'desc' => 'Specialist in brain disorders and nervous system treatments.'],
                ['name' => 'Dr. David Brown', 'spec' => 'Dermatologist', 'desc' => 'Expert in skin health, allergies, and cosmetic treatments.'],
                ['name' => 'Dr. Olivia Martinez', 'spec' => 'Pediatrician', 'desc' => 'Specialist in child healthcare and development.'],
                ['name' => 'Dr. William Anderson', 'spec' => 'ENT Specialist', 'desc' => 'Specialist in ear, nose, and throat disorders.'],
                ['name' => 'Dr. Sophia Carter', 'spec' => 'Ophthalmologist', 'desc' => 'Expert in vision care and eye surgeries.'],
                ['name' => 'Dr. James Wilson', 'spec' => 'General Physician', 'desc' => 'Providing overall healthcare and medical consultations.'],
                ['name' => 'Dr. Amanda Clark', 'spec' => 'Gynecologist', 'desc' => 'Specialist in women\'s reproductive health and maternity care.']
            ];

            foreach ($doctors as $doc) {
                echo '
                <div class="col-lg-4 col-md-6">
                    <div class="card doctor-card h-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column justify-content-between text-center p-4">
                            <div>
                                <h5 class="doctor-name mb-1">' . $doc['name'] . '</h5>
                                <p class="speciality text-primary fw-semibold mb-2">' . $doc['spec'] . '</p>
                                <p class="text-muted small">' . $doc['desc'] . '</p>
                            </div>
                            <a href="backend/doc/index.php" class="btn btn-outline-primary mt-3">Book Appointment</a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>
</section>

<!-- CSS -->
<style>
    /* Doctor Card Styling */
.doctor-card {
    border-radius: 16px;
    background: #fff;
    padding: 30px 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease-in-out;
    height: 100%;
}

.doctor-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.doctor-name {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.2rem;
}

.speciality {
    color: #007bff;
    font-weight: 500;
    margin-bottom: 10px;
}

.doctor-card p {
    font-size: 0.93rem;
    color: #666;
    margin-bottom: 20px;
}

.doctor-card .btn {
    background: #007bff;
    color: #fff;
    padding: 10px 24px;
    font-size: 0.9rem;
    border-radius: 30px;
    transition: background 0.3s ease-in-out;
}

.doctor-card .btn:hover {
    background: #0056b3;
}

/* Row gap spacing */
.doctors .row.g-4 > [class*='col-'] {
    margin-bottom: 30px;
}

</style>



   <!-- Footer Area -->
		<footer id="footer" class="footer ">
			<!-- Footer Top -->
			<div class="footer-top">
				<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer">
								<h2>About Us</h2>
								<p>Committed to care, innovation, and your well-being journey.</p>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer f-link">
								<h2>Quick Links</h2>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-12">
										<ul>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Home</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>About Us</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Services</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Our Cases</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Other Links</a></li>	
										</ul>
									</div>
									<div class="col-lg-6 col-md-6 col-12">
										<ul>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Consuling</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Finance</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Testimonials</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>FAQ</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Contact Us</a></li>	
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Footer Top -->
			<!-- Copyright -->
			<div class="copyright">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-12">
							<div class="copyright-content">
								<p>AI Powered EMR System</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Copyright -->
		</footer>
		<!--/ End Footer Area -->
		
		<!-- jquery Min JS -->
        <script src="js/jquery.min.js"></script>
		<!-- jquery Migrate JS -->
		<script src="js/jquery-migrate-3.0.0.js"></script>
		<!-- jquery Ui JS -->
		<script src="js/jquery-ui.min.js"></script>
		<!-- Easing JS -->
        <script src="js/easing.js"></script>
		<!-- Color JS -->
		<script src="js/colors.js"></script>
		<!-- Popper JS -->
		<script src="js/popper.min.js"></script>
		<!-- Bootstrap Datepicker JS -->
		<script src="js/bootstrap-datepicker.js"></script>
		<!-- Jquery Nav JS -->
        <script src="js/jquery.nav.js"></script>
		<!-- Slicknav JS -->
		<script src="js/slicknav.min.js"></script>
		<!-- ScrollUp JS -->
        <script src="js/jquery.scrollUp.min.js"></script>
		<!-- Niceselect JS -->
		<script src="js/niceselect.js"></script>
		<!-- Tilt Jquery JS -->
		<script src="js/tilt.jquery.min.js"></script>
		<!-- Owl Carousel JS -->
        <script src="js/owl-carousel.js"></script>
		<!-- counterup JS -->
		<script src="js/jquery.counterup.min.js"></script>
		<!-- Steller JS -->
		<script src="js/steller.js"></script>
		<!-- Wow JS -->
		<script src="js/wow.min.js"></script>
		<!-- Magnific Popup JS -->
		<script src="js/jquery.magnific-popup.min.js"></script>
		<!-- Counter Up CDN JS -->
		<script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Main JS -->
		<script src="js/main.js"></script>
    </body>
</html>