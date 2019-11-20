<?php

require '/home/lc8884l/include/connection.php';
//require "../../PHP/connection.php";

if (isset($_POST['stuUpload'])) {
    $stuFromStudent = $_SESSION['UserIDLogin'];
    $stuToStudent   = $_SESSION['ToStudent'];
    $stuEvaGrade    = $_POST['StuGrade'];
    $stuEvaComment  = mysqli_real_escape_string($connect, $_POST['StuComment']);
    $stuImageName   = addslashes(file_get_contents($_FILES['uploadImage']['tmp_name']));
    $stuImageType   = $_FILES['uploadImage']['type'];

    $queryEva = "INSERT INTO Evaluation (Grade, EComment, StudentImage, ImageType, EvaluationTo, EvaluationFrom) VALUES ('$stuEvaGrade', '$stuEvaComment', '$stuImageName', '$stuImageType', '$stuToStudent', '$stuFromStudent')";
    
    $queryDeleteSave = "DELETE FROM SaveComment WHERE EvaluationFrom ='$stuFromStudent' AND EvaluationTo ='$stuToStudent'";
    
    $msg = "<script>Swal.fire({type: 'success',title: 'Evaluation Complete',allowOutsideClick: false,confirmButtonText: 'OK',}).then((result) => {if (result.value) {location.href = 'RateStudent.php';}})</script>";
    
    if (!($_FILES['uploadImage']['type'])) {
        $connect->query($queryEva);
        $connect->query($queryDeleteSave);
        $msg;
    }
    
    else if (!preg_match('/gif|png|x-png|jpeg|jpg/', $_FILES['uploadImage']['type'])) {
        $msg = "<script>Swal.fire({type: 'error',title: 'Incompatible Image',text: 'Please Select A Compatible Image',allowOutsideClick: false,confirmButtonText: 'OK'})</script>";
        
    } else if ($_FILES['uploadImage']['size'] > 1600000) {
        $msg = "<script>Swal.fire({type: 'error',title: 'File Too Large',text: 'Please Select A Reasonable File Size',allowOutsideClick: false,confirmButtonText: 'OK'})</script>";
        
    } else {
        $connect->query($queryEva);
        $connect->query($queryDeleteSave);
        $msg;
    }
    
}

?>