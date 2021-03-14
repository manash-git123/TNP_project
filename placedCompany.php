<!DOCTYPE html>
<html>
<head>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
	<title>Drive Details</title>
	<style>
		.button {
					background-color: black;
					border: none;
					
					border-radius : 10px;
					color: white;
					padding: 10px 32px;
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
					color: black;
					font-weight:bold;
					border: 1px solid black;
					}
	</style>
</head>
<body style="padding-bottom: 10px; background-image: url(images/newspaper.jpg); background-size: cover;">
	<div class= "nav-bar">
		<div align= "center" ><img src="images/NITS.png" alt="" style="width:100px;height:100px; margin : 0 auto;"> <h1 style="font-family: garamond">National Institute of Technology</h1></div>
			
	</div>
	<a style="background-color: transparent;"style="text-decoration: none;"href="showstats.php"><button  class="button" style="position: relative; top:-35px;left:20px;">  Back</button></a>



	<hr>
	<h2 style="text-align: center;">The Students Placed are :</h2>
	<div style="border-radius: 10px;box-shadow: 5px 5px 5px 5px gray;" class="container">
		<div class="row">
			<div class="col-md-12">
				<div style="text-align: center;">
					
			<?php 
			session_start();
			
			include 'connection.php';
			if ($_SESSION['drive_id']) {
			 	$DriveID = $_SESSION['drive_id'];
			 	$sql = "SELECT DISTINCT * FROM `placementdetails` WHERE DriveID = $DriveID";
				 $result = mysqli_query($con,$sql);
				 
				 $sql10 = "SELECT DISTINCT  COUNT(DriveID) AS total FROM `placementdetails` WHERE DriveID = $DriveID";
				 $result10 = mysqli_query($con,$sql10);
				 $row10 = mysqli_fetch_assoc($result10);
				 $results_per_page = 5;
				 if (!isset($_GET['page'])) 
				 { 
					 $page  = 1; 
				 } 
				 else 
				 { 
					 $page=$_GET['page']; 
				 }
				 $start_from = ($page-1) * $results_per_page;
				 $total_pages = ceil($row10["total"] / $results_per_page);

			 	$sql1 = "SELECT * FROM driveschedule WHERE ID = $DriveID";
				$result1 = mysqli_query($con,$sql1);
				$row1 = mysqli_fetch_array($result1);
				$sql2 = "SELECT * FROM placementdetails WHERE DriveID = $DriveID";
				$result2 = mysqli_query($con,$sql2);
				$row2 = mysqli_fetch_array($result2);
				
			 	if ($result) {
			 		# code...
			 	?>
			 	<div>
			 	<div class="table-responsive"> 
			 	<table class="table">
			 		<thead style="background:#383736; color: white; ">
			 			
			 		<tr>
			 		<th scope="col" style="text-align: center;">Sl No</th>
			 		<th scope="col" style="text-align: center;">Name</th>
			 		<th scope="col" style="text-align: center;">Scholar ID</th>
			 		<th scope="col" style="text-align: center;">Check Experience</th>
			 		<!-- <th scope="col" style="text-align: center;">Placed</th> -->
			 		</tr>
			 		</thead>
			 </div>
			 	</div>
			 	<?php
				 $i=1;
				 $sql = "SELECT DISTINCT * FROM `placementdetails` WHERE DriveID = $DriveID LIMIT " .$start_from. ',' .$results_per_page;
                 $result = mysqli_query($con,$sql);
				while ($row = mysqli_fetch_array($result)) {
			 		 	$ScholarID=$row['ScholarID'];
			 		 	$sqlTemp = "SELECT * FROM `students` WHERE ScholarID = $ScholarID";
			 		 	$resultTemp = mysqli_query($con,$sqlTemp); 
			 		 	$rowTemp = mysqli_fetch_assoc($resultTemp);
			 ?>
			 <tbody>
			 	
			 <tr style="background-color: white;">
			 	<td><?php echo $i; ?></td>
			 	<td ><?php echo $rowTemp['Name']; ?></td>
			 	<td ><?php echo $ScholarID; ?></td>
			 	<?php 
			 		$exp = "Experience/jobExp".$ScholarID.".pdf";
			 		if(file_exists($exp)){
			 	?>

			 	<td><a target="_blank" href="<?php echo $exp; ?>" name="scholarID" class="button" style="padding-top:3px;padding-bottom:3px;"  value="<?php echo $row['ScholarID']; ?>">See Experience</a></td>
			 	<?php 
			 		}else{
			 	 ?>
			 	 	<td><i>Experience Not Added</i></td>

			 	<?php } ?>
			 	<?php 
			 	// if ($row2['ScholarID']==$row['ScholarID']) {
			 	// 	# code...
			 	// 	echo "<td>Placed</td>";
			 	// }else{
			 	// echo $row["ScholarID"];
			 	// echo '<td><form action="accepted.php" method="post"><button name="Placed" value="'.$row["ScholarID"].'">Mark Placed</button></form></td>';
			 	// }
			 	 ?>
			 </tr>

			 <?php 
			 	$i++;
			 	}
			echo " </tbody>
			 	</table><br>";
			 }else{

			 	echo "<br><br><br><h3>No responses found for the Drive (".$DriveID.")</h3>";
			 }
			}

			  ?>
			  <a>

				<?php
		for($page=1; $page<=$total_pages; $page++)
		{
			echo "<a style='font-size: 20px;background-color:rgb(44, 43, 43);color: white;border-radius:20%;' href='placedCompany.php?page=".$page."'";
			echo ">".$page."</a>&nbsp&nbsp";
		};
	?>
			</a>
			 </tbody>
			</table>
			</div>
			</div>
			</div>
		</div>
	</div>
</div>


	<hr>
	
	</div>
</body>
</html>