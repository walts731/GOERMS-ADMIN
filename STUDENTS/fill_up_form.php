<?php
include('../includes/connect.php');

// Get the form_id from URL, sanitize it to avoid SQL injection
$form_id = isset($_GET['form_id']) ? intval($_GET['form_id']) : 0;

if ($form_id) {
    // Retrieve the form details using the form_id
    $sql = "SELECT * FROM `forms` WHERE `form_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $form_id); // Use parameterized query to prevent SQL injection
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $form = $result->fetch_assoc();
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Fill Up Form - " . htmlspecialchars($form['form_name']) . "</title>
            <!-- Bootstrap CSS -->
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
        </head>
        <body>

        <div class='container mt-5'>
            <h1 class='mb-4'>" . htmlspecialchars($form['form_name']) . "</h1>
            <form action='submit_form.php' method='post'>
                <input type='hidden' name='form_id' value='" . $form['form_id'] . "'>";

        // Retrieve all form fields for this form
        $field_sql = "SELECT `field_id`, `field_label`, `field_type`, `is_required`, `options` 
                      FROM `form_fields` 
                      WHERE `form_id` = ?";
        $field_stmt = $conn->prepare($field_sql);
        $field_stmt->bind_param("i", $form_id); // Use parameterized query for security
        $field_stmt->execute();
        $field_result = $field_stmt->get_result();

        // Loop through all form fields and display them
        while ($field = $field_result->fetch_assoc()) {
            $field_id = $field['field_id'];
            $field_label = htmlspecialchars($field['field_label']);
            $field_type = $field['field_type'];
            $is_required = $field['is_required'] ? 'required' : '';
            $options = $field['options'];

            echo "<div class='mb-3'>";
            echo "<label for='field_$field_id' class='form-label'>$field_label</label>";

            // Render the field based on type
            if ($field_type == 'text') {
                echo "<input type='text' class='form-control' id='field_$field_id' name='field_$field_id' $is_required>";
            } elseif ($field_type == 'textarea') {
                echo "<textarea class='form-control' id='field_$field_id' name='field_$field_id' $is_required></textarea>";
            } elseif ($field_type == 'select') {
                echo "<select class='form-select' id='field_$field_id' name='field_$field_id' $is_required>";
                if ($options) {
                    $options_array = explode(',', $options); // Assume options are comma-separated
                    foreach ($options_array as $option) {
                        echo "<option value='" . htmlspecialchars($option) . "'>" . htmlspecialchars($option) . "</option>";
                    }
                } else {
                    echo "<option value=''>No options available</option>";
                }
                echo "</select>";
            } elseif ($field_type == 'radio') {
                if ($options) {
                    $options_array = explode(',', $options); // Assume options are comma-separated
                    foreach ($options_array as $option) {
                        echo "<div class='form-check'>
                                <input class='form-check-input' type='radio' name='field_$field_id' value='" . htmlspecialchars($option) . "' id='field_$field_id" . htmlspecialchars($option) . "' $is_required>
                                <label class='form-check-label' for='field_$field_id" . htmlspecialchars($option) . "'>" . htmlspecialchars($option) . "</label>
                              </div>";
                    }
                } else {
                    echo "<div class='alert alert-warning'>No radio options available</div>";
                }
            } elseif ($field_type == 'checkbox') {
                if ($options) {
                    $options_array = explode(',', $options); // Assume options are comma-separated
                    foreach ($options_array as $option) {
                        echo "<div class='form-check'>
                                <input class='form-check-input' type='checkbox' name='field_<?php echo $field_id; ?>[]' value='<?php echo htmlspecialchars($option); ?>' id='field_<?php echo $field_id . htmlspecialchars($option); ?>'>

                                <label class='form-check-label' for='field_$field_id" . htmlspecialchars($option) . "'>" . htmlspecialchars($option) . "</label>
                              </div>";
                    }
                } else {
                    echo "<div class='alert alert-warning'>No checkbox options available</div>";
                }
            }
            echo "</div>";
        }

        // Submit button
        echo "<button type='submit' class='btn btn-success'>Submit</button>";
        echo "</form></div>";

    } else {
        echo "<div class='alert alert-danger'>Form not found.</div>";
    }

    $stmt->close();
} else {
    echo "<div class='alert alert-warning'>No form selected.</div>";
}

$conn->close();
?>

<!-- Bootstrap JS (optional for some interactive elements) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
