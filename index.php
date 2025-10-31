<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Student and Subject CRUD</title>
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 8px; }
    </style>
</head>
<body>
        <?php
            session_start();
            if(isset($_SESSION['success'])){
        ?>
            <div class=" row session"> 
                <?php 
                    echo $_SESSION['success']; 
                ?>
            </div>
        <?php  }
                session_destroy();
        ?>
<h2>Students and Their Subjects</h2>

<a href="add_student.php">➕ Add Student</a>
<br><br>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Subjects</th>
        <th>Action</th>
    </tr>

    <?php
    // $sql = "
    //     SELECT s.id, s.name, s.email, GROUP_CONCAT(sub.subject_name SEPARATOR ', ') AS subjects
    //     FROM students s
    //     LEFT JOIN student_subjects ss ON s.id = ss.student_id
    //     LEFT JOIN subjects sub ON .subject_id = sub.id
    //     GROUP BY s.id
    // ";
     $sql = "
        SELECT s.id, s.name, s.email, GROUP_CONCAT(sub.subject_name SEPARATOR ', ') AS subjects
        FROM students s
        LEFT JOIN student_subjects ss ON s.id = ss.student_id
        LEFT JOIN subjects sub ON ss.subject_id = sub.id
        GROUP BY s.id
    ";
    $result = $conn->query($sql);
    // echo "fghjkl0";
    // print_r($result);die();
    // while ($row = $result->fetch_assoc()): 
        foreach($result as $key => $row):
        // print_r($result->fetch_assoc());die();
    ?>
        <tr>
            <td><?= $key + 1 ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['subjects']) ?></td>
            <td>
                <a href="edit_student.php?id=<?= $row['id'] ?>">✏️ Edit</a> |
                <a href="delete_student.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this student?');">🗑️ Delete</a>
            </td>
        </tr>
        <!-- dump($result->fetch_assoc()); -->
    <?php endforeach; ?>
</table>

</body>
</html>
