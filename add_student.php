<?php
 session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subjects = $_POST['subjects']; // array

     if (is_null($name) || $name == '') 
        {
        // print_r("name required");die();
        $_SESSION['err_message'] = "Name Required.";
            header("location: add_student.php");
        }
        elseif(strlen($name) < 2 ||strlen($name) >20 ){
            // print_r("enter valid name");die();
            $_SESSION['err_message'] = "Enter Valid Name.";
            header("location: add_student.php");

        }
        elseif (!preg_match("/^[a-zA-Z ]*$/", $name)){
            //  print_r("Only letters and white space allowed in name.");die(); 
            $_SESSION['err_message'] = "Only charecters are allowed in name.";
            header("location: add_student.php");
        }
        else {
        
            
            $conn->query("INSERT INTO students (name, email) VALUES ('$name', '$email')");
            $student_id = $conn->insert_id;
            
            foreach ($subjects as $sub_id) {
                $conn->query("INSERT INTO student_subjects (student_id, subject_id) VALUES ($student_id, $sub_id)");
            }
             $_SESSION['success'] = "Your data submited successfully.";
            header("Location: index.php");
            exit;
        }
}

$subject_result = $conn->query("SELECT * FROM subjects");
?>

<!DOCTYPE html>
<html>
<head><title>Add Student</title></head>
<body>
    <?php
            
            if(isset($_SESSION['err_message'])){
        ?>
         
                <?php echo  $_SESSION['err_message'];?>

        <?php   }
        //  session_destroy();
        ?>
<h2>Add Student</h2>

<form method="post">
    Name: <input type="text" name="name" ><br><br>
    Email: <input type="email" name="email" Required><br><br>

    Subjects:<br>
    <?php while($s = $subject_result->fetch_assoc()): ?>
        <label>
            <input type="checkbox" name="subjects[]" value="<?= $s['id'] ?>"> <?= $s['subject_name'] ?>
        </label><br>
       <!-- <?php var_dump($s);?> -->
    <?php endwhile; ?>

    <br>
    <button type="submit">Save</button>
</form>

</body>
</html>
