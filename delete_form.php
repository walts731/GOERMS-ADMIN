<?php
include('includes/connect.php');

if (isset($_GET['form_id'])) {
    $form_id = intval($_GET['form_id']);
    
    $sql = "DELETE FROM `forms` WHERE `form_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $form_id);

    if ($stmt->execute()) {
        echo "Form deleted successfully.";
    } else {
        echo "Error deleting form: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid form ID.";
}

$conn->close();
?>
