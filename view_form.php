<?php
include('includes/connect.php');

// Get the form_id from the URL
$form_id = isset($_GET['form_id']) ? intval($_GET['form_id']) : 0;

// Query to fetch form fields
$sql = "SELECT `field_id`, `form_id`, `field_label`, `field_type`, `is_required`, `options` FROM `form_fields` WHERE `form_id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $form_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editable Form Fields</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('includes/nav.php') ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit Form Fields for Form ID: <?php echo htmlspecialchars($form_id); ?></h2>
        <form action="update_form_fields.php" method="POST">
            <input type="hidden" name="form_id" value="<?php echo htmlspecialchars($form_id); ?>">
            <div class="row g-3">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label"><?php echo htmlspecialchars($row['field_label']); ?></label>
                                <?php if ($row['field_type'] == 'text'): ?>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        name="fields[<?php echo $row['field_id']; ?>]" 
                                        value="<?php echo htmlspecialchars($row['options']); ?>" 
                                        <?php echo $row['is_required'] ? 'required' : ''; ?>>
                                <?php elseif ($row['field_type'] == 'textarea'): ?>
                                    <textarea 
                                        class="form-control" 
                                        name="fields[<?php echo $row['field_id']; ?>]" 
                                        <?php echo $row['is_required'] ? 'required' : ''; ?>><?php echo htmlspecialchars($row['options']); ?></textarea>
                                <?php elseif ($row['field_type'] == 'select'): ?>
                                    <select 
                                        class="form-control" 
                                        name="fields[<?php echo $row['field_id']; ?>]" 
                                        <?php echo $row['is_required'] ? 'required' : ''; ?>>
                                        <?php
                                        $options = explode(',', $row['options']);
                                        foreach ($options as $option):
                                        ?>
                                            <option value="<?php echo htmlspecialchars($option); ?>">
                                                <?php echo htmlspecialchars($option); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="edit_field.php?field_id=<?php echo $row['field_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_field.php?field_id=<?php echo $row['field_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this field?')">Delete</a>
                            </div>
                            <hr>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-center">No fields found for this form</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="forms.php" class="btn btn-secondary">Back to Forms</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>
