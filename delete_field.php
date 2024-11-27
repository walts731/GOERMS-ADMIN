<?php
include('includes/connect.php');

// Get the field_id from the URL
$field_id = isset($_GET['field_id']) ? intval($_GET['field_id']) : 0;

// Fetch the form_id before deletion
$sql = "SELECT `form_id` FROM `form_fields` WHERE `field_id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $field_id);
$stmt->execute();
$result = $stmt->get_result();
$field = $result->fetch_assoc();

if ($field) {
    $form_id = $field['form_id'];

    // Delete the field
    $sql = "DELETE FROM `form_fields` WHERE `field_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $field_id);
    $stmt->execute();

    // Redirect back to the form view page
    header("Location: view_form.php?form_id=$form_id&deleted=1");
    exit;
} else {
    die("Field not found");
}
?>
