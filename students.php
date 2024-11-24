<?php
// Include database connection
include('includes/connect.php');

// Fetch form fields for the dynamic table headers
$form_id = 1; // Specify the form_id for which responses are being fetched, or use a dynamic value

// Query to get all fields for the specific form
$field_query = "SELECT field_id, field_label FROM form_fields WHERE form_id = ?";
$stmt = $conn->prepare($field_query);
$stmt->bind_param("i", $form_id);
$stmt->execute();
$fields_result = $stmt->get_result();

// Query to get responses for this form
$response_query = "SELECT field_id, response FROM form_responses WHERE form_id = ? ORDER BY response_id";
$stmt = $conn->prepare($response_query);
$stmt->bind_param("i", $form_id);
$stmt->execute();
$responses_result = $stmt->get_result();

// Create an array to store responses for each field
$responses_data = [];
while ($row = $responses_result->fetch_assoc()) {
    $responses_data[$row['field_id']][] = $row['response'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Responses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Student Responses</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <!-- Dynamic table headers based on form fields -->
                    <?php
                    while ($field = $fields_result->fetch_assoc()) {
                        echo "<th>" . htmlspecialchars($field['field_label']) . "</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
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
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
