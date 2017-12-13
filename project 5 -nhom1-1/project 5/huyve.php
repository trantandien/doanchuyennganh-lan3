<?php 
ob_start();
include 'config.php';
include 'vender/connect.php';
session_start();
//print_r($_GET);exit;

if(isset($_GET["id"])){
	$id = $_GET["id"];
	settype($id,'int');
	if($id <= 0){
		header("location:quanly.php");
		exit();
	}else{
		$sql ="DELETE  FROM `donhang` WHERE id = '$id' ";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':id',$id,PDO::PARAM_INT);
		//echo $sql;
		$stmt->execute();
		//exit;
		?>
            <script>
                window.location='quanly.php';
            </script>
            <?php
		exit();
	}
}else{
	header("location:quanly.php");
	exit();
}
?>