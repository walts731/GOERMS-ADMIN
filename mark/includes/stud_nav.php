<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="container navbar-brand ms-5" href="stud_homepage.php" style="color: orange;">DRMS</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse mx-5" id="mainNav">
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link text-light <?= basename($_SERVER['PHP_SELF']) == 'stud_homepage.php' ? 'active' : '' ?>" href="stud_homepage.php">Home</a></li>
      <li class="nav-item"><a class="nav-link text-light <?= basename($_SERVER['PHP_SELF']) == 'forms.php' ? 'active' : '' ?>" href="forms.php">Forms</a></li>
      <li class="nav-item"><a class="nav-link text-light <?= basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : '' ?>" href="about.php">About</a></li>
      <li class="nav-item"><a class="nav-link text-light <?= basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : '' ?>" href="contact.php">Contact</a></li>
      <li class="nav-item"><a class="nav-link text-light <?= basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : '' ?>" href="login.php">Logout</a></li>
    </ul>
  </div>
</nav>


<script>

    // JavaScript to toggle 'active' class on the navbar links
    document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
        link.addEventListener('click', function() {
            // Remove 'active' class from all links
            document.querySelectorAll('.navbar-nav .nav-link').forEach(l => l.classList.remove('active'));
            // Add 'active' class to the clicked link
            this.classList.add('active');
        });
    });

</script>