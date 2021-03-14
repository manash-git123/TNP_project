<?php 
session_start();
error_reporting(0);
include 'connection.php';
if (isset($_POST['submit'])) {
	$branch = $_POST['branch'];
	$CPI_s = $_POST['CPI_s'];
	$CPI_e = $_POST['CPI_e'];
	$year = $_POST['year'];
	$_SESSION['branch'] = $_POST['branch'];
	$_SESSION['CPI_s'] = $_POST['CPI_s'];
	$_SESSION['CPI_e'] = $_POST['CPI_e'];
	$_SESSION['year'] = $_POST['year'];
	$_SESSION['academic'] = 1;

}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Academic Performance</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
 	<style>
 		.button {
					background-color: black;
					border: none;
					
					border-radius : 10px;
					color: white;
					padding: 7px 26px;
					text-align: center;
					text-decoration: none;
					display: inline-block;
					font-size: 16px;
					margin: 4px 2px;
					-webkit-transition-duration: 0.4s; 
					transition-duration: 0.4s;
					cursor: pointer;
					}
					.button:hover {
					background-color: #ebe6e6; 
					text-decoration: none;
					font-weight:bold;
					color: black;
					border: 1px solid black;
					}
 		.container{
 			background: white;
 			/*margin-top: 20px;*/
 			padding-top: 20px;
 		}
 		input[type="checkbox"]{
 			height: 20px;
 			width: 20px;
 		}
 		input[type="date"], select{
 			font-size:1.4em;
 			text-decoration: none;
 			border-radius: 10px;
 			margin-bottom: 20px;
 		}
 		input[type=submit]{
			color:white;
			background-color: grey;
			padding: 12px 20px;
			border: 1px solid black;
			border-radius: 10px;
			cursor: pointer;
			
		}
		input[type=submit]:hover{
			color: black;
			background-color: white;
			padding: 12px 20px;
			border: 1px solid black;
			border-radius: 10px;
			cursor: pointer;
		}
		label{
			font-family: Times New Roman;
			font-size: 1.2em;
			font-weight: 600;
		}
 	</style>
</head>
<body style="background-image: url(images/light.jpg) ; 
 			background-size: cover; ">
 			<div class= "nav-bar" style="background-image: url(images/newspaper.jpg); 
 			background-size: cover;box-shadow: 5px 5px 5px 5px gray; ">
		
		<div style="margin-bottom: 0;" align= "center" ><img src="images/NITS.png" alt="" style="width:100px;height:100px; margin : 0 auto;"> <h1 style="font-family: garamond; margin: 0;">National Institute of Technology, Silchar</h1></div>
		<button align="center" style=" background-color:#366bd6;color: white;text-decoration:none;padding: 7px 20px;border: none;border-radius: 4px;cursor: pointer; margin: 10px;"><a style="color: white;text-decoration: none; "href="specialView.php" >Back</a>
		 </button>
		</div>
	</div>
	<div class="container" style="margin-top: 20px;box-shadow: 5px 5px 5px 5px gray; text-align: center;">
	<h1 style="font-family: Algerian; ">
		Academic Statistics
	</h1><hr>
		<form action="" method="post">
			<label>Branch :</label>
			<select name="branch">
				<option value="CE" <?php if($_SESSION['branch']=="CE"){echo "selected";} ?>>Civil</option>
				<option value="ME" <?php if($_SESSION['branch']=="ME"){echo "selected";}?>>Mechanical</option>
				<option value="EE" <?php if($_SESSION['branch']=="EE"){echo "selected";}?>>Electrical</option>
				<option value="ECE" <?php if($_SESSION['branch']=="ECE"){echo "selected";}?>>Electronics & Communication</option>
				<option value="CSE" <?php if($_SESSION['branch']=="CSE"){echo "selected";}?>>Computer Science</option>
				<option value="EIE" <?php if($_SESSION['branch']=="EIE"){echo "selected";}?>>Electronics & Instrumentation</option>
			</select>
			<br>
			<label>Starting CPI :</label>
			<input required="" type="text" name="CPI_s" value="<?php echo $_SESSION['CPI_s']?>">&nbsp&nbsp&nbsp	
			<label>Ending CPI :</label>
			<input required="" type="text" name="CPI_e" value="<?php echo $_SESSION['CPI_e']?>">
			<br>
			<label>Enrollment Year(Ex-20XX) :</label>
			<input required="" type="number" name="year"  value="<?php echo $_SESSION['year']?>">
			<br><br>
			<input type="submit" name="submit" value="Search">
			<br><br><br>
		</form> 
<?php  
if (isset($_POST['submit'])) {
?>
<div id="content">
	<table class="table">
		<thead style="background:#383736; color: white; ">
			<tr>
				
			<th>Scholar ID:</th>
			<th>Name:</th>
			<th>Semester 1:</th>
			<th>Semester 2:</th>
			<th>Semester 3:</th>
			<th>Semester 4:</th>
			<th>Semester 5:</th>
			<th>Semester 6:</th>
			<th>Semester 7:</th>
			<th>Semester 8:</th>
			<th>CPI:</th>
			<th>Visit Profile:</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			$sql = "SELECT * FROM academicdetails";
			$result = mysqli_query($con,$sql);
			while ($row = mysqli_fetch_assoc($result)) {
				$sql1 = "SELECT * FROM students WHERE ScholarID = ".$row['ScholarID']."";
				$result1 = mysqli_query($con,$sql1);
				$row1 = mysqli_fetch_assoc($result1);
			$year = (int)($row['ScholarID']/100000);
			$branch = $row1['Department'];
			$year = 2000 + $year;
					if($_POST['CPI_s']<$row['CPI']&&$_POST['CPI_e']>$row['CPI']&&$_POST['year']==$year&&$branch==$_POST['branch']){
		 ?>
			<tr>
				
			<td style="text-align: center;"><?php echo $row['ScholarID']; ?></td>
			<td style="text-align: center;"><?php echo $row1['Name']; ?></td>
			<td style="text-align: center;"><?php if ($row['Semester1']) {
				echo $row['Semester1'];
			}else{
				echo "-";
			}?></td>
			<td style="text-align: center;"><?php if ($row['Semester2']) {
				echo $row['Semester2'];
			}else{
				echo "-";
			}?></td>
			<td style="text-align: center;"><?php if ($row['Semester3']) {
				echo $row['Semester3'];
			}else{
				echo "-";
			}?></td>
			<td style="text-align: center;"><?php if ($row['Semester4']) {
				echo $row['Semester4'];
			}else{
				echo "-";
			}?></td>
			<td style="text-align: center;"><?php if ($row['Semester5']) {
				echo $row['Semester5'];
			}else{
				echo "-";
			}?></td>
			<td style="text-align: center;"><?php if ($row['Semester6']) {
				echo $row['Semester6'];
			}else{
				echo "-";
			}?></td>
			<td style="text-align: center;"><?php if ($row['Semester7']) {
				echo $row['Semester7'];
			}else{
				echo "-";
			}?></td>
			<td style="text-align: center;"><?php if ($row['Semester8']) {
				echo $row['Semester8'];
			}else{
				echo "-";
			}?></td>
			<td style="text-align: center;"><?php echo $row['CPI']; ?></td>
			<td style="text-align: center;"><form action="guest_view.php" method="post"><button name="scholarID" class="button" style="padding-top:3px;padding-bottom:3px;"  value="<?php echo $row['ScholarID']; ?>">Visit</button></form></td>
			</tr>
				
		<?php } 
				}
				 ?>
		</tbody>
	</table>
</div>
<?php } ?>

	</div>
	<br>
	<div align="center">
		
<form action='excelAcademic.php' method='post'>
                    <button type='submit' name="create_excel" value="4" id="create_excel" class="btn btn-success">Create Excel File</button></form>
	</div>


</body>
</html>