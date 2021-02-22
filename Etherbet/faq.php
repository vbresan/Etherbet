<?php

include "./php/contract.php";

/**
 * 
 */
function get_contract_url() {
   
    if (isset($_GET["test"])) {
        return "https://ropsten.etherscan.io/address/" . CONTRACT_ADDRESS;
    } else {
        return "https://etherscan.io/address/" . CONTRACT_ADDRESS;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Etherbet - FAQ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <h1>Etherbet - FAQ</h1>
    
    <h2>Getting Started / How to play</h2>
    
    <h3>What do I need to play Etherbet?</h3>
	<ul>
		<li>A computer/laptop with Tor browser (obviously!)</li>
        <li>MetaMask (<a href="#metamask">what is metamask?</a>)</li>
        <li>Ether, a crypto currency</li>
	</ul>
    
    <h3 id="metamask">What is Metamask and how do I install it?</h3>
    <p>
    	Metamask is a digital wallet that allows you to send ETH. You can 
    	install it from <a href="https://addons.mozilla.org/en-US/firefox/addon/ether-metamask/" target="_blank">here</a>. 
    </p>
    
    <h3>Which currencies can I use to bet?</h3>
    <p>
    	The only way to make a bet is with Ether. You can buy ETH on the local 
    	exchange of your country or in Metamask if you are an U.S Citizen. 
    	Once you bought the ETH from the exchange you have to send it to your 
    	Metamask address.
    </p>

	<h2>The Game</h2>

    <h3>What is Etherbet?</h3>
    <p>Etherbet is an online betting site based on the Ethereum Blockchain.</p>
        
    <h3>How it works?</h3>
    <p>
    	You find a match that you would like to bet on and place your bet on a
    	winning team (or on a draw). You claim your prize once the match is 
    	played and result is known. 
    </p>
        
    <h3>How can I make a bet?</h3>
    <p>
    	Log in to your Metamask account, choose the match you are going to bet 
    	for, set the amount of your bet and click the "Bet!" button and you 
    	are done, your bet will be mined in the ethereum blockchain.
    </p>
    
    <h3>Can I make more than one bet?</h3>
    <p>
    	Yes, you can make multiple bets and you can also bet on different 
        matches, there is no limit.
    </p>
        
    <h3>Where can I see my bets?</h3>
    <p>
    	So far only in your Metamask account.
    </p>
        
    <h3>How do I know if I win?</h3>
    <p>
    	Check the news.
    </p>
        
    <h3>How is the prize distributed?</h3>
    <p>
    	The prize pool will be splitted between the ones that make a bet for 
    	the winning result. The contract will divide the prize between the 
    	winners in proportion to their bets.
    </p>
    
    <h3>How do I claim my prize?</h3>
    <p>
    	After the match finishes and the result is known, if you won you will 
    	have to claim your prize pressing the "Claim" button under the selected
    	match.
    </p>

	<h2>Other</h2>

    <h3>Can I play on a mobile device?</h3>
    <p>
    	If your device supports Tor browser and Metamask addon - than you can.
    </p>
        
    <h3>Where is the smart contract?</h3>
    <p>
    	The smart contract is deployed on ethereum's main blockchain, the 
    	contract address is: <?= CONTRACT_ADDRESS ?>. 
    	In Etherscan you can see the contract details, movements and 
    	transactions here: <a href="<?= get_contract_url() ?>" target="_blank">Etherscan</a>.
    </p>
        
    <h3>Fine, but where is the contract sourcecode?</h3>
    <p>
    	You can find our smart contract source code <a href="<?= get_contract_url() ?>#code" target="_blank">here</a>.
    </p>
        
    <h3>Is there any fees in the bets?</h3>
    <p>
    	<b>At the moment Etherbet takes promotional fee of 2% of the total 
    	prize.</b> Remember each bet needs to be mined, that means you pay a 
    	very low ammount of ether on GAS. <a href="http://ethdocs.org/en/latest/contracts-and-transactions/account-types-gas-and-transactions.html">Learn more about gas</a>.
    </p>
        
    <h3>Is there a Etherbet token/coin?</h3>
    <p>
    	No, there is no need for a useless token. Bets are placed in ether and 
    	using ethereum's blockchain.
    </p>
    
</body>
</html>