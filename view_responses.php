<?php
// Include the database connection file
include('includes/connect.php');

// Check if the student_id is passed
if (isset($_GET['student_id'])) {
    $student_id = intval($_GET['student_id']);

    // Query to get all forms the student has responded to (distinct form IDs)
    $form_query = "SELECT DISTINCT fr.form_id, f.form_name
                   FROM form_responses fr
                   JOIN forms f ON fr.form_id = f.form_id
                   WHERE fr.student_id = ?";
    $stmt = $conn->prepare($form_query);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $forms_result = $stmt->get_result();

    // Fetch student details for header
    $student_query = "SELECT username, first_name, last_name, email, date_of_birth, created_at 
                      FROM student_user WHERE student_id = ?";
    $student_stmt = $conn->prepare($student_query);
    $student_stmt->bind_param("i", $student_id);
    $student_stmt->execute();
    $student_result = $student_stmt->get_result();
    $student = $student_result->fetch_assoc();

    if ($student) {
        echo "<div class='container mt-5'>";
        echo "<h1 class='text-center mb-4'>Student Responses for: " . htmlspecialchars($student['first_name']) . " " . htmlspecialchars($student['last_name']) . "</h1>";
        echo "<p><strong>Username:</strong> " . htmlspecialchars($student['username']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($student['email']) . "</p>";
        echo "<p><strong>Date of Birth:</strong> " . htmlspecialchars($student['date_of_birth']) . "</p>";
        echo "<p><strong>Account Created:</strong> " . htmlspecialchars($student['created_at']) . "</p>";
    } else {
        echo "<div class='alert alert-danger'>Student not found.</div>";
    }

    // Loop through each form the student has responded to
    while ($form = $forms_result->fetch_assoc()) {
        $form_id = $form['form_id'];
        $form_name = $form['form_name'];

        // Query to get all fields for the specific form
        $field_query = "SELECT field_id, field_label FROM form_fields WHERE form_id = ?";
        $field_stmt = $conn->prepare($field_query);
        $field_stmt->bind_param("i", $form_id);
        $field_stmt->execute();
        $fields_result = $field_stmt->get_result();

        // Query to get responses for this form by this student
        $response_query = "SELECT field_id, response FROM form_responses WHERE form_id = ? AND student_id = ? ORDER BY response_id";
        $response_stmt = $conn->prepare($response_query);
        $response_stmt->bind_param("ii", $form_id, $student_id);
        $response_stmt->execute();
        $responses_result = $response_stmt->get_result();

        // Create an array to store responses for each field
        $responses_data = [];
        while ($row = $responses_result->fetch_assoc()) {
            $responses_data[$row['field_id']][] = $row['response'];
        }

        // Generate a unique ID for each form to handle the collapsible component
        $collapse_id = "collapseForm" . $form_id;

        // Display the form and its responses in a collapsible format
        echo "<div class='card mb-4'>";
        echo "<div class='card-header bg-primary text-white'>";
        // Button to toggle the form's responses
        echo "<button class='btn btn-link text-white' type='button' data-toggle='collapse' data-target='#$collapse_id' aria-expanded='false' aria-controls='$collapse_id'>";
        echo "<h5>" . htmlspecialchars($form_name) . "</h5>";
        echo "</button>";
        echo "</div>";

        // Collapsible body to hold the responses table
        echo "<div id='$collapse_id' class='collapse' aria-labelledby='headingOne' data-parent='.container'>";
        echo "<div class='card-body'>";

        // Table to display the responses
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead class='thead-dark'><tr>";

        // Dynamic table headers based on form fields
        while ($field = $fields_result->fetch_assoc()) {
            echo "<th>" . htmlspecialchars($field['field_label']) . "</th>";
        }
        echo "</tr></thead><tbody>";

        // Get the maximum number of responses for a single field (to set the number of rows)
        $max_responses = max(array_map('count', $responses_data));

        // Loop to display each row (response)
        for ($i = 0; $i < $max_responses; $i++) {
            echo "<tr>";

            // Loop through fields and display responses in rows
            foreach ($responses_data as $field_id => $responses) {
                // If the response exists for this field, display it
                echo "<td>";
                echo isset($responses[$i]) ? htmlspecialchars($responses[$i]) : ""; // Handle no response
                echo "</td>";
            }

            echo "</tr>";
        }

        echo "</tbody></table></div>"; // Close card-body
        echo "</div>"; // Close collapse div
        echo "</div>"; // Close card
    }

    // Close the statements
    $stmt->close();
    $field_stmt->close();
    $response_stmt->close();
} else {
    echo "<div class='alert alert-danger'>Student ID is missing.</div>";
    exit;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Form Responses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Content will be generated by PHP -->
    </div>
    
    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
