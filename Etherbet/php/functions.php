<?php

$teams = array(
    // countries
	"Argentina" 	=> "cyar",
	"Belgium" 		=> "cybe",
	"Brazil" 		=> "cybr",
	"Colombia" 		=> "cyco",
	"Croatia" 		=> "cyhr",
	"Denmark" 		=> "cydk",
	"England" 		=> "cyen",
	"France"     	=> "cyfr",
	"Japan"       	=> "cyjp",
	"Mexico"      	=> "cymx",
	"Portugal"    	=> "cypt",
	"Russia"      	=> "cyru",
	"Spain"       	=> "cyes",
	"Sweden"      	=> "cyse",
	"Switzerland"	=> "cych",
	"Uruguay"     	=> "cyuy",
    
    // clubs
    "AEK"               => "cbak",
    "Ajax"              => "cbaj",
    "Atlético"          => "cbat",
    "Barcelona"         => "cbbr",
    "Bayern"            => "cbby",
    "Benfica"           => "cbbn",
    "CSKA Moskva"       => "cbcm",
    "Club Brugge"       => "cbcb",
    "Crvena zvezda"     => "cbcz",
    "Dortmund"          => "cbdr",
    "Galatasaray"       => "cbgl",
    "Hoffenheim"        => "cbhf",
    "Internazionale"    => "cbin",
    "Juventus"          => "cbju",
    "Liverpool"         => "cbli",
    "Lokomotiv Moskva"  => "cblm",
    "Lyon"              => "cbly",
    "Man. City"         => "cbmc",
    "Man. United"       => "cbmu",
    "Monaco"            => "cbmn",
    "Napoli"            => "cbnp",
    "PSV"               => "cbps",
    "Paris"             => "cbpa",
    "Plzeň"             => "cbpl",
    "Porto"             => "cbpo",
    "Real Madrid"       => "cbrm",
    "Roma"              => "cbro",
    "Schalke"           => "cbsc",
    "Shakhtar Donetsk"  => "cbsd",
    "Tottenham"         => "cbto",
    "Valencia"          => "cbva",
    "Young Boys"        => "cbyb"
);

/**
 * 
 */
function insert_table_header() {
?>
		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th class="header">Total pool</th>
			<th class="header">Bets closing in</th>
		</tr>	
<?php
}

/**
 * 
 * @param array $matches
 */
function insert_matches($matches) {
?>
<table class="shadow match">
	<tbody>
		<?php insert_table_header(); ?>
<?php
    foreach ($matches as $match) {
        insert_match($match[0], $match[1], $match[2], $match[3], $match[4]);
    }
?>
	</tbody>
</table>		
<?php     
}

/**
 *
 * @param array $matches
 */
function insert_finished_matches($matches) {
?>
<table class="shadow match">
	<tbody>
	<?php insert_table_header(); ?>
<?php
    foreach ($matches as $match) {
        insert_finished_match($match[0], $match[1], $match[2], $match[3], $match[4]);
    }
?>
	</tbody>
</table>		
<?php     
}

/**
 * 
 * @param string $total_id
 */
function insert_total($total_id) {
?>
	<span id="<?=$total_id?>">
		<span class="tooltip">? 
			<span class="tooltiptext">
				To see this you need <a href="https://addons.mozilla.org/en-US/firefox/addon/ether-metamask/" target="_blank">Metamask</a> plugin.
			</span>
		</span>
	</span>
<?php
}

/**
 *
 */
function insert_dummy_match($team1, $team2, $time, $contract_address) {
    
    $exists1 = array_key_exists($team1, $GLOBALS["teams"]);
    $exists2 = array_key_exists($team2, $GLOBALS["teams"]);
    
    $team_code1 = $exists1 ? $GLOBALS["teams"][$team1] : $team1;
    $team_code2 = $exists2 ? $GLOBALS["teams"][$team2] : $team2;
    
    $img_src1 = $exists1 ? ("./img/" . $team_code1 . ".png") : "./img/question.png";
    $img_src2 = $exists2 ? ("./img/" . $team_code2 . ".png") : "./img/question.png";
    
    $alt1 = $exists1 ? "Flag" : "";
    $alt2 = $exists2 ? "Flag" : "";
    
    $suffix = "_" . $team_code1 . $team_code2;
    $counter_id = "counter" . $suffix;
?>
<table class="shadow match">
	<tbody>
		<tr>
			<td class="header" colspan="5">TOTAL POOL: 0</td>
		</tr>
		<tr>
			<td rowspan="2" class="leftside"><img class="flag" alt="<?=$alt1?>" src="<?=$img_src1?>" /></td>
			<td class="team leftside"><?=$team1?></td>
			<td class="vs">vs.</td>
			<td class="team"><?=$team2?>&nbsp;&nbsp;&nbsp;</td>
			<td rowspan="2"><img class="flag" alt="<?=$alt2?>" src="<?=$img_src2?>" /></td>
		</tr>
		<tr>
			<td colspan="3" class="progress">To be announced</td>
		</tr>
		<tr>
			<td colspan="2" class="padding"></td>
			<td></td>
			<td colspan="2" class="padding"></td>
		</tr>
		<tr>
			<td colspan="5">
				<table class="maxwidth">
					<tbody>
						<tr id="active_counter<?=$suffix?>">
							<td class="half leftside">Time left to place a bet:</td>
							<td class="half"><div id="<?=$counter_id?>"></div></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
<script>
var <?=$counter_id?> = setInterval(function() { 
	setCountdownTimer(new Date("<?=$time?>").getTime(), "<?=$suffix?>"); 
}, 1000);
</script>
<br />
<?php
}

/**
 * 
 * @param int    $match_id
 * @param string $team1
 * @param string $team2
 * @param string $time
 * @param string $contract_address
 */
function insert_match($match_id, $team1, $team2, $time, $contract_address) {
    
    $team_code1 = $GLOBALS["teams"][$team1];
    $team_code2 = $GLOBALS["teams"][$team2];
    
    $img_src1 = "./img/" . $team_code1 . ".png";
    $img_src2 = "./img/" . $team_code2 . ".png";

    $suffix     = "_" . $team_code1 . $team_code2;

    $button_id  = "button"  . $suffix;
    $total_id   = "total"   . $suffix;
    $counter_id = "counter" . $suffix;
	
	$current_time = time();
	$match_time   = DateTime::createFromFormat("M d, Y H:i", $time, new DateTimeZone('UTC'))->getTimestamp();
	
	$are_bets_open = $current_time < $match_time;
?>
		<tr>
			<td class="team leftside"><?=$team1?></td>
			<td class="leftside"><img class="flag" alt="Flag" src="<?=$img_src1?>" /></td>
			<td class="vs">vs.</td>
			<td><img class="flag" alt="Flag" src="<?=$img_src2?>" /></td>
			<td class="team"><?=$team2?></td>
			<td class="center">
				<button type="button" class="button" id="<?=$button_id?>">BET!</button>
				<p class="hidden" id="in_progress<?=$suffix?>">In progress!</p>
			</td>
			<td class="header"><?php insert_total($total_id) ?> ETH</td>
			<td class="center"><div id="<?=$counter_id?>"></div></td>
		</tr>
<script>
var contractInstance<?=$suffix?> = null;
if (contract != null) {
	contractInstance<?=$suffix?> = contract.at("<?=$contract_address?>");
	updateTotalPool(contractInstance<?=$suffix?>, <?=$match_id?>, "<?=$total_id?>");
}
setCountdownTimer(new Date("<?=$time?>").getTime(), "<?=$suffix?>");
<?php if ($are_bets_open) { ?>
setWinButtonListener("<?=$button_id?>", "<?=$img_src1?>", "<?=$team1?>", "<?=$img_src2?>", "<?=$team2?>", contractInstance<?=$suffix?>, <?=$match_id?>, "<?=$total_id?>");
<?php } ?>
</script>
<?php
}

/**
 *
 * @param int    $match_id
 * @param string $team1
 * @param string $team2
 * @param string $result
 * @param string $contract_address
 */
function insert_finished_match($match_id, $team1, $team2, $result, $contract_address) {
    
    $team_code1 = $GLOBALS["teams"][$team1];
    $team_code2 = $GLOBALS["teams"][$team2];
    
    $img_src1 = "./img/" . $team_code1 . ".png";
    $img_src2 = "./img/" . $team_code2 . ".png";
    
    $suffix = "_" . $team_code1 . $team_code2;
    
    $total_id  = "total"  . $suffix;
    $button_id = "button" . $suffix;
    ?>
    	<tr>
        	<td class="team leftside"><?=$team1?></td>
        	<td class="leftside"><img class="flag" alt="Flag" src="<?=$img_src1?>" /></td>
        	<td class="result"><?=$result?></td>
        	<td><img class="flag" alt="Flag" src="<?=$img_src2?>" /></td>
    		<td class="team"><?=$team2?></td>
			<td class="center">
				<button type="button" class="button" id="<?=$button_id?>">CLAIM!</button>
				<p class="hidden" id="all_claimed<?=$suffix?>">All bets claimed!</p>
			</td>
			<td class="header"><?php insert_total($total_id) ?> ETH</td>
			<td class="center" style="color:red">CLOSED!</td>
		</tr>
<script>
var contractInstance<?=$suffix?> = null;
if (contract != null) {
	contractInstance<?=$suffix?> = contract.at("<?=$contract_address?>");
	updateTotalPool(contractInstance<?=$suffix?>, <?=$match_id?>, "<?=$total_id?>");
	updateClaimStatus(contractInstance<?=$suffix?>, <?=$match_id?>, "<?=$suffix?>");
}

setClaimButtonListener("<?=$button_id?>", contractInstance<?=$suffix?>, <?=$match_id?>);
</script>
<?php
}
?>