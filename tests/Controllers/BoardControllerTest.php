<?php
/*
* Written By Chris Allen
* Contact:  	650-395-8594
* Email:		chris@chrisballen.com
*
* Application:	TicTacToe Game
*/
namespace ChrisAllen\TicTacToe\Controllers;

use ChrisAllen\TicTacToe\Controllers\BoardController;

class TicTacToeTest extends \PHPUnit_Framework_TestCase {
    protected function setUp() {

    }
    public function testIsGameStarted() {
    	$playerOne = 1;
    	$playerTwo = 2;
    	$controller = new BoardController($playerOne, true);
    	
    	//check to see if game started
    	$response = $controller->isGameStarted();
    	$this->assertEquals(true, $response);
    }
    public function testMove() {
    	$playerOne = 1;
    	$playerTwo = 2;
    	$controller = new BoardController($playerOne, true);
    	 
    	//check to see if player two can make a move.  He should not.
    	$response = $controller->move($playerTwo, 2);
    	$this->assertEquals(false, $response->success);
    	
    	//check to see if player One can make a move to a position that doesn't exist.  He should not.
    	$response = $controller->move($playerOne, 9);
    	$this->assertEquals(false, $response->success);
    	
    	//check to see if player One can make a move to a position that doesn't exist.  He should not.
    	$response = $controller->move($playerOne, -5);
    	$this->assertEquals(false, $response->success);
    	
    	//check to see if player One can make a move
    	$response = $controller->move($playerOne, 3);
    	$this->assertEquals(true, $response->success);
    	
    	//check to see if a winner has been determined.  should be false
    	$this->assertEquals(false, $response->data['winner']['status']);
    	//check to see if we can still move.  should be true
    	$this->assertEquals(true, $response->data['canMove']['status']);
    	
    	//check to see if the next person to move is player two
    	$this->assertEquals($playerTwo, $response->data['canMove']['playerTurn']);
    	 
    	//check to see if player Two can make the same move.  He should not.
    	$response = $controller->move($playerTwo, 3);
    	$this->assertEquals(false, $response->success);


    	//setup game board
    	$controller->move($playerTwo, 4);
    	$controller->move($playerOne, 0);
    	$controller->move($playerTwo, 5);
    	$response = $controller->move($playerOne, 6);
    	
    	//check to see if player one wins
    	$this->assertEquals(true, $response->data['winner']['status']);
    	$this->assertEquals($playerOne, $response->data['winner']['player']);
    }
}