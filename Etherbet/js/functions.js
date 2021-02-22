/**
 * 
 * @param countDownDate
 * @param suffix
 * @returns
 */
function setCountdownTimer(countDownDate, suffix) {
	
	var now    = new Date().getTime();
	var offset = new Date().getTimezoneOffset() * 60000;

    // Find the distance between now an the count down date
    var distance = countDownDate - now - offset;
    
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
	var counterId = "counter" + suffix;
	if (days < 1) {
		document.getElementById(counterId).parentElement.style.color = "red"
	}
    
    if (distance > 0) {

    	document.getElementById(counterId).innerHTML = 
    		days + "d " + hours + "h " + minutes + "m";
    	
    	setTimeout(
			setCountdownTimer.bind(null, countDownDate, suffix), 
			1000 * 60
		);
    } else {
    	
    	document.getElementById(counterId).innerHTML = "CLOSED!";
		var button = document.getElementById("button" + suffix);
		button.style.display = "none";
		
		var inProgress = document.getElementById("in_progress" + suffix);
		inProgress.style.display = "table-cell";
    }
}

/**
 * 
 * @param buttonId
 * @param contractInstance
 * @param matchID
 * @returns
 */
function setClaimButtonListener(buttonId, contractInstance, matchID) {
	
	document.getElementById(buttonId).onclick = function() {
		
		if (contractInstance == null) {
			alert("In order to claim a bet you need Metamask plugin!");
			return;
		}
		
		if (web3.eth.defaultAccount == null) {
			alert("In order to claim a bet you need to be logged into your Metamask account!");
			return;
		}
		
		contractInstance.claim(matchID, {
			gas: 300000
		}, (error, transaction) => {
			
			if (error != null) {
				alert("Something went wrong!\n\nPerhaps the transaction was underpaid or you canceled it?\nPlease try again.");
			}
			if (transaction != null) {
				
				showSnackbar("Claim placed ...");

				var event = contractInstance.Claim({ 
					from: web3.eth.accounts[0]
				});
				
				event.watch((error, result) => {
					if (error == null) {
						showSnackbar("Claim accepted!");
					} else {
						showSnackbar("Claim rejected!");
					}
					
					event.stopWatching();
				});
			}
		});		
	}	
}

/**
 * 
 * @returns
 */
function getSelectedTeamID() {
	
	var teamID = -1;
	
	if (document.getElementById("radio1").checked) {
		teamID = 1;
	} else if (document.getElementById("radio2").checked) {
		teamID = 2;
	} else if (document.getElementById("radio0").checked) {
		teamID = 0;
	}
	
	return teamID;
}

/**
 * 
 * @param contractInstance
 * @param matchID
 * @param totalPoolID
 * @returns
 */
function setBetButtonListener(contractInstance, matchID, totalPoolID) {

	document.getElementById("dialog_button").onclick = function() {
		
		var value  = Number(document.getElementById("bet_value").value);
		var teamID = getSelectedTeamID(); 
		
		if (contractInstance == null) {
			alert("In order to place a bet you need Metamask plugin!");
		} else if (teamID < 0) {
			alert("Select a winner first!");
			return;
		} else if (isNaN(value) || value <= 0) {
			alert("Betting amount has to be greater than zero!");
			return;
		} else if(web3.eth.accounts[0] == null) {
			alert("It looks like you are not logged into your Metamask account. Please log in and then try again.");
		} else {
			var wei = web3.toWei(value, 'ether');
			contractInstance.bet(matchID, teamID, {
				gas:   300000,
				from:  web3.eth.accounts[0],
				value: wei
			}, (error, transaction) => {
				if (error != null) {
					alert("Something went wrong!\n\nPerhaps the transaction was underpaid or you canceled it?\nPlease try again.");
				}
				if (transaction != null) {
					
					showSnackbar("Bet placed ...");
					
					var event = contractInstance.Bet({ 
						from: web3.eth.accounts[0],
						team: matchID,
						value: wei
					});
					
					event.watch((error, result) => {
						
						if (error == null) {
							showSnackbar("Bet accepted!");
							updateTotalPool(contractInstance, matchID, totalPoolID);
						} else {
							showSnackbar("Bet rejected!");
						}
						
						event.stopWatching();
					});
				}
			});
		}
		
		modal.style.display = "none";
	}	
}

/**
 * 
 * @param elementID
 * @param imgSrc
 * @returns
 */
function showFlag(elementID, imgSrc) {
	
	if (imgSrc != null) {
		document.getElementById(elementID).style.display = "initial";
		document.getElementById(elementID).src = imgSrc;
	} else {
		document.getElementById(elementID).style.display = "none";
	}
}

/**
 * 
 * @param buttonId
 * @param imgSrc
 * @param teamName
 * @param contractInstance
 * @param matchID
 * @param totalPoolID
 * @returns
 */
function setWinButtonListener(
	buttonId, 
	imgSrc1, teamName1,
	imgSrc2, teamName2, 
	contractInstance, matchID, totalPoolID) {
	
	document.getElementById(buttonId).onclick = function() {
		
		showFlag("bet_dialog_flag1", imgSrc1);
		showFlag("bet_dialog_flag2", imgSrc2);
		
		document.getElementById("bet_dialog_team1").textContent = teamName1;
		document.getElementById("bet_dialog_team2").textContent = teamName2;
		
		document.getElementById("radio1").checked = false;
		document.getElementById("radio2").checked = false;
		document.getElementById("radio0").checked = false;
			
		modal.style.display = "block";
		setBetButtonListener(contractInstance, matchID, totalPoolID);
	}
}

/**
 * 
 * @param contractInstance
 * @param matchID
 * @param totalPoolID
 * @returns
 */
function updateTotalPool(contractInstance, matchID, totalPoolID) {
	
	contractInstance.getTotalAmount(matchID, (err, result) => {
		if (result == null) {
			return;
		}

		var element = document.getElementById(totalPoolID);
		if (result == 0) {
			element.textContent = 0;
		} else {
			element.textContent = 
				parseFloat(web3.fromWei(result, "ether")).toFixed(4); 
		}
	});	
}

/**
 * 
 * @param contractInstance
 * @param matchID
 * @param suffix
 * @returns
 */
function updateClaimStatus(contractInstance, matchID, suffix) {
	
	// TODO: optimize and do not call it twice
	contractInstance.getTotalAmount(matchID, (err, totalAmount) => {
		if (totalAmount == null) {
			return;
		}
		
		contractInstance.getClaimedAmount(matchID, (err, claimedAmount) => {
			if (claimedAmount == null) {
				return;
		    }
			
			if (Number(totalAmount) == Number(claimedAmount)) {
				
				var button = document.getElementById("button" + suffix);
				button.style.display = "none";
				
				var inProgress = document.getElementById("all_claimed" + suffix);
				inProgress.style.display = "table-cell";				
			}
		});
	});		
}

/**
 * 
 * @param message
 * @returns
 */
function showSnackbar(message) {
	
    var x = document.getElementById("snackbar");
    x.className = "show";
    x.textContent = message;
    setTimeout(function() { 
    	x.className = x.className.replace("show", ""); 
    }, 3000);	
}

