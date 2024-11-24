<?php
// Include database connection
include('../includes/connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_id = $_POST['form_id']; // The form ID being submitted

    // Loop through the submitted form fields
    foreach ($_POST as $key => $value) {
        if ($key != 'form_id') {
            $field_id = str_replace('field_', '', $key); // Get the field ID

            // Check if the field is a checkbox or radio (can have multiple values)
            if (is_array($value)) {
                $response = implode(",", $value); // Combine multiple values (for checkboxes/radios)
            } else {
                $response = $value; // For other fields (text, textarea, etc.)
            }

            // Insert the student's response into the database, excluding the created_at column (auto-handled by the DB)
            $query = "INSERT INTO form_responses (form_id, field_id, response) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iis", $form_id, $field_id, $response);
            $stmt->execute();
        }
    }

    // After submission, show a success message or redirect
    echo "Your form has been submitted successfully!";
    // Optionally, redirect to another page
    // header("Location: thank_you.php");
}
?>
