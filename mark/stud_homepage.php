<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DRMS</title>
  <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include('includes/stud_nav.php') ?>

  <div class="hero" style="margin-top: 5.5%;">
    <img class="university-logo" src="./img/buplogo.png" alt="University Logo">
    <h1 class="text-center">DEGITAL RECORD MANAGEMENT SYSTEM</h1>
  </div>

  <div class="about mt-2 text-center">
    <h1 class="pt-5">ABOUT</h1> 

  </div>

  

 <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
  <script src="script.js"></script>
</body>
</html>


<script>
    const navLinks = document.getElementById('mainNav');
    const currentPath = window.location.pathname;
    const navLinksItems = navLinks.querySelectorAll('li a');

    navLinksItems.forEach(link => {
      const linkPath = link.getAttribute('href'); 
      if (linkPath === currentPath) {
        link.parentElement.classList.add('active');
      }
    });
</script>
