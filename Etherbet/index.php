<!DOCTYPE html>
<html>
	<head>
		<noscript>
  			<meta http-equiv="refresh" content="0;url=noscript.html">
		</noscript>	
		<meta content="text/html; charset=UTF-8" http-equiv="content-type">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="./css/body.css">
		<link rel="stylesheet" href="./css/button.css">
		<link rel="stylesheet" href="./css/floating_button.css">
		<link rel="stylesheet" href="./css/tooltip.css">
		<link rel="stylesheet" href="./css/index.css">
		<link rel="stylesheet" href="./css/modal.css">
		<link rel="stylesheet" href="./css/snackbar.css">
		<title>Etherbet</title>
	</head>
	<body>
		<script type="text/javascript" src="./js/functions.js"></script>
		<script type="text/javascript">

		var contract = null;
		if (typeof web3 !== 'undefined') {

			web3 = new Web3(web3.currentProvider);
			contract = web3.eth.contract(<?php include "abi.txt"; ?>);
		}
		
		</script>
		
		<button onclick="location.href='faq.php';" id="floatingButtonFAQ" title="Go to FAQ">FAQ</button>
		<?php if (isset($_GET["test"])) { ?>
			<button onclick="location.href='.';" id="floatingButtonTest" title="Main Ethereum Network">Bet with real money</button>
		<?php } else { ?>
			<button onclick="location.href='?test';" id="floatingButtonTest" title="Ropsten Test Network">Bet with fake money</button>		    
		<?php } ?>
		
		<h1>UEFA Champions League</h1>
		<h2 class="subtitle">ROUND OF 16 - 1ST LEG</h2>
		<h3 class="subtitle">Tuesday 12 February 2019</h3>
<?php
	
	include "./php/functions.php";
	include "./php/contract.php";
	
	$MATCH_TIME1 = "Feb 12, 2019 20:00";
	$MATCH_TIME2 = "Feb 13, 2019 20:00";
	$MATCH_TIME3 = "Feb 19, 2019 20:00";
	$MATCH_TIME4 = "Feb 20, 2019 20:00";

/*	
	$matches1 = array(
    	array(0, "AEK",              "Bayern",      "0-2", CONTRACT_ADDRESS),
    	array(1, "Young Boys",       "Valencia",    "1-1", CONTRACT_ADDRESS),
    	array(2, "Ajax",             "Benfica",     "1-0", CONTRACT_ADDRESS),
    	array(3, "Shakhtar Donetsk", "Man. City",   "0-3", CONTRACT_ADDRESS),
    	array(4, "Hoffenheim",       "Lyon",        "3-3", CONTRACT_ADDRESS),
    	array(5, "Real Madrid",      "Plzeň",       "2-1", CONTRACT_ADDRESS),
    	array(6, "Roma",             "CSKA Moskva", "3-0", CONTRACT_ADDRESS),
    	array(7, "Man. United",      "Juventus",    "0-1", CONTRACT_ADDRESS),
	);
	
	insert_finished_matches($matches1);
*/
	$matches1 = array(
	    array(0, "Roma",        "Porto",   $MATCH_TIME1, CONTRACT_ADDRESS),
	    array(1, "Man. United", "Paris",   $MATCH_TIME1, CONTRACT_ADDRESS),
	);
	
	$matches2 = array(
	    array(2, "Tottenham", "Dortmund",      $MATCH_TIME2, CONTRACT_ADDRESS),
	    array(3, "Ajax",      "Real Madrid",   $MATCH_TIME2, CONTRACT_ADDRESS),
	);
	    
    $matches3 = array(
	    array(4, "Lyon",       "Barcelona",    $MATCH_TIME3, CONTRACT_ADDRESS),
	    array(5, "Liverpool",  "Bayern",       $MATCH_TIME3, CONTRACT_ADDRESS),
    );
	    
    $matches4 = array(
	    array(6, "Atlético",   "Juventus",     $MATCH_TIME4, CONTRACT_ADDRESS),
	    array(7, "Schalke",    "Man. City",    $MATCH_TIME4, CONTRACT_ADDRESS),
    );
	
	insert_matches($matches1);
	
	//TODO: disable claim button right away after the claim has been placed
?>		
		<h3 class="subtitle">Wednesday 13 February 2019</h3>
<?php
/*
    $matches2 = array(
        array(8,  "Club Brugge",      "Monaco",         "1-1", CONTRACT_ADDRESS),
        array(9,  "PSV",              "Tottenham",      "2-2", CONTRACT_ADDRESS),
        array(10, "Dortmund",         "Atlético",       "4-0", CONTRACT_ADDRESS),
        array(11, "Barcelona",        "Internazionale", "2-0", CONTRACT_ADDRESS),
        array(12, "Liverpool",        "Crvena zvezda",  "4-0", CONTRACT_ADDRESS),
        array(13, "Paris",            "Napoli",         "2-2", CONTRACT_ADDRESS),
        array(14, "Galatasaray",      "Schalke",        "0-0", CONTRACT_ADDRESS),
        array(15, "Lokomotiv Moskva", "Porto",          "1-3", CONTRACT_ADDRESS),
    );
    
    insert_finished_matches($matches2);
*/

    insert_matches($matches2);
?>
		<h3 class="subtitle">Tuesday 19 February 2019</h3>
<?php
    insert_matches($matches3);
?>
		<h3 class="subtitle">Wednesday 20 February 2019</h3>
<?php
    insert_matches($matches4);
?>
		<div class="modal" id="betDialog">
			<div class="modal-content">
				<div class="modal-header">
					<span class="close">×</span>
					<table>
						<tbody>
							<tr>
								<td><img class="flag" alt="Flag" id="bet_dialog_flag1" src="" /></td>
								<td class="dialog_header"><h2>vs.</h2></td>
								<td><img class="flag" alt="Flag" id="bet_dialog_flag2" src="" /></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="modal-body">
					<br />
					<table class="maxwidth">
						<tbody>
							<tr>
								<td>(1) Choose a winner:</td>
							</tr>
							<tr>
								<td>
									<input type="radio" name="result" id="radio1" value="1"> <span class="" id="bet_dialog_team1"></span><br />
									<input type="radio" name="result" id="radio2" value="2"> <span class="" id="bet_dialog_team2"></span><br />
									<input type="radio" name="result" id="radio0" value="0"> <span class="">No one, it is a draw</span><br />
									
								</td>
							</tr>
							<tr>
								<td class="put-ether">(2) Put your ether where your mouth is:</td>
							</tr>
							<tr>
								<td class="leftside"><input class="eth-value" type="number" step="0.01" min="0.01" name="value" placeholder="$ETH" value="0.04" id="bet_value"/></td>
							</tr>
							<tr>
								<td class="leftside"><button class="button" type="button" id="dialog_button">BET!</button></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<h5 style="display: none;">CURRENTLY, if <span id="dialog_team2"></span> wins your bet multiplies ×1.5</h5>
				</div>
			</div>
		</div>
		<div id="snackbar"></div>
		<script>
		// Get the modal
		var modal = document.getElementById('betDialog');

		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];

		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
			modal.style.display = "none";
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
		</script>
	</body>
</html>
