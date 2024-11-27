<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fill Up Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include('includes/stud_nav.php') ?>

    <?php 
    include('../includes/connect.php'); 

    if(isset($_GET['form_id'])){
        $form_id = $_GET['form_id'];
        $sql = "SELECT * FROM `forms` WHERE `form_id` = '$form_id'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            
            echo "<div class='container mt-5'>";
            echo "<h2 class='mb-4'>" . $row['form_name'] . "</h2>";
            echo "<form method='post' action='submit_form.php'>";
            echo "<input type='hidden' name='form_id' value='" . $row['form_id'] . "'>";
            
            // Fetch form fields
            $field_sql = "SELECT `field_id`, `form_id`, `field_label`, `field_type`, `is_required`, `options` FROM `form_fields` WHERE `form_id` = '$form_id'";
            $field_result = mysqli_query($conn, $field_sql);
            
            if(mysqli_num_rows($field_result) > 0){
                while($field_row = mysqli_fetch_assoc($field_result)){
                    echo "<div class='form-group'>";
                    echo "<label for='" . $field_row['field_label'] . "'>" . $field_row['field_label'] . "</label>";
                    
                    // Dynamically create input fields based on field type
                    switch($field_row['field_type']){
                        case 'text':
                            echo "<input type='text' class='form-control' id='" . $field_row['field_label'] . "' name='" . $field_row['field_label'] . "' ";
                            if($field_row['is_required'] == 1){
                                echo "required";
                            }
                            echo ">";
                            break;
                        case 'textarea':
                            echo "<textarea class='form-control' id='" . $field_row['field_label'] . "' name='" . $field_row['field_label'] . "' ";
                            if($field_row['is_required'] == 1){
                                echo "required";
                            }
                            echo "></textarea>";
                            break;
                        case 'select':
                            echo "<select class='form-control' id='" . $field_row['field_label'] . "' name='" . $field_row['field_label'] . "' ";
                            if($field_row['is_required'] == 1){
                                echo "required";
                            }
                            echo ">";
                            // Parse options from the 'options' column (assuming it's a JSON string)
                            $optionsArray = json_decode($field_row['options'], true);
                            if(is_array($optionsArray)){
                                foreach($optionsArray as $option){
                                    echo "<option value='" . $option . "'>" . $option . "</option>";
                                }
                            }
                            echo "</select>";
                            break;
                        case 'radio':
                            // Parse options from the 'options' column (assuming it's a JSON string)
                            $optionsArray = json_decode($field_row['options'], true);
                            if(is_array($optionsArray)){
                                foreach($optionsArray as $option){
                                    echo "<div class='form-check'>";
                                    echo "<input class='form-check-input' type='radio' name='" . $field_row['field_label'] . "' id='" . $field_row['field_label'] . "_" . $option . "' value='" . $option . "' ";
                                    if($field_row['is_required'] == 1){
                                        echo "required";
                                    }
                                    echo ">";
                                    echo "<label class='form-check-label' for='" . $field_row['field_label'] . "_" . $option . "'>" . $option . "</label>";
                                    echo "</div>";
                                }
                            }
                            break;
                        case 'checkbox':
                            // Parse options from the 'options' column (assuming it's a JSON string)
                            $optionsArray = json_decode($field_row['options'], true);
                            if(is_array($optionsArray)){
                                foreach($optionsArray as $option){
                                    echo "<div class='form-check'>";
                                    echo "<input class='form-check-input' type='checkbox' name='" . $field_row['field_label'] . "[]' id='" . $field_row['field_label'] . "_" . $option . "' value='" . $option . "' ";
                                    if($field_row['is_required'] == 1){
                                        echo "required";
                                    }
                                    echo ">";
                                    echo "<label class='form-check-label' for='" . $field_row['field_label'] . "_" . $option . "'>" . $option . "</label>";
                                    echo "</div>";
                                }
                            }
                            break;
                        case 'number':
                            echo "<input type='number' class='form-control' id='" . $field_row['field_label'] . "' name='" . $field_row['field_label'] . "' ";
                            if($field_row['is_required'] == 1){
                                echo "required";
                            }
                            echo ">";
                            break;
                        case 'date':
                            echo "<input type='date' class='form-control' id='" . $field_row['field_label'] . "' name='" . $field_row['field_label'] . "' ";
                            if($field_row['is_required'] == 1){
                                echo "required";
                            }
                            echo ">";
                            break;
                        case 'dropdown': // Assuming 'dropdown' is your alias for 'select'
                            echo "<select class='form-control' id='" . $field_row['field_label'] . "' name='" . $field_row['field_label'] . "' ";
                            if($field_row['is_required'] == 1){
                                echo "required";
                            }
                            echo ">";
                            // Parse options from the 'options' column (assuming it's a JSON string)
                            $optionsArray = json_decode($field_row['options'], true);
                            if(is_array($optionsArray)){
                                foreach($optionsArray as $option){
                                    echo "<option value='" . $option . "'>" . $option . "</option>";
                                }
                            }
                            echo "</select>";
                            break;
                        // Add more field types as needed (e.g., checkbox, radio)
                    }
                    echo "</div>";
                }
            }
            echo "<button type='submit' class='btn btn-primary'>Submit</button>";
            echo "</form>";
            echo "</div>";
        } else {
            echo "Form not found.";
        }
    }
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>