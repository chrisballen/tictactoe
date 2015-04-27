<?php
/*
 * Written By Chris Allen
* Contact:  	650-395-8594
* Email:		chris@chrisballen.com
*
* Application:	TicTacToe Game
*/
namespace ChrisAllen\TicTacToe\Models;

use ChrisAllen\TicTacToe\Utilities\Result;

class TicTacToe {
	private $playerOne;
	private $playerTwo;
	private $currentTurn;	
	private $winner;
	private $winnerCombo;
	private $board = array(
		"","","","","","","","",""
	);
	private $winningCombinations = array(
		array(0,1,2),
		array(0,3,6),
		array(0,4,8),
		array(1,4,7),
		array(2,4,6),
		array(2,5,8),
		array(3,4,5),
		array(6,7,8)
	);

	public function __construct($firstTurn = 1) {
		$this->playerOne = 1;
		$this->playerTwo = 2;
		$this->setCurrentTurn($firstTurn);
	}
	private function setWinner($playerId, $combo) {
		$this->winner = $playerId;
		$this->winnerCombo = $combo;
	}
	protected function setCurrentTurn($id) {
		$this->currentTurn = $id;
	}
	public function getCurrentTurn() {
		return $this->currentTurn;
	}
	protected function switchTurns() {
		$playerId = ($this->currentTurn == 1) ? 2 : 1;
		$this->setCurrentTurn($playerId);
	}
	/*
	 * Method that performs a move for a player
	 * Returns:  Result Object with parameters:
	 * success - true/false
	 * message - message explaining the result
	 * data - the data pertaining to the result such as playerId, move id, and whos turn it is
	 */
	public function move($playerId, $move) {
		
		//moves allowed are positions 0-8
		if($move > 8 || $move < 0) {
			return new Result(false, "Must be a valid move", array("player id"=>$playerId,"move id"=>$move));
		}
		//check to see if move has already been made
		if (!empty($this->board[$move])) {
			return new Result(false, "Move has already been completed", array("player id"=>$playerId,"move id"=>$move));
		}
		//check to see if it is the player's turn
		if ($playerId != $this->currentTurn) {
			return new Result(false, "It is not your turn", array("player id"=>$playerId,"move id"=>$move));
		}
		
		$this->board[$move] = $playerId;
		$this->switchTurns();
		return new Result(true, "Move Successful", array("playerId"=>$playerId,"moveId"=>$move, "currentTurn"=>$this->currentTurn));
	}
	
	public function checkIfWinner($playerId) {
		$playerMoves = array();
		//build player's moves into array
		foreach ($this->board as $key=>$value) {
			if($playerId == $value) {
				$playerMoves[] = $key;
			}
		}
		//check to see if player's moves match any winning combinations
		foreach ($this->winningCombinations as $combo) {
			$countInArray = array_intersect($combo, $playerMoves);
			if(count($countInArray) == 3) {
				$this->setWinner($playerId, $combo);
				return true;
			}
		}
		return false;
	}
	public function getWinner() {
		return $this->winner;
	}
	public function getWinningCombo() {
		return $this->winnerCombo;
	}
	public function availableMoves() {
		foreach ($this->board as $move) {
			if($move == "") return true;
		}
		return false;
	}

}