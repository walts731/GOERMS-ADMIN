<?php
// Include the database connection file
include('includes/connect.php');

// Retrieve the forms from the database, including the status column
$sql = "SELECT `form_id`, `form_name`, `description`, `created_by`, `created_at`, `status` FROM `forms`";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - View Forms</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="mark/css/styles.css">
</head>
<body>

  <!-- Include the navigation bar -->
  <?php include('includes/nav.php'); ?>

  <div class="container mt-5">
    <h1 class="text-center mb-4">View Forms</h1>

    <!-- Check if there are any forms in the database -->
    <?php if ($result->num_rows > 0): ?>

      <!-- Table to display the forms -->
      <table class="table table-bordered table-striped">
        <thead class="thead-dark">
          <tr>
            <th>Form ID</th>
            <th>Form Name</th>
            <th>Description</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['form_id']); ?></td>
              <td><?php echo htmlspecialchars($row['form_name']); ?></td>
              <td><?php echo htmlspecialchars($row['description']); ?></td>
              <td><?php echo htmlspecialchars($row['created_by']); ?></td>
              <td><?php echo htmlspecialchars($row['created_at']); ?></td>
              <td><?php echo htmlspecialchars($row['status']); ?></td>
              <td>
    <!-- Action buttons -->
    <a href="view_form.php?form_id=<?php echo $row['form_id']; ?>" class="btn btn-info btn-sm">View</a>
    <a href="edit_form.php?form_id=<?php echo $row['form_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
    <a href="edit_form_fields.php?form_id=<?php echo $row['form_id']; ?>" class="btn btn-secondary btn-sm">Edit Fields</a>
    <?php if ($row['status'] === 'active'): ?>
        <a href="toggle_status.php?form_id=<?php echo $row['form_id']; ?>&action=deactivate" 
           class="btn btn-warning btn-sm">Deactivate</a>
    <?php else: ?>
        <a href="toggle_status.php?form_id=<?php echo $row['form_id']; ?>&action=activate" 
           class="btn btn-success btn-sm">Activate</a>
    <?php endif; ?>
</td>

            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>

    <?php else: ?>
      <div class="alert alert-warning text-center">No forms found in the database.</div>
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
