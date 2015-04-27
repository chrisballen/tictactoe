<?php
/*
 * Written By Chris Allen
* Contact:  	650-395-8594
* Email:		chris@chrisballen.com
*
* Application:	TicTacToe Game
*/
namespace ChrisAllen\TicTacToe\Views;

use ChrisAllen\TicTacToe\Views\BaseView;
use ChrisAllen\TicTacToe\Utilities\Script;
class BoardView extends BaseView{

    public function __construct() {
        parent::__construct ();
    }
    protected function setScripts($imports = array()){
    	
    	$script = new Script ();
    	$script->setSrc ( "js/board.js" );
    	$imports[] = $script;
    	
        parent::setScripts($imports);
    }
    public function display() {
        $this->startPage();
        $this->setHead();

        $this->startBody();
        $this->displayHeader();

        $this->startContainer();

        //page specific
        $this->startRow();
        $this->displayPlayerAvatars(1);
        $this->displayTicTacBoard();
        $this->displayPlayerAvatars(2);
        $this->endRow();
        
        $this->displayChooseWhoGoesFirst();
        $this->displayWinnerContainer();
		//$this->displayWinner(1);

        //$this->endContainer();
        //$this->displayFooter();
        $this->setScripts();
        $this->endBody();
        $this->endPage();
    }
    public function displayTicTacBoard($gameInProgress = null) {
    	if(empty($gameInProgress)) {
    		
    	}
?>
		<div class="col-md-6">
	  		<div class="board-container">
	  			<div id="game-board" data-id="" class="disabled">
	  				<ul>
	  					<li data-id="0" class="open top-row first"></li>
	  					<li data-id="1" class="open top-row "></li>
	  					<li data-id="2" class="open top-row last"></li>
	  					<li data-id="3" class="open first"></li>
	  					<li data-id="4" class="open "></li>
	  					<li data-id="5" class="open last"></li>
	  					<li data-id="6" class="open bottom-row first"></li>
	  					<li data-id="7" class="open bottom-row "></li>
	  					<li data-id="8" class="open bottom-row last"></li>  					
	  				</ul>
	  			
	  			</div>
	  		
	  		</div>
  		</div>
<?php 
    }
    
    public function displayPlayerAvatars($playerId) {
		$playerClass = ($playerId == 1) ? "player-one" : "player-two";
		$name = ($playerId == 1) ? "Player One" : "Player Two";
?>
		<div class="col-md-3">
			<div class="players-container disabled">
				<div class="monster <?= $playerClass ?>"></div>
				<div class="name"><?= $name ?></div>
				<div class="piece-identifier <?= $playerClass ?>"></div>
			</div>
		</div>
<?php 
	}
    public function displayChooseWhoGoesFirst() {
?>
		<div class="choose-first-move">
			<h5>Choose Who Goes First!</h5>
			<ul>
				<li class="player one" data-id="1"></li>
				<li class="player two" data-id="2"></li>
			</ul>
		</div>


<?php 
	}
    public function displayWinner($playerId) {
    	$playerName = ($playerId == "1") ? "Player 1" : "Player 2";
?>
	<div class="winner-container">
		<div class="balloons">
		    <div><span>W</span></div>
		    <div><span>I</span></div>
		    <div><span>N</span></div>
		    <div><span>N</span></div>
		    <div><span>N</span></div>
		    <div><span>E</span></div>
		    <div><span>R</span></div>
		    
		</div>	
		<div class="winner-name"><?= $playerName ?> Wins</div>
	</div>
	
<?php 
    }
    public function displayWinnerContainer() {
?>
	<div class="winner-loader"></div>
<?php 
	}
	public function displayPlayAgain() {
?>
		<div class="play-again">
			<h4>Play Again</h4>
		</div>
<?php 
	}
 
}
