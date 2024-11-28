<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Access</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="mark/css/styles.css">
  <style>
    

    /* Custom class to center the button below the hero */
    .btn-container {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    /* Custom orange button style */
    .btn-orange {
      background-color: orange;
      color: white;
    }

    .btn-orange:hover {
      background-color: #e68a00; /* Darker shade of orange when hovered */
    }
  </style>
</head>
<body>
    <?php include('includes/nav.php') ?>

  <div class="hero">
    <img class="university-logo" src="img/LOGO 1.png" alt="University Logo" style="max-width: 100px; margin-bottom: 20px;">
    <h1 class="text-center">ADMIN ACCESS</h1>
  </div>

  <!-- Container to center the button below the hero section -->
  <div class="btn-container">
    <button 
      class="btn btn-orange rounded-pill" 
      onclick="window.location.href='create_form.php';">
      CREATE NEW FORM
    </button>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
