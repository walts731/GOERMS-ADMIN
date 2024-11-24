<?php
include('includes/connect.php');

// Check if form data is sent via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_name']) && isset($_POST['description'])) {
    // Get form details
    $form_name = $_POST['form_name'];
    $description = $_POST['description'];
    $created_by = 1; // Replace with admin user ID from session

    // Insert form into the `forms` table
    $sql = "INSERT INTO forms (form_name, description, created_by) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $form_name, $description, $created_by);

    try {
        $stmt->execute();
        $form_id = $stmt->insert_id;

        // Handle form fields
        if (isset($_POST['field_label'])) {
            $field_labels = $_POST['field_label'];
            $field_types = $_POST['field_type'];
            $is_required = $_POST['is_required'] ?? [];
            $options = $_POST['options'];

            $sql = "INSERT INTO form_fields (form_id, field_label, field_type, is_required, options) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            foreach ($field_labels as $index => $label) {
                $type = $field_types[$index];
                $required = isset($is_required[$index]) ? 1 : 0;
                $option = $options[$index] ?? '';
                $stmt->bind_param("issis", $form_id, $label, $type, $required, $option);
                $stmt->execute();
            }
        }

        $stmt->close();
        $conn->close();

        // Redirect to the dashboard
        header("Location: index.php?message=FormCreatedSuccessfully");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No data submitted.";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Form</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include('includes/nav.php'); ?>
    
    <div class="hero text-center py-4 bg-primary text-white">
        <img class="university-logo mb-3" src="img/LOGO 1.png" alt="University Logo" style="max-width: 100px;">
        <h1>ADMIN ACCESS</h1>
    </div>
    
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h2>Create New Form</h2>
            </div>
            <div class="card-body">
                <form action="create_form.php" method="POST">
                    <!-- Form Name -->
                    <div class="form-group">
                        <label for="form_name">Form Name:</label>
                        <input type="text" id="form_name" name="form_name" class="form-control" placeholder="Enter form name" required>
                    </div>

                    <!-- Form Description -->
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" class="form-control" rows="3" placeholder="Enter form description" required></textarea>
                    </div>

                    <!-- Form Fields -->
                    <div id="form-fields">
                        <h5 class="mt-4">Form Fields</h5>
                        <div class="field-group border p-3 rounded mb-3">
                            <div class="form-group">
                                <label for="field_label[]">Field Label:</label>
                                <input type="text" name="field_label[]" class="form-control" placeholder="Enter field label" required>
                            </div>
                            <div class="form-group">
                                <label for="field_type[]">Field Type:</label>
                                <select name="field_type[]" class="form-control" required>
                                    <option value="text">Text</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="number">Number</option>
                                    <option value="radio">Radio</option>
                                    <option value="checkbox">Checkbox</option>
                                    <option value="dropdown">Dropdown</option>
                                    <option value="date">Date</option>
                                </select>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" name="is_required[]" value="1" class="form-check-input" id="required-checkbox">
                                <label for="required-checkbox" class="form-check-label">Required</label>
                            </div>
                            <div class="form-group">
                                <label for="options[]">Options (Comma-separated):</label>
                                <input type="text" name="options[]" class="form-control" placeholder="Option1,Option2 (for dropdown or radio)">
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="button" class="btn btn-success mb-3" onclick="addField()">Add Field</button>
                        <button type="submit" class="btn btn-primary">Save Form</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addField() {
            const fieldGroup = document.querySelector('.field-group').cloneNode(true);
            document.getElementById('form-fields').appendChild(fieldGroup);
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
