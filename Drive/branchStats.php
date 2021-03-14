<?php 
session_start();
error_reporting(0);
include "../connection.php";
if (isset($_POST['submit'])) {
	$branch = $_POST['branch'];
	$_SESSION['branch']=$branch;
	$Year = $_POST['year'];
	$_SESSION['year'] = $Year;
}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Branchwise Statistics</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
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
<body style="background-image: url(../images/light.jpg) ; 
 			background-size: cover; ">
 			<div class= "nav-bar" style="background-image: url(../images/newspaper.jpg); 
 			background-size: cover;box-shadow: 5px 5px 5px 5px gray; ">
		
		<div style="margin-bottom: 0;" align= "center" ><img src="../images/NITS.png" alt="" style="width:100px;height:100px; margin : 0 auto;"> <h1 style="font-family: garamond; margin: 0;">National Institute of Technology, Silchar</h1></div>
		<button align="center" style=" background-color:#366bd6;color: white;text-decoration:none;padding: 7px 20px;border: none;border-radius: 4px;cursor: pointer; margin: 10px;"><a style="color: white;text-decoration: none; "href="../specialView.php" >Back</a>
		 </button>
		</div>
	</div>
	<div class="container" style="margin-top: 20px;box-shadow: 5px 5px 5px 5px gray; text-align: center;">
	<h1 style="font-family: Algerian; ">
		Branchwise Statistics
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
			<br>
			<label>Enrollment Year(Ex-20XX) :</label>
			<input type="number" name="year" required="" value="<?php echo $_SESSION['year']; ?>">
			<br>
			<br>
			<input type="submit" name="submit" value="Search">
		</form>
	<?php 
	if ($_POST['submit']) {
		
		$sql = "SELECT * FROM students WHERE Department = '$branch'";
		$result = mysqli_query($con,$sql);
		$total = 0;
		$eligible = 0;
		$placed = 0;
		$totalHigher = 0;
		$jobsHigher=0;
		$placedHigher=0;
		while ($row = mysqli_fetch_assoc($result)) {
			$year = (int)($row['ScholarID']/100000);
			$year = 2000 + $year;
			if ($year==$Year) {
				++$total;
				if ($row['HigherStudies']==1) {
					++$totalHigher;	
					if ($row['Jobs']) {
									++$jobsHigher; 
								}			
				}
			}
			$sql1 = "SELECT * FROM academicdetails WHERE ScholarID = ".$row['ScholarID']." AND CPI > 7";
			$result1 = mysqli_query($con,$sql1);
			while ($row1 = mysqli_fetch_assoc($result1)) {
			if ($year==$Year) {
				++$eligible;

			}
		}
			$sql2 = "SELECT DISTINCT * FROM placementdetails WHERE ScholarID = ".$row['ScholarID']."";
			$result2 = mysqli_query($con,$sql2);
			while ($row2 = mysqli_fetch_assoc($result2)) {
			if ($year==$Year) {
				++$placed;
				if ($row['HigherStudies']==1) {
					++$placedHigher;
				}
			}
		}
		}
	 ?>
	<div align="center">
		<h1>Branch <?php echo $branch; ?></h1>
		<b>Total Students: <?php echo $total; ?></b><br><br>
		<b>Eligible for Jobs: <?php echo $eligible; ?></b><br><br>
		<b>Total Students Placed: <?php echo $placed; ?></b><br><br>	
	</div>
	<div align="center">
		<h1>Intrested In Higher Studies</h1>
		<table>
			<thead>
				<tr>
					<th>Total</th>
					<th>Interested in Jobs</th>
					<th>Not Interested in Jobs</th>
					<th>Placed</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td align="center"><?php echo $totalHigher; ?></td>
					<td align="center"><?php echo $jobsHigher; ?></td>
					<td align="center"><?php echo $totalHigher-$jobsHigher; ?></td>
					<td align="center"><?php echo $placedHigher; }?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<br><br>
	</div>
	<br>
</body>
</html>