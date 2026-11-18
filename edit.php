<?php
include 'auth.php';
include 'db.php';

//fall back to 0 if id is not set (?? is if else operator)
$id = (int)($_GET['id'] ?? 0);

$sql = $conn->prepare("SELECT * FROM result WHERE id = ?");
$sql->bind_param("i", $id);

$sql->execute();

$row = $sql->get_result()->fetch_assoc();
/*$row = [id, student_name, matric_no, subject_name, subject_code, test1, test2, final_exam]
        [1, Ali, 2022,....
        2, Ahmad, 2023,...]
*/

$student_name = $row['name'];
$matric_no = $row['matric_no'];
$subject_name = $row['subject_name'];
$subject_code = $row['subject_code'];
$test1 = $row['test_1'];
$test2 = $row['test_2'];
$final_exam = $row['final'];

 if (isset (($_POST['submit']))) {
        $student_name = $_POST['student_name'];
        $matric_no = $_POST['matric_no'];
        $subject_name = $_POST['subject_name'];
        $subject_code = $_POST['subject_code'];
        $test1 = $_POST['test_1'];
        $test2 = $_POST['test_2'];
        $final_exam = $_POST['final'];

        $total = $test1 + $test2 + $final_exam;

        //80-100 = A
        //60-79 = B
        //50-64 = C
        //40-49 = D
        //0-39
        if ($total >= 80) 
            $grade = "A";
        else if ($total >= 65) 
            $grade = "B";
        else if ($total >= 50)
            $grade = "C";
        else if ($total >= 40)
            $grade = "D";
        else
            $grade = "E";
        

        $sql = $conn->prepare("UPDATE result SET 
                name = ?,
                matric_no = ?,
                subject_name = ?,
                subject_code = ?,
                test_1 = ?,
                test_2 = ?,
                `final` = ?,
                total = ?,
                grade = ?
                WHERE id = ?");
        $sql->bind_param("ssssiiiisi", $student_name, $matric_no, $subject_name, $subject_code, $test1, $test2, $final_exam, $total, $grade, $id);


        if ($sql->execute()) {
            header("Location: index.php");
            exit;
        }      
 }

include 'header.php';
?>

<h2>Edit Result</h2>

<?php
include 'form.php';
include 'footer.php';
?>