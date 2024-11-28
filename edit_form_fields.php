<?php
include('includes/connect.php');

// Check if the form_id is provided
if (isset($_GET['form_id'])) {
    $form_id = intval($_GET['form_id']);

    // Fetch the fields for the given form
    $sql = "SELECT `field_id`, `field_label`, `field_type`, `is_required`, `options` FROM `form_fields` WHERE `form_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $form_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the form is submitted, update the fields
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($_POST['fields'] as $field_id => $field_data) {
            $field_label = $field_data['field_label'];
            $field_type = $field_data['field_type'];
            $is_required = isset($field_data['is_required']) ? 1 : 0;
            $options = $field_data['options'];

            $update_sql = "UPDATE `form_fields` SET `field_label` = ?, `field_type` = ?, `is_required` = ?, `options` = ? WHERE `field_id` = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ssiss", $field_label, $field_type, $is_required, $options, $field_id);

            if (!$update_stmt->execute()) {
                echo "<div class='alert alert-danger'>Error updating field ID $field_id: " . $conn->error . "</div>";
            }
        }

        echo "<div class='alert alert-success'>Fields updated successfully!</div>";
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
  <title>Edit Form Fields</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Edit Fields for Form ID: <?php echo $form_id; ?></h1>

    <?php if ($result->num_rows > 0): ?>
      <form method="POST" class="border p-4 shadow">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Field Label</th>
              <th>Field Type</th>
              <th>Required</th>
              <th>Options (comma-separated)</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td>
                  <input type="text" name="fields[<?php echo $row['field_id']; ?>][field_label]" 
                         value="<?php echo htmlspecialchars($row['field_label']); ?>" 
                         class="form-control" required>
                </td>
                <td>
                  <select name="fields[<?php echo $row['field_id']; ?>][field_type]" class="form-control" required>
                    <option value="text" <?php echo ($row['field_type'] === 'text') ? 'selected' : ''; ?>>Text</option>
                    <option value="textarea" <?php echo ($row['field_type'] === 'textarea') ? 'selected' : ''; ?>>Textarea</option>
                    <option value="select" <?php echo ($row['field_type'] === 'select') ? 'selected' : ''; ?>>Dropdown</option>
                    <option value="checkbox" <?php echo ($row['field_type'] === 'checkbox') ? 'selected' : ''; ?>>Checkbox</option>
                    <option value="radio" <?php echo ($row['field_type'] === 'radio') ? 'selected' : ''; ?>>Radio</option>
                  </select>
                </td>
                <td>
                  <input type="checkbox" name="fields[<?php echo $row['field_id']; ?>][is_required]" 
                         <?php echo ($row['is_required'] == 1) ? 'checked' : ''; ?>>
                </td>
                <td>
                  <input type="text" name="fields[<?php echo $row['field_id']; ?>][options]" 
                         value="<?php echo htmlspecialchars($row['options']); ?>" 
                         class="form-control">
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="forms.php" class="btn btn-secondary">Cancel</a>
      </form>
    <?php else: ?>
      <div class="alert alert-warning text-center">No fields found for this form.</div>
    <?php endif; ?>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
