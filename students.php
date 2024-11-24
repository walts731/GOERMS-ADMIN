<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Access</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include('includes/nav.php') ?>
  <div class="hero">
    <img class="university-logo" src="img/LOGO 1.png" alt="University Logo">
    <h1 class="text-center">STUDENT PROFILE</h1>
  </div>

  <div class="col-12 mb-3 mt-5">
                    <form class="d-flex" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input class="form-control me-2 rounded-full" type="search" placeholder="Search" aria-label="Search" name="search_term">
                        <button class="btn btn-outline-success rounded-full" type="submit">Search</button>
                    </form>
                </div>

  <div class="container mt-5">
    <div class="row">
      <div class="col-12">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Student No.</th>
              <th>Course</th>
              <th>College</th>
              <th>Email</th>
              <th>Email Address</th>
              <th>Cp No.</th>
              <th>More Details</th>
            </tr>
          </thead>
          <tbody>
          
          </tbody>
        </table>
      </div>
    </div>
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