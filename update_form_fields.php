<?php
include('includes/connect.php');

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_id = intval($_POST['form_id']);
    $fields = $_POST['fields'];

    foreach ($fields as $field_id => $field_value) {
        $sql = "UPDATE `form_fields` SET `options` = ? WHERE `field_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $field_value, $field_id);
        $stmt->execute();
    }

    // Redirect back to the form view page
    header("Location: view_form.php?form_id=$form_id&success=1");
    exit;
} else {
    // Invalid request
    header("Location: forms.php");
    exit;
}
?>
