<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['subject_name'];
    $conn->query("INSERT INTO subjects (subject_name) VALUES ('$name')");
    header("Location: add_subject.php");
}
?>

<!DOCTYPE html>
<html>
<head><title>Add Subject</title></head>
<body>
<h2>Add Subject</h2>

<form method="post">
    Subject Name: <input type="text" name="subject_name" required>
    <button type="submit">Add</button>
</form>

<h3>Existing Subjects</h3>
<ul>
<?php
$result = $conn->query("SELECT * FROM subjects");
while ($row = $result->fetch_assoc()) {
    echo "<li>{$row['subject_name']}</li>";
}
?>
</ul>
</body>
</html>
