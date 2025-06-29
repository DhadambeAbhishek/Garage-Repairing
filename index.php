<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>RMC&B Garage</title>
  <style>* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Arial', sans-serif;
  line-height: 1.6;
}

.container {
  width: 80%;
  margin: 0 auto;
}

header {
  background: #333;
  color: #fff;
  padding: 20px 0;
}

header h1 {
  text-align: center;
  font-size: 2.5em;
}

nav ul {
  display: flex;
  justify-content: center;
  list-style: none;
}

nav ul li {
  margin: 0 15px;
}

nav ul li a {
  color: #fff;
  text-decoration: none;
  font-size: 1.2em;
}

nav ul li a:hover {
  color: #f0a500;
}

#hero {
  color: #fff;
  text-align: center;
  padding: 80px 0;
}

.hero-content h2 {
  font-size: 3em;
}

.hero-content p {
  font-size: 1.2em;
  margin: 20px 0;
}

.cta-btn {
  background: #f0a500;
  color: #fff;
  padding: 10px 20px;
  text-decoration: none;
  font-size: 1.1em;
  border-radius: 5px;
  margin-bottom: 10px ;
}

.cta-btn:hover {
  background: #e09c00;
}

section {
  padding: 60px 0;
}

h2 {
  text-align: center;
  margin-bottom: 30px;
}

/* Service List */
.service-list {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 30px; /* Space between items */
    padding: 20px; /* Adds padding around the service boxes */
}

/* Service Item */
.service-item {
    width: 280px; /* Increased width */
    height: 220px; /* Increased height */
    position: relative;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: white;
    font-weight: bold;
    transition: 0.4s ease;
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
    margin: 10px; /* Adds space around each item */
}

/* Add Background Images */
#image1 { background-image: url('./uploads/OIP.jpg'); }
#image2 { background-image: url('./uploads/paint.png'); }
#image3 { background-image: url('./uploads/battery.png'); }
#image4 { background-image: url('./uploads/bikePeriodicServices.png'); }
#image5 { background-image: url('./uploads/bikeDentingPainting.png'); }
#image6 { background-image: url('./uploads/bikebattery.png'); }

/* Hide Text Initially */
.hover-text {
    opacity: 0;
    font-size: 16px;
    position: absolute;
    background: rgba(252, 250, 250, 0.7);
    padding: 15px;
    border-radius: 5px;
    transition: opacity 0.4s ease;
}

/* Hover Effect: Hide Image, Show Text */
.service-item:hover {
    background-image: none !important;
    background-color:rgb(239, 241, 242);
    color: white;
}

.service-item:hover .hover-text {
    opacity: 1;
}
.service-item:hover {
  transform:invisible(1.05);
  transform: scale(1.05); /* Optional: Scale effect when hovering */
  color:black;
}

.service-item h3 {
  font-size: 1.5em;
}

#about p {
  font-size: 1.1em;
  text-align: center;
  max-width: 800px;
  margin: 20px auto;
}

@media (max-width: 768px) {
  .service-list {
    flex-direction: column;
  }

  .service-item {
    width: 100%;
    margin-bottom: 30px;
  }

  #hero h2 {
    font-size: 2.5em;
  }

  #hero p {
    font-size: 1em;
  }
}
</style>
</head>
<body>
  <header>
    <div class="container">
      <h1>Welcome to RMC&B Garage</h1>
      <nav>
        <ul>
          <li><a href="#services">Our Services</a></li>
          <li><a href="#about">About Us</a></li>
          <li><a href="#contact">Contact</a></li>
          <li><a href="login.php">Login</a></li><br>
        </ul>
      </nav>
    </div>
  </header>

 <!----for button using----->
 <style>#hero {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f4f4f4;
    padding: 50px 10%;
}

.hero-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1200px;
    width: 100%;
    gap: 30px;
}

.hero-content {
    flex: 1;
    max-width: 50%;
}

.hero-content h2 {
    font-size: 2rem;
    color: #333;
}

.hero-content p {
    font-size: 1.2rem;
    color: #555;
    margin: 10px 0;
}

.cta-btn {
    display: inline-block;
    padding: 10px 20px;
    background: #ff5733;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-size: 1.1rem;
    margin-top: 10px;
}

.hero-image {
    flex: 1;
    max-width: 50%;
}

.hero-image img {
    width: 100%;
    height: auto;
    border-radius: 10px;
}
</style>
  <section id="hero">
    <div class="hero-container">
        <!-- Left Side: Hero Content -->
        <div class="hero-content">
            <h2>Get Your Car & Bike Serviced by Experts</h2>
            <p>High-quality auto repairs and services for all car & bike brands.</p>
            <a href="login.php" class="cta-btn">Book Now</a>
        </div>

        <!-- Right Side: Image -->
        <div class="hero-image">
            <img src="./uploads/carimg.png" alt="Car Service">
        </div>
    </div>
<!--------->
</section>
<section id="services">
  <div class="container">
    <h2>Our Car Services</h2>
    <div class="service-list">
      <div class="service-item" id="image1">
        <p class="hover-text">Periodic Services Keep your car in top shape with our routine maintenance services.</p>
      </div>
      <div class="service-item" id="image2">
        <p class="hover-text">Denting and Painting Repair and restore your car's exterior to perfection.</p>
      </div>
      <div class="service-item" id="image3">
        <p class="hover-text">Batteries Get your battery checked and replaced by professionals.</p>
      </div>
    </div>
  </div>

  <div class="container">
    <h2>Our Bike Services</h2>
    <div class="service-list">
      <div class="service-item" id="image4">
        <p class="hover-text">Periodic Services Keep your bike in top shape with our routine maintenance services.</p>
      </div>
      <div class="service-item" id="image5">
        <p class="hover-text">Denting and Painting Repair and restore your bike's exterior to perfection.</p>
      </div>
      <div class="service-item" id="image6">
        <p class="hover-text">Batteries Get your bike battery checked and replaced by professionals.</p>
      </div>
    </div>
  </div>
</section>

  <section id="about">
    <div class="container">
      <h2>About Us</h2>
      <p>At RMC&B Garage, we provide expert car repairs and services, ensuring that your vehicle runs smoothly and efficiently. Our team is dedicated to delivering quality service with a focus on customer satisfaction.</p>
    </div>
  </section>

  <section id="contact">
    <div class="container">
      <h2>Contact Us</h2>
      <p>Have questions or want to schedule a service? Reach out to us!</p>
      <a href="mailto:info@rmcgarage.com" class="cta-btn">Email Us</a>
    </div>
  </section>

  <?php include 'footer.php'; ?>
</body>
</html>