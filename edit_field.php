<?php
include('includes/connect.php');

// Get the field_id from the URL
$field_id = isset($_GET['field_id']) ? intval($_GET['field_id']) : 0;

// Fetch the field data
$sql = "SELECT `field_id`, `form_id`, `field_label`, `field_type`, `is_required`, `options` FROM `form_fields` WHERE `field_id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $field_id);
$stmt->execute();
$result = $stmt->get_result();
$field = $result->fetch_assoc();

if (!$field) {
    die("Field not found");
}

// Update the field
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $field_label = $_POST['field_label'];
    $field_type = $_POST['field_type'];
    $is_required = isset($_POST['is_required']) ? 1 : 0;
    $options = $_POST['options'];

    $sql = "UPDATE `form_fields` SET `field_label` = ?, `field_type` = ?, `is_required` = ?, `options` = ? WHERE `field_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $field_label, $field_type, $is_required, $options, $field_id);
    $stmt->execute();

    // Redirect back to the form view page
    header("Location: view_form.php?form_id={$field['form_id']}&success=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Field</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('includes/nav.php') ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Field</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label class="form-label">Field Label</label>
            <input type="text" class="form-control" name="field_label" value="<?php echo htmlspecialchars($field['field_label']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Field Type</label>
            <select class="form-control" name="field_type" required>
                <option value="text" <?php echo $field['field_type'] === 'text' ? 'selected' : ''; ?>>Text</option>
                <option value="textarea" <?php echo $field['field_type'] === 'textarea' ? 'selected' : ''; ?>>Textarea</option>
                <option value="select" <?php echo $field['field_type'] === 'select' ? 'selected' : ''; ?>>Select</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Options (Comma Separated, only for 'Select' type)</label>
            <input type="text" class="form-control" name="options" value="<?php echo htmlspecialchars($field['options']); ?>" placeholder="Option1,Option2,Option3">
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" name="is_required" id="is_required" <?php echo $field['is_required'] ? 'checked' : ''; ?>>
            <label class="form-check-label" for="is_required">Is Required</label>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="view_form.php?form_id=<?php echo $field['form_id']; ?>" class="btn btn-secondary">Back</a>
    </form>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
