pragma solidity ^0.4.23;

/* */
contract FootballMatch {
    
    event Bet  (address indexed from, uint indexed team, uint indexed value);
    event Claim(address indexed from, uint value);
    
    address private owner = msg.sender;
    
    mapping (address => mapping (uint => uint)) private bets;
    
    uint    private  totalAmount;
    uint    private  claimedAmount;
    uint[2] private  pools;
    uint    internal startTime;
    
    uint private winner;
    bool private isWinnerSet     = false;
    bool private ownerHasClaimed = false;
    
    uint constant private FEE_PERCENTAGE = 2;

	/* */
	modifier ownerOnly() {
	    require(msg.sender == owner);
	    _;
	}
	
	/* */
	modifier beforeStartTime() {
	    require(now < startTime);
	    _;
	}
	
	/* */
	modifier afterStartTime() {
	    require(now >= startTime);
	    _;
	}
	
	/* */
	modifier winnerSet() {
		require(isWinnerSet == true);
		_;
	}
		
	/* */
	function calculateFee(uint value) private pure returns (uint) {
	    return SafeMath.div(SafeMath.mul(value, FEE_PERCENTAGE), 100);
	}
	
	/* */
	function getOwnerPayout() private winnerSet ownerOnly returns (uint) {
	
		if (ownerHasClaimed) {
			return 0;
		}
		
		uint payout = 0;
		if (pools[winner] != 0) {
			// we have at least one bet on a winning team
			payout = calculateFee(totalAmount);
		} else {
			// we have no bets on a winning team
			payout = totalAmount;
		}
		
		ownerHasClaimed = true;
		return payout;
	}
	
	/* */
	function getNormalPayout() private winnerSet returns (uint) {
	
		uint bet = bets[msg.sender][winner];
		if (bet == 0) {
			return 0;
		}
    
        uint fee        = calculateFee(totalAmount);
        uint taxedTotal = SafeMath.sub(totalAmount, fee); 
        
        uint payout = SafeMath.div(SafeMath.mul(taxedTotal, bet), pools[winner]);
        
        bets[msg.sender][winner] = 0;
        return payout;
	}

	/* */    
    constructor() internal {
    }
    
	/* */
	function getTotalAmount() public view returns (uint) {
        return totalAmount;
    }
    
	/* */
	function getClaimedAmount() public ownerOnly view returns (uint) {
        return claimedAmount;
    }    
    
    /* */
    function setWinner(uint team) external afterStartTime ownerOnly {
    	require(team == 0 || team == 1);

        winner = team;
        isWinnerSet = true;
    }

	/* */
    function bet(uint team) external payable beforeStartTime {
        require(msg.value > 0);
        require(team == 0 || team == 1);
        
        totalAmount = SafeMath.add(totalAmount, msg.value);
        pools[team] = SafeMath.add(pools[team], msg.value);
        bets[msg.sender][team] = SafeMath.add(bets[msg.sender][team], msg.value);
        
        emit Bet(msg.sender, team, msg.value);
    }
    
    /* */
    function claim() external winnerSet {
    
    	uint payout = 0;
    	
    	if (msg.sender == owner) {
    		payout = getOwnerPayout(); 
    	}
    	
    	// owner can bet too
    	payout = SafeMath.add(payout, getNormalPayout());
    	require(payout > 0);
    	
    	claimedAmount = SafeMath.add(claimedAmount, payout);
        msg.sender.transfer(payout);
        
        emit Claim(msg.sender, payout);
    }    
}

/*****************************************************************************/

/* */
contract Test1 is FootballMatch {
	
	/* */
	constructor() public {
	    startTime = 1531251600;
	}
}

/* */
contract Test2 is FootballMatch {
	
	/* */
	constructor() public {
	    startTime = 1531251900;
	}
}

/* */
contract Test3 is FootballMatch {
	
	/* */
	constructor() public {
	    startTime = 1531252200;
	}
}

/* */
contract Test4 is FootballMatch {
	
	/* */
	constructor() public {
	    startTime = 1531252500;
	}
}

/* */
contract Test5 is FootballMatch {
	
	/* */
	constructor() public {
	    startTime = 1531252800;
	}
}

/* */
contract Test6 is FootballMatch {
	
	/* */
	constructor() public {
	    startTime = 1531253100;
	}
}

/* */
contract Test7 is FootballMatch {
	
	/* */
	constructor() public {
	    startTime = 1531253400;
	}
}

/* */
contract Semi1 is FootballMatch {
	
	/* */
	constructor() public {
	    startTime = 1531245600;
	}
}

/* */
contract Semi2 is FootballMatch {
	
	/* */
	constructor() public {
	    startTime = 1531332000;
	}
}

/* */
contract Third is FootballMatch {
	
	/* */
	constructor() public {
	    startTime = 1531576800;
	}
}

/* */
contract Final is FootballMatch {
	
	/* */
	constructor() public {
	    startTime = 1531666800;
	}
}

/*****************************************************************************/

/**
 * @title SafeMath
 * @dev Math operations with safety checks that throw on error
 */
library SafeMath {
    /**
     * @dev Multiplies two numbers, throws on overflow.
     */
    function mul(uint256 a, uint256 b) internal pure returns (uint256 c){
        // Gas optimization: this is cheaper than asserting 'a' not being zero, but the
        // benefit is lost if 'b' is also tested.
        // See: https://github.com/OpenZeppelin/openzeppelin-solidity/pull/522
        if (a == 0) {
            return 0;
        }
        c = a * b;
        assert(c / a == b);
        return c;
    }

    /**
     * @dev Integer division of two numbers, truncating the quotient.
     */
    function div(uint256 a, uint256 b) internal pure returns (uint256){
        // assert(b > 0); // Solidity automatically throws when dividing by 0
        // uint256 c = a / b;
        // assert(a == b * c + a % b); // There is no case in which this doesn't hold
        return a / b;
    }

    /**
     * @dev Subtracts two numbers, throws on overflow (i.e. if subtrahend is greater than minuend).
     */
    function sub(uint256 a, uint256 b) internal pure returns (uint256){
        assert(b <= a);
        return a - b;
    }

    /**
     * @dev Adds two numbers, throws on overflow.
     */
    function add(uint256 a, uint256 b) internal pure returns (uint256 c){
        c = a + b;
        assert(c >= a);
        return c;
    }
}


