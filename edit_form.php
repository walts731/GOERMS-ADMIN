<?php
include('includes/connect.php');

// Check if the form_id is provided
if (isset($_GET['form_id'])) {
    $form_id = intval($_GET['form_id']);

    // Fetch the existing form details
    $sql = "SELECT `form_id`, `form_name`, `description`, `created_by`, `created_at`, `status` FROM `forms` WHERE `form_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $form_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $form = $result->fetch_assoc();

    if (!$form) {
        echo "<div class='alert alert-danger'>Form not found.</div>";
        exit();
    }

    // If the form is submitted, update the form details
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $form_name = $_POST['form_name'];
        $description = $_POST['description'];
        $status = $_POST['status'];

        // Update query
        $update_sql = "UPDATE `forms` SET `form_name` = ?, `description` = ?, `status` = ? WHERE `form_id` = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssi", $form_name, $description, $status, $form_id);

        if ($update_stmt->execute()) {
            echo "<div class='alert alert-success'>Form updated successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error updating form: " . $conn->error . "</div>";
        }

        $update_stmt->close();
    }

    $stmt->close();
} else {
    echo "<div class='alert alert-danger'>Invalid form ID.</div>";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Form</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Edit Form</h1>

    <form method="POST" class="border p-4 shadow">
      <div class="form-group">
        <label for="form_name">Form Name</label>
        <input type="text" name="form_name" id="form_name" class="form-control" value="<?php echo htmlspecialchars($form['form_name']); ?>" required>
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control" rows="5" required><?php echo htmlspecialchars($form['description']); ?></textarea>
      </div>

      <div class="form-group">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control" required>
          <option value="active" <?php echo ($form['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
          <option value="inactive" <?php echo ($form['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Save Changes</button>
      <a href="view_forms.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
