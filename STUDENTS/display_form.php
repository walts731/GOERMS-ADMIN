<?php
// Include database connection
include('../includes/connect.php');

// Fetch the form details from the database (replace 'form_id' with the actual form ID you want to display)
$form_id = 1; // You can dynamically pass this ID via URL parameter (e.g., display_form.php?id=1)
$query = "SELECT * FROM forms WHERE form_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $form_id);
$stmt->execute();
$result = $stmt->get_result();
$form = $result->fetch_assoc();

// Fetch the fields for this form
$field_query = "SELECT * FROM form_fields WHERE form_id = ?";
$field_stmt = $conn->prepare($field_query);
$field_stmt->bind_param("i", $form_id);
$field_stmt->execute();
$field_result = $field_stmt->get_result();

// Check if the form exists
if ($form) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $form['form_name']; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1><?php echo $form['form_name']; ?></h1>
    <p><?php echo nl2br($form['description']); ?></p>

    <form action="submit_form.php" method="POST">
        <!-- Hidden field to store form ID -->
        <input type="hidden" name="form_id" value="<?php echo $form['form_id']; ?>">

        <?php while ($field = $field_result->fetch_assoc()) { ?>
            <div class="form-group">
                <label for="field_<?php echo $field['field_id']; ?>"><?php echo $field['field_label']; ?>:</label>

                <?php if ($field['field_type'] == 'text') { ?>
                    <input type="text" name="field_<?php echo $field['field_id']; ?>" id="field_<?php echo $field['field_id']; ?>" class="form-control" required>
                
                <?php } elseif ($field['field_type'] == 'textarea') { ?>
                    <textarea name="field_<?php echo $field['field_id']; ?>" id="field_<?php echo $field['field_id']; ?>" class="form-control" required></textarea>
                
                <?php } elseif ($field['field_type'] == 'number') { ?>
                    <input type="number" name="field_<?php echo $field['field_id']; ?>" id="field_<?php echo $field['field_id']; ?>" class="form-control" required>
                
                <?php } elseif ($field['field_type'] == 'radio' || $field['field_type'] == 'checkbox' || $field['field_type'] == 'dropdown') { 
                    $options = explode(",", $field['options']);
                    foreach ($options as $option) {
                ?>
                    <div class="form-check">
                        <input type="<?php echo ($field['field_type'] == 'radio') ? 'radio' : 'checkbox'; ?>" name="field_<?php echo $field['field_id']; ?>[]" id="field_<?php echo $field['field_id']; ?>_<?php echo trim($option); ?>" value="<?php echo trim($option); ?>" class="form-check-input">
                        <label class="form-check-label" for="field_<?php echo $field['field_id']; ?>_<?php echo trim($option); ?>"><?php echo trim($option); ?></label>
                    </div>
                <?php } } ?>

            </div>
        <?php } ?>

        <button type="submit" class="btn btn-primary">Submit Form</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
} else {
    echo "<p>Form not found!</p>";
}
?>
