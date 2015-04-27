/*
* Written By Chris Allen
* Contact:  	650-395-8594
* Email:		chris@chrisballen.com
*
* Application:	TicTacToe Game
*/

$(function() {
	GameBoard.init();
});

var GameBoard = {
    currentTurn: null,
    init: function() {
    	GameBoard.startGameListener();
    	GameBoard.playAgainListener();
    },
    startGameListener: function() {
    	$(".choose-first-move .player").on("click", function() {
    		var el = $(this);
    		var playerId = el.attr('data-id');
    		var playerClass = GameBoard.determinePlayerCssClass(playerId);
    		$('.players-container').removeClass('disabled');
    		el.closest(".choose-first-move").fadeOut('fast');
    		$("#game-board").addClass(playerClass);
    		$("#game-board").addClass("active");
    		$("#game-board").removeClass("disabled");
    		GameBoard.currentTurn = playerId;
    		
    		GameBoard.disable();
    		var data = "playerId="+GameBoard.currentTurn;
    		$.ajax({
                type: "POST",
                url: "index.php?action=startGame",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                    	GameBoard.enable();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("<p>Status:  "+textStatus + "<br>Error Thrown: "+errorThrown+"</p>"); 
                }
            });
    		GameBoard.moveListener();
    	});
    },
    moveListener: function() {
    	$("#game-board").on("click","li",function() {
    		if($(this).hasClass('taken') || $(this).closest("#game-board").hasClass('disabled')) {
    			return false;
    		}
    		
    		var el = $(this);
    		var moveId = $(this).attr('data-id');
    		var playerId = GameBoard.currentTurn;
    		GameBoard.move(el, playerId, moveId);		
			
    	});
    },
    move: function(el, playerId, moveId) {
    	GameBoard.disable();
		el.addClass('taken');
		el.removeClass('open');
		var playerClass = GameBoard.determinePlayerCssClass(playerId);
		el.addClass(playerClass);
		GameBoard.disable();
		var data = "playerId="+GameBoard.currentTurn+"&moveId="+moveId;
		$.ajax({
            type: "POST",
            url: "index.php?action=move",
            data: data,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                	if(response.data.winner.status){
                		GameBoard.displayWinner(response.data.winner.player);
                		GameBoard.showWinningMoves(response.data.winner.combo);
                	}else if(!response.data.canMove.status){
                		GameBoard.displayTryAgain();
                	} else {
                		GameBoard.switchTurn();
                	}
                } else {
                	GameBoard.disable();
                	alert(response);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("<p>Status:  "+textStatus + "<br>Error Thrown: "+errorThrown+"</p>"); 
            }
        });
		
    },
    switchTurn: function() {
    	var el = $("#game-board");
    	var playerId = GameBoard.currentTurn;
    	if(playerId == 1) {
    		GameBoard.currentTurn = 2;
    		el.removeClass("player-one");
    		el.addClass("player-two");
    	} else {
    		GameBoard.currentTurn = 1;
    		el.addClass("player-one");
    		el.removeClass("player-two");
    	}
    	GameBoard.enable();
    },
    enable: function() {
		$("#game-board").addClass("active");
		$("#game-board").removeClass("disabled");
    },
    disable: function() {
    	$("#game-board").addClass("disabled");
    	$("#game-board").removeClass("active");
		
    },
    reset: function() {
    	$(this).closest('.winner-loader').html("");
		$('.winner-loader').fadeOut();
		$(".choose-first-move").fadeIn();
		GameBoard.disable();
		$("#game-board").removeClass('player-one');
		$("#game-board").removeClass('player-two');
		GameBoard.currentTurn = null;
		$(".players-container").addClass("disabled");
		$("#game-board").find("li").each(function() {
			$(this).addClass('open');
			$(this).removeClass('taken');
			$(this).removeClass('player-one');
			$(this).removeClass('player-two');
			$(this).removeClass('winner');
		});
    	
    },
    determinePlayerCssClass: function(playerId) {
    	var playerClass = (playerId == 1) ? "player-one" : "player-two";
    	return playerClass;
    },
    playAgainListener: function() {
    	$(".container").on("click",".play-again h4",function() {
    		GameBoard.reset();
    	});
    },
    displayWinner: function(playerId) {
    	$.ajax({
            type: "GET",
            url: "index.php?action=displayWinner&playerId="+playerId,
            dataType: "html",
            success: function(response) {
            	$(".winner-loader").html(response);
            	$(".winner-loader").fadeIn();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("<p>Status:  "+textStatus + "<br>Error Thrown: "+errorThrown+"</p>"); 
            }
        });
    },
    showWinningMoves: function(combo) {
    	for(var i = 0; i < combo.length; i++) {
    		$("#game-board li[data-id='"+combo[i]+"']").addClass('winner');
    	}
    },
    displayTryAgain: function() {
    	$.ajax({
            type: "GET",
            url: "index.php?action=displayTryAgain",
            dataType: "html",
            success: function(response) {
            	$(".winner-loader").html(response);
            	$(".winner-loader").fadeIn();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("<p>Status:  "+textStatus + "<br>Error Thrown: "+errorThrown+"</p>"); 
            }
        });
    }
};
