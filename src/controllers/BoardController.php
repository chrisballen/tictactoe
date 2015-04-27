<?php
/*
* Written By Chris Allen
* Contact:  	650-395-8594
* Email:		chris@chrisballen.com
*
* Application:	TicTacToe Game
*/
namespace ChrisAllen\TicTacToe\Controllers;
use ChrisAllen\TicTacToe\Models\TicTacToe as Game;
use ChrisAllen\TicTacToe\Utilities\Result;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class BoardController {
	private $ticTacToe = null;
	private $log;
	public function __construct($firstMove = null, $startGame = false ) {
		if($startGame) {
			$this->startGame($firstMove);
		} else {
			if(isset($_SESSION['TicTacToeGame'])) {
				$this->ticTacToe = $_SESSION['TicTacToeGame']; //resume game
			} else {
				$this->startGame($firstMove);
			}
		}
		$logFile = 'error.log';
		$logLevel = "ERROR";
		$this->log = new Logger(get_class($this));
		$this->log->pushHandler(new StreamHandler($logFile, $logLevel));		
	}
	private function startGame($firstMove) {
		$this->ticTacToe = new Game($firstMove);
		$_SESSION['TicTacToeGame'] = $this->ticTacToe; //start game
	}
	public function endGame() {
		foreach($_SESSION as $sessionKey => $sessionValue) {
			session_unset($_SESSION[$sessionKey]);
		}
		$this->ticTacToe = null;
	}
	/*
	 * Method that performs a move for a player
	* Returns:  Result Object with parameters:
	* success - true/false
	* message - message explaining the result
	* data - the data pertaining to the result such as playerId, move id, and whos turn it is
	*/
	public function move($playerId, $move) {
		$moveResult = $this->ticTacToe->move($playerId, $move);
		
		if(!$moveResult->success) {
			$this->log->addERROR("Move Failed " .print_r($moveResult, true));
			return $moveResult;
		} else {
			$result = new Result(true, "Move Successful", array());
			//check to see if the player is a winner
			$checkWinner = $this->ticTacToe->checkIfWinner($playerId);
			//check to see if there are any more moves to be made
			$availableMove = $this->ticTacToe->availableMoves();
			
			if($checkWinner) {
				$result->data["winner"] = array("status"=>true,"player"=>$this->ticTacToe->getWinner(), "combo"=>$this->ticTacToe->getWinningCombo());
				$this->endGame();
			} else {
				$result->data["winner"] = array("status"=>false,"player"=>"");
			}
			if($availableMove) {
				$result->data["canMove"] = array("status"=>true,"playerTurn"=>$moveResult->data['currentTurn']);
			} else {
				$this->endGame();
				$result->data["canMove"] = array("status"=>false,"playerTurn"=>"");
			}
			return $result;
		}
	}
	public function isGameStarted(){
		if($this->ticTacToe == null) {
			return false;
		} else {
			return true;
		}
	}
	public function isEndOfGame(){
		if($this->ticTacToe != null) {
			return false;
		} else {
			return true;
		}
	}
}