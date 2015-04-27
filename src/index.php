<?php
namespace ChrisAllen\TicTacToe;
date_default_timezone_set('America/Los_Angeles');

/*
 * Written By Chris Allen
* Contact:  	650-395-8594
* Email:		chris@chrisballen.com
*
* Application:	TicTacToe Game
*/

use ChrisAllen\TicTacToe\Controllers\BoardController;
use ChrisAllen\TicTacToe\Views\BaseView;
use ChrisAllen\TicTacToe\Views\BoardView;
use ChrisAllen\TicTacToe\Utilities\Result;

require_once __DIR__.'/../vendor/autoload.php';

session_start();
$action = isset($_GET["action"]) ? $_GET["action"] : "";

//methods for POST REQUESTS
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	//start a game
	if ($action=="startGame"){
		$playerId = @$_POST['playerId'];
		$controller = new BoardController($playerId, true);
		if($controller->isGameStarted()) {
			$result = new Result(true, "Game Started");
		} else {
			$result = new Result(false, "Game Failed Started");
		}
		
		print json_encode($result);
		exit(0);
	}
	
	//player makes a move
	if ($action=="move"){
		$playerId = @$_POST['playerId'];
		$moveId = @$_POST['moveId'];
		$controller = new BoardController($playerId);
		$result = $controller->move($playerId, $moveId);
		print json_encode($result);
		exit(0);
	}
}
//methods for GET REQUESTS
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	
	if ($action=="displayWinner"){
		$playerId = @$_GET['playerId'];
		$view = new BoardView();
		$view->displayPlayAgain();
		$view->displayWinner($playerId);
		exit(0);
	}
	if ($action=="displayTryAgain"){
		$view = new BoardView();
		$view->displayPlayAgain();
		exit(0);
	}
}
$view = new BoardView();
$view->display();
?>
  
