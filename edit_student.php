<?php
include 'db.php';
$id = $_GET['id'];

$student = $conn->query("SELECT * FROM students WHERE id=$id")->fetch_assoc();
$subject_result = $conn->query("SELECT * FROM subjects");
$assigned_subjects = [];

$res = $conn->query("SELECT subject_id FROM student_subjects WHERE student_id=$id");
while ($r = $res->fetch_assoc()) {
    $assigned_subjects[] = $r['subject_id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subjects = $_POST['subjects'];
     if (is_null($name) || $name == '') 
        {
        // print_r("name required");die();
        $_SESSION['err_message'] = "Name Required.";
            header("location: edit_student.php");
        }
        elseif(strlen($name) < 2 ||strlen($name) >20 ){
            // print_r("enter valid name");die();
            $_SESSION['err_message'] = "Enter Valid Name.";
            header("location: edit_student.php");

        }
        elseif (!preg_match("/^[a-zA-Z ]*$/", $name)){
            //  print_r("Only letters and white space allowed in name.");die(); 
            $_SESSION['err_message'] = "Only charecters are allowed in name.";
            header("location: edit_student.php");
        }
        else {
        

            $conn->query("UPDATE students SET name='$name', email='$email' WHERE id=$id");
            $conn->query("DELETE FROM student_subjects WHERE student_id=$id");

            foreach ($subjects as $sub_id) {
                $conn->query("INSERT INTO student_subjects (student_id, subject_id) VALUES ($id, $sub_id)");
            }

            header("Location: index.php");
            exit;
        }
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit Student</title></head>
<body>
     <?php
            
            if(isset($_SESSION['err_message'])){
        ?>
         
            <?php echo  $_SESSION['err_message'];?>

        <?php   }
       
        ?>

<h2>Edit Student</h2>
<form method="post">
    Name: <input type="text" name="name" value="<?= $student['name'] ?>" required><br><br>
    Email: <input type="email" name="email" value="<?= $student['email'] ?>"><br><br>

    Subjects:<br>
    <?php while($s = $subject_result->fetch_assoc()): ?>
        <label>
            <input type="checkbox" name="subjects[]" value="<?= $s['id'] ?>" <?= in_array($s['id'], $assigned_subjects) ? 'checked' : '' ?>>
            <?= $s['subject_name'] ?>
        </label><br>
        <!-- <?php var_dump($s); ?> -->
    <?php endwhile; ?>

    <br>
    <button type="submit">Update</button>
</form>

</body>
</html>
