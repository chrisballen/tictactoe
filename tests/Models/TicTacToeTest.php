<?php
/*
* Written By Chris Allen
* Contact:  	650-395-8594
* Email:		chris@chrisballen.com
* 
* Application:	TicTacToe Game
*/
namespace ChrisAllen\TicTacToe\Models;

class TicTacToeTest extends \PHPUnit_Framework_TestCase {
    protected function setUp() {

    }
    public function testMakingMoves() {
    	$playerOne = 1;
    	$playerTwo = 2;
    	$game = new TicTacToe($playerOne);
    	
    	//check to see if player two can make a move.  He should not.
    	$response = $game->move($playerTwo, 2);
    	$this->assertEquals(false, $response->success);
    	
    	//check to see if player One can make a move to a position that doesn't exist.  He should not.
    	$response = $game->move($playerOne, 9);
    	$this->assertEquals(false, $response->success);
    	
    	//check to see if player One can make a move to a position that doesn't exist.  He should not.
    	$response = $game->move($playerOne, -5);
    	$this->assertEquals(false, $response->success);
    	
    	//check to see if player One can make a move to a position that doesn't exist.  He should be able to
    	$response = $game->move($playerOne, 3);
    	$this->assertEquals(true, $response->success);
    	
    	//check to see if player Two can make the same move.  He should not.
    	$response = $game->move($playerTwo, 3);
    	$this->assertEquals(false, $response->success);
    }
    public function testWinningMoves() {
    	$playerOne = 1;
    	$playerTwo = 2;
    	$game = new TicTacToe($playerTwo);
    	 
    	//setup game board
    	$game->move($playerTwo, 1);
    	$game->move($playerOne, 6);
    	$game->move($playerTwo, 4);
    	$game->move($playerOne, 3);
    	$game->move($playerTwo, 7);
    	
    	//check to see if winner. Player one should not be a winner
    	$response = $game->checkIfWinner($playerOne);
    	$this->assertEquals(false, $response);
    	
    	//check to see if winner. Player two should be a winner
    	$response = $game->checkIfWinner($playerTwo);
    	$this->assertEquals(true, $response);
    	
    	$game = new TicTacToe($playerOne);
    	
    	//setup game board
    	$game->move($playerOne, 2);
    	$game->move($playerTwo, 4);
    	$game->move($playerOne, 5);
    	$game->move($playerTwo, 0);
    	$game->move($playerOne, 8);
    	 
    	//check to see if winner. Player two should not be a winner
    	$response = $game->checkIfWinner($playerTwo);
    	$this->assertEquals(false, $response);
    	 
    	//check to see if winner. Player one should be a winner
    	$response = $game->checkIfWinner($playerOne);
    	$this->assertEquals(true, $response);
    }
    public function testAvailableMoves() {
    	$playerOne = 1;
    	$playerTwo = 2;
    	$game = new TicTacToe($playerTwo);
    
    	//setup game board
    	$game->move($playerTwo, 0);
    	$game->move($playerOne, 1);
    	$game->move($playerTwo, 2);
    	$game->move($playerOne, 4);
    	$game->move($playerTwo, 3);
    	$game->move($playerOne, 5);
    	$game->move($playerTwo, 7);
    	$game->move($playerOne, 6);
    
    	//check to see if there is still a move available
    	$response = $game->availableMoves();
    	$this->assertEquals(true, $response);
    	
    	$game->move($playerTwo, 8);
    	//check to see if there is still a move available
    	$response = $game->availableMoves();
    	$this->assertEquals(false, $response);
    	

    }
}