<?php
// Include the database connection
include("../database/db_connect.php");

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $address = $_POST['address'];
    $work_experience = implode(', ', $_POST['work_experience']); // Convert array to string
    $skill_rating = $_POST['skill_rating'];
    $experience = $_POST['experience'];
    
    // Handle file upload (resume)
    $resume = $_FILES['resume']['name'];
    $resume_tmp = $_FILES['resume']['tmp_name'];
    $resume_folder = "../uploads/" . $resume; // Save the file in the 'uploads' folder
    move_uploaded_file($resume_tmp, $resume_folder);

    // Prepare SQL query
    $query = "INSERT INTO mechanics(fullname, dob, phone, email, password, address, work_experience, skill_rating, experience, resume) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and execute the query
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("ssssssssss", $fullname, $dob, $phone, $email, $password, $address, $work_experience, $skill_rating, $experience, $resume);
        if ($stmt->execute()) {
            echo "<script>alert('application has been submitted successfully!'); </script>";
            header("Location:create_mechanics.php");
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $mysqli->error;
    }
}
?>
