<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
		

$DATABASE_HOST = '';
$DATABASE_USER = '';
$DATABASE_PASS = '';
$DATABASE_NAME = '';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

/* check if server is alive */
if (mysqli_ping($con)) {
    ///printf ("Our connection is ok!\n");
} else {
    printf ("Error: %s\n", mysqli_error($con));
}
?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.js" integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
</head>
<body style="background-color: #31373a;">
<br>
<center><h1 class="text-white"><strong>Statistics by andri588</strong></h1></center>
<br>
<div class='container'>
<div class='row'>
<div class='col-sm-6'>
<?php

///$sql3 = "SELECT most_mmr_gain, most_mmr_lost, most_games_played, most_games_won, most_games_lost, highest_kd, lowest_kd, date FROM R6_INDEX";
///				$result3 = $con->query($sql3);
///				if ($result3->num_rows > 0) {
///					while($row3 = $result3->fetch_assoc()) {

?>
<!-- <table class="table table-bordered table-dark">
  <thead>
    <tr>
      <th scope="col"><?=$row3['date']?> Statistics</th>
      <th scope="col">Nickname</th>
      <th scope="col">Score</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Most MMR gain</th>
      <td><?=$row3['most_mmr_gain']?></td>
      <td>Otto</td>
    </tr>
    <tr>
      <th scope="row">Most MMR lost</th>
      <td><?=$row3['most_mmr_lost']?></td>
      <td>Thornton</td>
    </tr>
	<tr>
      <th scope="row">Most matches played</th>
      <td><?=$row3['most_games_played']?></td>
      <td>Thornton</td>
    </tr>
	<tr>
      <th scope="row">Most matches won</th>
      <td><?=$row3['most_games_won']?></td>
      <td>Thornton</td>
    </tr>
	<tr>
      <th scope="row">Most matches lost</th>
      <td><?=$row3['most_games_lost']?></td>
      <td>Thornton</td>
    </tr>
	<tr>
      <th scope="row">Highest K/D</th>
      <td><?=$row3['highest_kd']?></td>
      <td>Thornton</td>
    </tr>
	<tr>
      <th scope="row">Lowest K/D</th>
      <td><?=$row3['lowest_kd']?></td>
      <td>Thornton</td>
    </tr>
  </tbody>
</table>
-->
<?php
///					}
///				}
				?>
</div>
<div class='col-sm-6'>
<center><h2 class="text-white"><strong>Season 22 (current)</strong></h2></center>
<?php
$irasyti = array();
$sql = "SELECT user_id, username FROM R6_";
				$result = $con->query($sql);
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						if(!in_array($row['user_id'],$irasyti))
						{
						array_push($irasyti, $row['user_id']);
							?>
							<a class="btn btn-secondary btn-lg btn-block" href="stats.php?id=<?=$row['user_id']?>" role="button"><?=$row['username']?></a>
							<?php
						}
					}
				}
				
?>
<center><h2 class="text-white"><strong>Season 21 </strong></h2></center>
<?php
$irasyti = array();
$sql = "SELECT user_id, username FROM R6_2021_1";
				$result = $con->query($sql);
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						if(!in_array($row['user_id'],$irasyti))
						{
						array_push($irasyti, $row['user_id']);
							?>
							<a class="btn btn-secondary btn-lg btn-block" href="stats21.php?id=<?=$row['user_id']?>" role="button"><?=$row['username']?></a>
							<?php
						}
					}
				}
				
?>
<center><h2 class="text-white"><strong>Season 20</strong></h2></center>
<?php
$irasyti2 = array();
$sql2 = "SELECT user_id, username FROM R6_2020_2";
				$result2 = $con->query($sql2);
				if ($result2->num_rows > 0) {
					while($row2 = $result2->fetch_assoc()) {
						if(!in_array($row2['user_id'],$irasyti2))
						{
						array_push($irasyti2, $row2['user_id']);
							?>
							<a class="btn btn-secondary btn-lg btn-block" href="stats20.php?id=<?=$row2['user_id']?>" role="button"><?=$row2['username']?></a>
							<?php
						}
					}
				}
				
?>
</div>
</div>
</div>
</body>
</html>