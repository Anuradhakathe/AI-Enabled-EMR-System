<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <!-- Meta Tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="keywords" content="AI Powered EMR Services">
        <meta name="description" content="Our healthcare services powered by AI">
        <meta name='copyright' content=''>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Title -->
        <title>Our Services - AI Powered EMR System</title>

        <!-- Favicon -->
        <link rel="icon" href="img/favicon.png">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
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
        <header class="header">
            <div class="header-inner">
                <div class="container">
                    <div class="inner">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-12">
                                <div class="mobile-nav"></div>
                            </div>
                            <div class="col-lg-7 col-md-9 col-12">
                                <div class="main-menu">
                                    <nav class="navigation">
                                        <ul class="nav menu">
                                            <li><a href="index.php">Home</a></li>
                                            <li><a href="Doctors.php">Doctors</a></li>
                                            <li class="active"><a href="Services.php">Services</a></li>
                                            <li><a href="backend/doc/index.php">Login</a></li>
                                            <li><a href="backend/admin/index.php">Admin Login</a></li>
                                            <li><a href="contact.html">Contact Us</a></li>
                                        </ul>
                                    </nav>
                                </div>
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
        </header>
        <!-- End Header Area -->

        <!-- Breadcrumbs -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>Our Healthcare Services</h2>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><i class="fa fa-angle-right"></i></li>
                            <li>Services</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Breadcrumbs -->

        <!-- Services Section -->
        <section class="services section">
            <div class="container">
                <div class="row">
                    <!-- Service 1 -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-service card">
                            <div class="card-body text-center">
                                <i class="fa fa-stethoscope service-icon"></i>
                                <h4>AI-Powered Diagnostics</h4>
                                <p>Advanced AI algorithms for accurate and efficient disease diagnosis.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Service 2 -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-service card">
                            <div class="card-body text-center">
                                <i class="fa fa-medkit service-icon"></i>
                                <h4>24/7 Virtual Consultations</h4>
                                <p>Instant access to expert doctors through our AI-powered telemedicine.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Service 3 -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-service card">
                            <div class="card-body text-center">
                                <i class="fa fa-user-md service-icon"></i>
                                <h4>Electronic Medical Records</h4>
                                <p>Secure and efficient digital records management for all patients.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Service 4 -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-service card">
                            <div class="card-body text-center">
                                <i class="fa fa-heartbeat service-icon"></i>
                                <h4>AI-Based Health Monitoring</h4>
                                <p>Track your vitals in real-time with AI-driven health monitoring tools.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Service 5 -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-service card">
                            <div class="card-body text-center">
                                <i class="fa fa-flask service-icon"></i>
                                <h4>Automated Lab Reports</h4>
                                <p>Receive AI-analyzed lab test reports instantly for quicker decisions.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Service 6 -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-service card">
                            <div class="card-body text-center">
                                <i class="fa fa-ambulance service-icon"></i>
                                <h4>Emergency Assistance</h4>
                                <p>AI-powered emergency response to provide immediate medical attention.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Services Section -->

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


        <!-- Footer Area -->
        <footer id="footer" class="footer">
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
                                <ul>
                                    <li><a href="#">Home</a></li>
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="#">Services</a></li>
                                    <li><a href="#">Contact Us</a></li>	
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
        </footer>
        <!-- End Footer Area -->

        <style>
            .single-doctor.card {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 25px;
    height: 100%;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px; /* Adds more spacing between cards */
    transition: transform 0.3s ease-in-out;
}

.single-doctor.card:hover {
    transform: scale(1.05); /* Slight hover effect to make the card pop */
}

.card-body {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    text-align: center;
    min-height: 200px; /* Increased card size */
}

.speciality {
    font-weight: bold;
    color: #007bff;
    font-size: 1.1rem;
}

.btn-primary {
    background-color: rgb(209, 208, 208);
    color: #fff;
    border: none;
    padding: 12px 18px;
    border-radius: 5px;
    text-decoration: none;
    transition: 0.3s;
    font-size: 1rem;
}

.btn-primary:hover {
    background-color: #0056b3;
}

        </style>
    </body>
</html>
