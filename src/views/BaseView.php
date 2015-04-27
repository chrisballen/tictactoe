<?php
/*
* Written By Chris Allen
* Contact:  	650-395-8594
* Email:		chris@chrisballen.com
*
* Application:	TicTacToe Game
*/
namespace ChrisAllen\TicTacToe\Views;

use ChrisAllen\TicTacToe\Utilities\Script;
use ChrisAllen\TicTacToe\Utilities\Style;

class BaseView {
		
    public function __construct(){
        
    }
    protected function setHead($imports = array()){
    ?>
        <!-- Meta -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Tic Tac Toe Game - By Chris Allen</title>
        <!--  <link rel="shortcut icon" href="images/favicon.png">
        <link rel="apple-touch-icon" href="images/favicon.png"/> -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">

		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		
		<link href='//fonts.googleapis.com/css?family=Open+Sans:700,600,400' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Luckiest+Guy' rel='stylesheet' type='text/css'>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <?php
    }
    protected  function startContainer() {
        echo '<div class="container">';
    }
    protected  function endContainer() {
        echo '</div>';
    }
    protected function startRow() {
		echo '<div class="row">';
	}
	protected function endRow() {
		echo '</div>';
	}
    public function display(){ }
    protected function setScripts($viewImports = array()) {
        // jQuery
        $script = new Script ();
        $script->setSrc ( "//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js" );
        $imports[] = $script;


        foreach($viewImports as $obj){
            $imports[] = $obj;
        }
        foreach($imports as $obj){
            echo $obj;
        }
    }

    protected function displayHeader() {

    ?>
	<div class="header-container">
		<div class="row">
			<div class="col-md-12">
				<div class="title-container">
					<h1 class="title-font">Tic Tac Toe</h1>
					<h3>By Chris Allen</h3>
				</div>
			</div>
		</div>
	</div>
    <?php
    }
    protected function startPage(){
    	$html = "<!DOCTYPE HTML>";
    	$html .= "<html itemscope itemtype=\"http://schema.org/blog\">";
    	echo $html;
    }
    
    protected function endPage(){
    	echo "</html>";
    }
    protected function startBody($class = null){
    	if($class <> null) echo '<body class="content '.$class.'">';
    	else echo '<body class="content">';
    }
    protected function endBody(){
    	echo '</body>';
    }
}
