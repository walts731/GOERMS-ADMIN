<?php
include('../includes/connect.php');


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve all forms from the database
$sql = "SELECT `form_id`, `form_name`, `description`, `created_by`, `created_at` FROM `forms`";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forms List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Available Forms</h1>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Form Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['form_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td>
                            <!-- Fill Up Button: Redirect to form page with form_id -->
                            <form action="fill_up_form.php" method="get">
                                <input type="hidden" name="form_id" value="<?php echo $row['form_id']; ?>">
                                <button type="submit" class="btn btn-primary">Fill Up</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">No forms available.</div>
    <?php endif; ?>

</div>

<!-- Bootstrap JS (optional for some interactive elements) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>