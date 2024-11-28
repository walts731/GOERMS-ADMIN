<?php
// Include the database connection file
include('includes/connect.php');

// SQL query to fetch all students
$sql = "SELECT `student_id`, `username`, `first_name`, `last_name`, `email`, `date_of_birth`, `created_at` FROM `student_user`";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Students List</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

  <!-- Include the navigation bar -->
  <?php include('includes/nav.php'); ?>

  <div class="container mt-5">
    <h1 class="text-center mb-4">Students List</h1>

    <!-- Check if there are any students in the database -->
    <?php if ($result->num_rows > 0): ?>

      <!-- Table to display the students -->
      <table class="table table-bordered table-striped">
        <thead class="thead-dark">
          <tr>
            <th>Student ID</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Date of Birth</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['student_id']); ?></td>
              <td><?php echo htmlspecialchars($row['username']); ?></td>
              <td><?php echo htmlspecialchars($row['first_name']); ?></td>
              <td><?php echo htmlspecialchars($row['last_name']); ?></td>
              <td><?php echo htmlspecialchars($row['email']); ?></td>
              <td><?php echo htmlspecialchars($row['date_of_birth']); ?></td>
              <td><?php echo htmlspecialchars($row['created_at']); ?></td>
              <td>
                <!-- Action button to view responses -->
                <a href="view_responses.php?student_id=<?php echo $row['student_id']; ?>" class="btn btn-info btn-sm">View Responses</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>

    <?php else: ?>
      <div class="alert alert-warning text-center">No students found in the database.</div>
    <?php endif; ?>

  </div>

  <!-- Bootstrap JS (optional for some interactive elements) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
