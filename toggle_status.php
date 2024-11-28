<?php
include('includes/connect.php');

if (isset($_GET['form_id']) && isset($_GET['action'])) {
    $form_id = intval($_GET['form_id']);
    $action = $_GET['action'];

    // Determine the new status based on the action
    $new_status = ($action === 'activate') ? 'active' : 'inactive';

    $sql = "UPDATE `forms` SET `status` = ? WHERE `form_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_status, $form_id);

    if ($stmt->execute()) {
        // Redirect back to the forms page with a success message
        header("Location: forms.php?status_updated=1");
        exit();
    } else {
        echo "Error updating status: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
