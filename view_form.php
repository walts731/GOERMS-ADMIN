<?php
include('includes/connect.php');

if (isset($_GET['form_id'])) {
    $form_id = intval($_GET['form_id']);

    // Fetch the form details
    $form_sql = "SELECT * FROM `forms` WHERE `form_id` = ?";
    $form_stmt = $conn->prepare($form_sql);
    $form_stmt->bind_param("i", $form_id);
    $form_stmt->execute();
    $form_result = $form_stmt->get_result();
    $form = $form_result->fetch_assoc();

    // Fetch the form fields
    $fields_sql = "SELECT * FROM `form_fields` WHERE `form_id` = ?";
    $fields_stmt = $conn->prepare($fields_sql);
    $fields_stmt->bind_param("i", $form_id);
    $fields_stmt->execute();
    $fields_result = $fields_stmt->get_result();
} else {
    echo "Invalid form ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Form Details</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .form-container {
      max-width: 800px;
      margin: auto;
    }
    .field-container {
      margin-bottom: 20px;
    }
    .field-label {
      font-weight: bold;
      margin-bottom: 5px;
    }
  </style>
</head>
<body>
  <div class="container mt-5 form-container">
    <?php if ($form): ?>
      <h1 class="text-center mb-4"><?php echo htmlspecialchars($form['form_name']); ?></h1>
      <p class="text-muted text-center"><?php echo htmlspecialchars($form['description']); ?></p>

      <form>
        <?php if ($fields_result->num_rows > 0): ?>
          <?php while ($field = $fields_result->fetch_assoc()): ?>
            <div class="field-container">
              <label class="field-label"><?php echo htmlspecialchars($field['field_label']); ?> <?php echo $field['is_required'] ? '<span class="text-danger">*</span>' : ''; ?></label>

              <?php if ($field['field_type'] === 'text'): ?>
                <input type="text" class="form-control" placeholder="Enter <?php echo htmlspecialchars($field['field_label']); ?>" <?php echo $field['is_required'] ? 'required' : ''; ?>>

              <?php elseif ($field['field_type'] === 'textarea'): ?>
                <textarea class="form-control" rows="3" placeholder="Enter <?php echo htmlspecialchars($field['field_label']); ?>" <?php echo $field['is_required'] ? 'required' : ''; ?>></textarea>

              <?php elseif ($field['field_type'] === 'radio'): ?>
                <?php $options = explode(',', $field['options']); ?>
                <?php foreach ($options as $option): ?>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="field_<?php echo $field['field_id']; ?>" value="<?php echo htmlspecialchars(trim($option)); ?>" <?php echo $field['is_required'] ? 'required' : ''; ?>>
                    <label class="form-check-label"><?php echo htmlspecialchars(trim($option)); ?></label>
                  </div>
                <?php endforeach; ?>

              <?php elseif ($field['field_type'] === 'checkbox'): ?>
                <?php $options = explode(',', $field['options']); ?>
                <?php foreach ($options as $option): ?>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="field_<?php echo $field['field_id']; ?>[]" value="<?php echo htmlspecialchars(trim($option)); ?>">
                    <label class="form-check-label"><?php echo htmlspecialchars(trim($option)); ?></label>
                  </div>
                <?php endforeach; ?>

              <?php elseif ($field['field_type'] === 'select'): ?>
                <select class="form-control" <?php echo $field['is_required'] ? 'required' : ''; ?>>
                  <option value="">Select <?php echo htmlspecialchars($field['field_label']); ?></option>
                  <?php $options = explode(',', $field['options']); ?>
                  <?php foreach ($options as $option): ?>
                    <option value="<?php echo htmlspecialchars(trim($option)); ?>"><?php echo htmlspecialchars(trim($option)); ?></option>
                  <?php endforeach; ?>
                </select>
              <?php endif; ?>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="alert alert-warning text-center">No fields found for this form.</div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    <?php else: ?>
      <div class="alert alert-danger text-center">Form not found.</div>
    <?php endif; ?>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the database connections
$form_stmt->close();
$fields_stmt->close();
$conn->close();
?>
