<?php
///ini_set('display_errors', 1);
///ini_set('display_startup_errors', 1);
///error_reporting(E_ALL);
		
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
$dataPoints = array();
$dataPoints2 = array();
$dataPoints3 = array();
$senas = 0;
$senas2 = 0;
$senas3 = 0;
$ar_buvo = 0;
$ar_buvo2 = 0;
$ar_buvo3 = 0;
$matchai_nauji = 0;
$seni_matchai = 0;
$seni_killai = 0;
$nauji_killai = 0;
$naujos_mirtys = 0;
$senos_mirtys = 0;
$naujas_kd = 0;
$nauji_winai = 0;
$seni_winai = 0;
$nauji_losai = 0;
$seni_losai = 0;
$naujas_winrate = 0;
/// STATISTIKA RODYMUI
$kd = 0;
$mmr = 0;
$mmr_name = "";
$mmr_image = "";
$max_mmr = 0;
$max_mmr_name = "";
$max_mmr_image = "";
$wins = 0;
$losses = 0;
$matches = 0;
$kills = 0;
$deaths = 0;
$profile_id = "";
$level = 0;
$xp = 0;
$nickname = "";
$platform = "";
$proc = 0;
$season = 0;

			$sql = "SELECT last_update, user_id, user_stats FROM R6_2020_2 WHERE user_id='".$_GET['id']."'";
				$result = $con->query($sql);
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						
						$obj = json_decode($row['user_stats'], true);
						$data_sena = date($row['last_update']);
						$nauja_data = date('Y-m-d H:i:s',strtotime('-1 minutes', strtotime($data_sena)));
						$nauja_data = substr($nauja_data,0,10);
						if(strtotime($nauja_data) > strtotime('-999days'))
						{
						/// MMR LENTELE
							if($obj["players"][$row["user_id"]]["mmr"] > $senas && $ar_buvo == 0)
							{
								$skaicius = $obj["players"][$row["user_id"]]["mmr"] - $senas;
								$mmr = $obj["players"][$row["user_id"]]["mmr"];
								$dataPoints[ ] = array("label"=> $nauja_data, "y"=> $obj["players"][$row["user_id"]]["mmr"], "indexLabel"=> "'$mmr' (+'$skaicius')", "markerType"=> "triangle", "markerColor"=>"#6B8E23", "m"=> $skaicius, "r"=> $obj["players"][$row["user_id"]]["rankInfo"]["name"]);
								$senas = $obj["players"][$row["user_id"]]["mmr"];
								$ar_buvo++;
							}
							if($obj["players"][$row["user_id"]]["mmr"] < $senas && $ar_buvo == 0)
							{
								$skaicius = $obj["players"][$row["user_id"]]["mmr"] - $senas;
								$mmr = $obj["players"][$row["user_id"]]["mmr"];
								$dataPoints[ ] = array("label"=> $nauja_data, "y"=> $obj["players"][$row["user_id"]]["mmr"], "indexLabel"=> "'$mmr' ('$skaicius')", "markerType"=> "triangle", "markerColor"=>"tomato", "m"=> $skaicius, "r"=> $obj["players"][$row["user_id"]]["rankInfo"]["name"]);
								$senas = $obj["players"][$row["user_id"]]["mmr"];
								$ar_buvo++;
							}
							if($obj["players"][$row["user_id"]]["mmr"] == $senas && $ar_buvo == 0)
							{
								$skaicius = $obj["players"][$row["user_id"]]["mmr"] - $senas;
								$mmr = $obj["players"][$row["user_id"]]["mmr"];
								$dataPoints[ ] = array("label"=> $nauja_data, "y"=> $obj["players"][$row["user_id"]]["mmr"], "indexLabel"=> "", "markerType"=> "square", "markerColor"=>"grey", "m"=> $skaicius, "r"=> $obj["players"][$row["user_id"]]["rankInfo"]["name"]);
								$senas = $obj["players"][$row["user_id"]]["mmr"];
								$ar_buvo++;
							}
							//// KD LENTELE
							$nauji_killai = $obj["players"][$row["user_id"]]["kills"] - $seni_killai;
							$naujos_mirtys = $obj["players"][$row["user_id"]]["deaths"] - $senos_mirtys;
							if($nauji_killai != 0 && $naujos_mirtys != 0)
							{
								$naujas_kd = round($nauji_killai / $naujos_mirtys,3);
							}
							if($nauji_killai != 0 && $naujos_mirtys == 0)
							{
								$naujas_kd = $nauji_killai;
							}
							if($nauji_killai == 0 && $naujos_mirtys != 0)
							{
								$naujas_kd = $naujos_mirtys*(-1);
							}
							if($nauji_killai == 0 && $naujos_mirtys == 0)
							{
								$naujas_kd = 0;
							}
							
							
							if(($obj["players"][$row["user_id"]]["kills"] / $obj["players"][$row["user_id"]]["deaths"]) > $senas2 && $ar_buvo2 == 0)
							{
								$skaicius = round(($obj["players"][$row["user_id"]]["kills"] / $obj["players"][$row["user_id"]]["deaths"]) - $senas2,3);
								$kd = round($obj["players"][$row["user_id"]]["kills"] / $obj["players"][$row["user_id"]]["deaths"],3);
								$seni_killai = $obj["players"][$row["user_id"]]["kills"];
								$senos_mirtys = $obj["players"][$row["user_id"]]["deaths"];
								$dataPoints2[ ] = array("label"=> $nauja_data, "y"=> $kd, "indexLabel"=> "'$kd' (+'$skaicius')", "markerType"=> "triangle", "markerColor"=>"#6B8E23", "k"=> $obj["players"][$row["user_id"]]["kills"], "d"=> $obj["players"][$row["user_id"]]["deaths"], "t"=> $skaicius, "nk" => $nauji_killai, "nd"=> $naujos_mirtys, "nkd"=>$naujas_kd);
								$senas2 = $obj["players"][$row["user_id"]]["kills"] / $obj["players"][$row["user_id"]]["deaths"];
								$ar_buvo2++;
							}
							if(($obj["players"][$row["user_id"]]["kills"] / $obj["players"][$row["user_id"]]["deaths"]) < $senas2 && $ar_buvo2 == 0)
							{
								$skaicius = round(($obj["players"][$row["user_id"]]["kills"] / $obj["players"][$row["user_id"]]["deaths"]) - $senas2,3);
								$kd = round($obj["players"][$row["user_id"]]["kills"] / $obj["players"][$row["user_id"]]["deaths"],3);
								$seni_killai = $obj["players"][$row["user_id"]]["kills"];
								$senos_mirtys = $obj["players"][$row["user_id"]]["deaths"];
								$dataPoints2[ ] = array("label"=> $nauja_data, "y"=> $kd, "indexLabel"=> "'$kd' ('$skaicius')", "markerType"=> "triangle", "markerColor"=>"tomato", "k"=> $obj["players"][$row["user_id"]]["kills"], "d"=> $obj["players"][$row["user_id"]]["deaths"], "t"=> $skaicius, "nk" => $nauji_killai, "nd"=> $naujos_mirtys, "nkd"=>$naujas_kd);
								$senas2 = $obj["players"][$row["user_id"]]["kills"] / $obj["players"][$row["user_id"]]["deaths"];
								$ar_buvo2++;
							}
							if(($obj["players"][$row["user_id"]]["kills"] / $obj["players"][$row["user_id"]]["deaths"]) == $senas2 && $ar_buvo2 == 0)
							{
								$skaicius = round(($obj["players"][$row["user_id"]]["kills"] / $obj["players"][$row["user_id"]]["deaths"]) - $senas2,3);
								$kd = round($obj["players"][$row["user_id"]]["kills"] / $obj["players"][$row["user_id"]]["deaths"],3);
								$seni_killai = $obj["players"][$row["user_id"]]["kills"];
								$senos_mirtys = $obj["players"][$row["user_id"]]["deaths"];
								$dataPoints2[ ] = array("label"=> $nauja_data, "y"=> $kd, "indexLabel"=> "", "markerType"=> "square", "markerColor"=>"grey", "k"=> $obj["players"][$row["user_id"]]["kills"], "d"=> $obj["players"][$row["user_id"]]["deaths"], "t"=> $skaicius, "nk" => $nauji_killai, "nd"=> $naujos_mirtys, "nkd"=>$naujas_kd);
								$senas2 = $obj["players"][$row["user_id"]]["kills"] / $obj["players"][$row["user_id"]]["deaths"];
								$ar_buvo2++;
							}
							///MATCHES, WLR LENTELE
							$matchai_nauji = $obj["players"][$row["user_id"]]["wins"] + $obj["players"][$row["user_id"]]["losses"] - $seni_matchai;
							$nauji_winai = $obj["players"][$row["user_id"]]["wins"] - $seni_winai;
							$nauji_losai = $obj["players"][$row["user_id"]]["losses"] - $seni_losai;
							if($nauji_winai != 0 && $nauji_losai != 0)
							{
								$naujas_winrate = round((($nauji_winai * 100) / ($nauji_winai + $nauji_losai)),3);
							}
							if($nauji_winai == 0 && $nauji_losai != 0)
							{
								$naujas_winrate = 0;
							}
							if($nauji_winai != 0 && $nauji_losai == 0)
							{
								$naujas_winrate = 100;
							}
							if($nauji_winai == 0 && $nauji_losai == 0)
							{
								$naujas_winrate = 0;
							}
							
							if((($obj["players"][$row["user_id"]]["wins"] * 100) / ($obj["players"][$row["user_id"]]["wins"] + $obj["players"][$row["user_id"]]["losses"])) > $senas3 && $ar_buvo3 == 0)
							{
								$matches = $obj["players"][$row["user_id"]]["wins"] + $obj["players"][$row["user_id"]]["losses"];
								$seni_matchai = $matches;
								$seni_winai = $obj["players"][$row["user_id"]]["wins"];
								$seni_losai = $obj["players"][$row["user_id"]]["losses"];
								$skaicius = round((($obj["players"][$row["user_id"]]["wins"] * 100) / ($obj["players"][$row["user_id"]]["wins"] + $obj["players"][$row["user_id"]]["losses"])) - $senas3,3);
								$proc = round((($obj["players"][$row["user_id"]]["wins"] * 100) / ($obj["players"][$row["user_id"]]["wins"] + $obj["players"][$row["user_id"]]["losses"])),3);
								$dataPoints3[ ] = array("label"=> $nauja_data, "y"=> $proc, "indexLabel"=> "'$proc' (+'$skaicius')", "markerType"=> "triangle", "markerColor"=>"#6B8E23", "z"=> $matches, "d"=> $obj["players"][$row["user_id"]]["wins"], "n"=> $obj["players"][$row["user_id"]]["losses"], "m"=> $matchai_nauji, "nw"=> $nauji_winai, "nl"=> $nauji_losai, "nwr"=> $naujas_winrate);
								$senas3 = (($obj["players"][$row["user_id"]]["wins"] * 100) / ($obj["players"][$row["user_id"]]["wins"] + $obj["players"][$row["user_id"]]["losses"]));
								$ar_buvo3++;
							}
							if((($obj["players"][$row["user_id"]]["wins"] * 100) / ($obj["players"][$row["user_id"]]["wins"] + $obj["players"][$row["user_id"]]["losses"])) < $senas3 && $ar_buvo3 == 0)
							{
								$matches = $obj["players"][$row["user_id"]]["wins"] + $obj["players"][$row["user_id"]]["losses"];
								$seni_matchai = $matches;
								$seni_winai = $obj["players"][$row["user_id"]]["wins"];
								$seni_losai = $obj["players"][$row["user_id"]]["losses"];
								$skaicius = round((($obj["players"][$row["user_id"]]["wins"] * 100) / ($obj["players"][$row["user_id"]]["wins"] + $obj["players"][$row["user_id"]]["losses"])) - $senas3,3);
								$proc = round((($obj["players"][$row["user_id"]]["wins"] * 100) / ($obj["players"][$row["user_id"]]["wins"] + $obj["players"][$row["user_id"]]["losses"])),3);
								$dataPoints3[ ] = array("label"=> $nauja_data, "y"=> $proc, "indexLabel"=> "'$proc' ('$skaicius')", "markerType"=> "triangle", "markerColor"=>"tomato", "z"=> $matches, "d"=> $obj["players"][$row["user_id"]]["wins"], "n"=> $obj["players"][$row["user_id"]]["losses"], "m"=> $matchai_nauji, "nw"=> $nauji_winai, "nl"=> $nauji_losai, "nwr"=> $naujas_winrate);
								$senas3 = (($obj["players"][$row["user_id"]]["wins"] * 100) / ($obj["players"][$row["user_id"]]["wins"] + $obj["players"][$row["user_id"]]["losses"]));
								$ar_buvo3++;
							}
							if((($obj["players"][$row["user_id"]]["wins"] * 100) / ($obj["players"][$row["user_id"]]["wins"] + $obj["players"][$row["user_id"]]["losses"])) == $senas3 && $ar_buvo3 == 0)
							{
								$matches = $obj["players"][$row["user_id"]]["wins"] + $obj["players"][$row["user_id"]]["losses"];
								$seni_matchai = $matches;
								$seni_winai = $obj["players"][$row["user_id"]]["wins"];
								$seni_losai = $obj["players"][$row["user_id"]]["losses"];
								$skaicius = round((($obj["players"][$row["user_id"]]["wins"] * 100) / ($obj["players"][$row["user_id"]]["wins"] + $obj["players"][$row["user_id"]]["losses"])) - $senas3,3);
								$proc = round((($obj["players"][$row["user_id"]]["wins"] * 100) / ($obj["players"][$row["user_id"]]["wins"] + $obj["players"][$row["user_id"]]["losses"])),3);
								$dataPoints3[ ] = array("label"=> $nauja_data, "y"=> $proc, "indexLabel"=> "", "markerType"=> "square", "markerColor"=>"grey", "z"=> $matches, "d"=> $obj["players"][$row["user_id"]]["wins"], "n"=> $obj["players"][$row["user_id"]]["losses"], "m"=> $matchai_nauji, "nw"=> $nauji_winai, "nl"=> $nauji_losai, "nwr"=> $naujas_winrate);
								$senas3 = (($obj["players"][$row["user_id"]]["wins"] * 100) / ($obj["players"][$row["user_id"]]["wins"] + $obj["players"][$row["user_id"]]["losses"]));
								$ar_buvo3++;
							}
							///GAUNAM STATISTIKA
							$max_mmr = $obj["players"][$row["user_id"]]["max_mmr"];
							$max_mmr_name = $obj["players"][$row["user_id"]]["maxRankInfo"]['name'];
							$max_mmr_image = $obj["players"][$row["user_id"]]["maxRankInfo"]['image'];
							$mmr_name = $obj["players"][$row["user_id"]]["rankInfo"]['name'];
							$mmr_image = $obj["players"][$row["user_id"]]["rankInfo"]['image'];
							$kills = $obj["players"][$row["user_id"]]["kills"];
							$deaths = $obj["players"][$row["user_id"]]["deaths"];
							$wins = $obj["players"][$row["user_id"]]["wins"];
							$losses = $obj["players"][$row["user_id"]]["losses"];
							$profile_id = $obj["players"][$row["user_id"]]["profile_id"];
							$level = $obj["players"][$row["user_id"]]["level"];
							$xp = $obj["players"][$row["user_id"]]["xp"];
							$nickname = $obj["players"][$row["user_id"]]["nickname"];
							$platform = $obj["players"][$row["user_id"]]["platform"];
							$season = $obj["players"][$row["user_id"]]["season"];
							///
							$ar_buvo = 0;
							$ar_buvo2 = 0;
							$ar_buvo3 = 0;
							
						}
					}
					}

///echo $dataPoints;
///$sql = "UPDATE accounts SET password='".password_hash($_POST['newpassword1'], PASSWORD_DEFAULT)."' WHERE username='".$_POST['nickname']."'";
///mysqli_query($con, $sql);	
$con->close();
 
 
	
?>
<!DOCTYPE html>
<html>
<head>
<title>Rainbow6:Siege Statistics</title>
<script type="text/javascript">
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light2",
	title: {
		text: "Season 20 MMR/Rank history"
	},
	axisY: {
		title: "MMR"
	},
	toolTip:{
	fontColor: "white",
	backgroundColor: "rgba(0,0,0,0.9)",
	},
	data: [{
		type: "line",
		toolTipContent: "{label}<br><p style='color:yellow;padding-bottom:0px;margin-bottom:0px;'<strong>{y}</strong>(<strong>{m}</strong>) MMR</p><p style='color:orange;padding-bottom:0px;margin-bottom:0px;'<strong>{r}</strong></p>",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
 
var chart2 = new CanvasJS.Chart("chartContainer2", {
	theme: "dark2",
	title: {
		text: "Season 20 K/D history"
	},
	axisY: {
		title: "K/D"
	},
	data: [{
		type: "line",
		toolTipContent: "{label}<br><p style='color:yellow;'>SEASON<br><strong>{y}</strong>(<strong>{t}</strong>) K/D<br> <strong>{k}</strong> Kills<br><strong>{d}</strong> Deahts</p><p style='color:orange;padding-bottom:0px;margin-bottom:0px;'>SESSION<br><strong>{nkd}</strong> K/D<br> <strong>{nk}</strong> Kills<br><strong>{nd}</strong> Deahts</p>",
		dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
	}]
});

var chart3 = new CanvasJS.Chart("chartContainer3", {
	theme: "light2",
	title: {
		text: "Season 20 Matches Played history"
	},
	axisY: {
		title: "Matches winning %"
	},
	toolTip:{
	fontColor: "white",
	backgroundColor: "rgba(0,0,0,0.9)",
	},
	data: [{
		type: "line",
		toolTipContent: "{label}<br><p style='color:yellow;'>SEASON<br><strong>{y}</strong>% Winrate<br><strong>{z}</strong> Matches<br><strong>{d}</strong> Wins<br><strong>{n}</strong> Losses</p><p style='color:orange;padding-bottom:0px;margin-bottom:0px;'>SESSION<br><strong>{nwr}</strong>% Winrate<br><strong>{m}</strong> Matches<br><strong>{nw}</strong> Wins<br><strong>{nl}</strong> Losses</p>",
		dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
	}]
});

chart.render();
chart2.render();
chart3.render();
 
}
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.js" integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
</head>
<body style="background-color: #31373a;">

<div class="container">
    <div class="main-body">
    <br>
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body" style="padding-bottom:45px;">
                  <div class="d-flex flex-column align-items-center text-center">
                    <div class="mt-3">
                      <h1><?=$nickname?></h1>
                      <p class="text-secondary mb-1"><b><?=$level?></b> level with <b><?=$xp?></b> experience points</p>
					  <hr>
					  <p class="text-muted font-size-sm"><div class="row d-flex align-items-center justify-content-center"><strong><h4>SEASON <?=$season?> RANKING</h4></strong></div></p>
                      <p class="text-muted font-size-sm"><div class="row d-flex align-items-center justify-content-center">Current<img style="width:45px; height:40px;" src="<?=$mmr_image?>"></img><b><?=$mmr_name?></b>&nbsp;with&nbsp;<b><?=round($mmr,2)?></b>&nbsp;MMR</div></p>
					  <p class="text-muted font-size-sm"><div class="row d-flex align-items-center justify-content-center">Highest<img style="width:45px; height:40px;" src="<?=$max_mmr_image?>"></img><b><?=$max_mmr_name?></b>&nbsp;with&nbsp;<b><?=round($max_mmr,2)?></b>&nbsp;MMR</div></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="row gutters-sm">
                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Season <?=$season?></i> Performance Statistics</h6>
                      <small>Kills <strong><?=$kills?></strong></small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?=(($kills/($kills+$deaths))*100)?>%" aria-valuenow="<?=$kills?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Deaths <strong><?=$deaths?></strong></small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?=(($deaths/($kills+$deaths))*100)?>%" aria-valuenow="<?=$deaths?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>K/D <strong><?=$kd?></strong></small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?=(($kd/2)*100)?>%" aria-valuenow="<?=$kd?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Season <?=$season?></i> Matches Statistics</h6>
                      <small>Matches <strong><?=$matches?></strong></small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?=(($matches/300)*100)?>%" aria-valuenow="<?=$matches?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Wins <strong><?php if(($wins+$losses) != $matches){ echo $wins." Roll-Back";} else { echo $wins; }?></strong></small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?=(($wins/($wins+$losses))*100)?>%" aria-valuenow="<?=$wins?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Losses <strong><?php if(($wins+$losses) != $matches){ echo $losses." Roll-Back";} else { echo $losses; }?></strong></small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?=(($losses/($wins+$losses))*100)?>%" aria-valuenow="<?=$losses?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
				<div class="col-sm-12 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <small>Platform <strong><?=$platform?></strong></small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="<?=$matches?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>User ID <strong><?=$profile_id?></strong></small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="<?=$wins?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
	<br>
	<div id="chartContainer" style="height: 370px; width: 100%;"></div>
	<br><br><br>
    <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
	<br><br><br>
    <div id="chartContainer3" style="height: 370px; width: 100%;"></div>
	



<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</body>
</html>