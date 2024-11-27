<?php include('../includes/connect.php')?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Homepage</title>
  <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include('includes/stud_nav.php') ?>

  <div class="hero" style="margin-top: 5.5%;">
    <img class="university-logo" src="./img/buplogo.png" alt="University Logo">
    <h1 class="text-center">LIST OF FORMS</h1>
  </div>

  <div class="container">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Form ID</th>
          <th>Form Name</th>
          <th>Description</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Assuming you have a database connection established
        $sql = "SELECT `form_id`, `form_name`, `description`, `created_by`, `created_at` FROM `forms`";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["form_id"] . "</td>";
            echo "<td>" . $row["form_name"] . "</td>";
            echo "<td>" . $row["description"] . "</td>";
            echo "<td><a href='fill_form.php?form_id=" . $row["form_id"] . "' class='btn btn-primary'>Fill Up</a></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='4'>No forms found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
  <script src="script.js"></script>
</body>
</html>

