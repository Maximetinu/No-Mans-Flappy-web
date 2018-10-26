<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://ogp.me/ns/fb#">

<head>
	<style>
		body{
			background-color: #161616 !important;
		}
	</style>
	<script type='text/javascript'>
		var Module = {
			TOTAL_MEMORY: 268435456,
			errorhandler: null,			// arguments: err, url, line. This function must return 'true' if the error is handled, otherwise 'false'
			compatibilitycheck: null,
			backgroundColor: "#161616",
			splashStyle: "Light",
			dataUrl: "game/Release.data",
			codeUrl: "game/Release.js",
			asmUrl: "game/Release.asm.js",
			memUrl: "game/Release.mem",
		};
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>No Man's Flappy</title>
	<meta name="author" content="Maximetinu" />
	<meta name="description" content="A game by Maximetinu" />
	<meta name="keywords"  content="game,unity,maximetinu,videogame,chat,mmo,nomansflappy" />
	<meta name="Resource-type" content="Document" />
	<meta property="og:image" content="http://nomansflappy.metinu.com/images/game-icon.png" />


	<link rel="stylesheet" type="text/css" href="css/jquery.fullPage.css" />
	<link rel="stylesheet" type="text/css" href="css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/modal.css" />
	<link rel="stylesheet" type="text/css" href="css/loader.css" />
	<link rel="stylesheet" type="text/css" href="css/ranking.css" />
	<link rel="stylesheet" type="text/css" href="css/tooltip.css" />
	<link rel="stylesheet" type="text/css" href="css/heart.css" media='all' />

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">

    <!--[if IE]>
        <script type="text/javascript">
             var console = { log: function() {} };
        </script>
        <![endif]-->

        <!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script-->
        <script type="text/javascript" src="js/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/jquery.fullPage.min.js"></script>
        <script type="text/javascript" src="js/ranking.js"></script>
        <script type="text/javascript" src="js/stuff.js"></script>
        <script type="text/javascript" src="js/load-game.js"></script>
        <script type="text/javascript">
        	$(document).ready(function() {
        		$('#fullpage').fullpage({
        			verticalCentered: true,
              			anchors: ['game', 'ranking', 'b-ranking', 'whatswhat','footer'],
		        	menu: '#menu',
		        	normalScrollElements: '.scrollable-element',
		        	navigation: true,
		        	navigationTooltips: ['Game', 'Ranking', 'B Ranking', 'What&#39;s what'],
		        	onLeave: function(index, nextIndex, direction){
			            	var leavingSection = $(this);

			            	//después de abandonar la sección 1
			            	if(nextIndex == 2){
			                	getRankingAjax();
			            	}
			            	if(nextIndex == 3){
			                	getBRankingAjax();
			            	}

			        }
          		});
        	$.fn.fullpage.setKeyboardScrolling(false);
        	});
	</script>
	<script type="text/javascript" src="js/modal.js"></script>
</head>
	<body>
	<div id="fullpage">
		<div class="section" id="section0">
			<div id="loader-wrapper">
    				<div id="loader"></div>
    				<span>By the way, this website uses cookies</span>
			</div>
			<div id="canvas-container" class="shadow-z-1">
				<canvas class="emscripten" id="canvas" oncontextmenu="event.preventDefault()"></canvas>
				<!--div id="load-animation" class="loading"></div-->
			</div>
			<a href="#ranking"><span></span></a>
		</div>
		<div class="section" id="section1">
			<?php
				require "php/ranking.php";
			?>
		</div>
		<div class="section" id="section2">
			<?php
				include "php/branking.php";
			?>
		</div>
		<div class="section" id="section3">
			<div class="circles-line">
				<div id="pvp" tooltip="In order to defeat someone in the ranking, just upload a score higher than his and then delete the game data from the settings menu to disable the entry on the ranking" flow="left" class="circle left shadow-z-1 "></div>
				<div id="pve" tooltip="There is a score that all of you must work together to reach, by adding up your highscores. After that, endgame content will be unlocked" flow="right" class="circle right shadow-z-1"></div>
			</div>
			<div class="circles-line">
				<div id="guilds" tooltip="There is a way to form a guild. All the guild members only have to use the same name while playing, which is the guild name. The one with the highest score will be the guild master. Only the master can delete the guild, by deleting his game data from the settings menu" flow="left" class="circle left shadow-z-1"></div>
				<div id="leagues" tooltip="Leagues are planned for 2020, as long as the endgame had been reached" flow="right" class="circle right shadow-z-1"></div>
			</div>
		</div>
		<div class="section fp-auto-height" id="section4">
			<div class="site-footer">
				<p class="site-logo"><!--a href="http://www.maximetinu.com/">No Man's Flappy</a--></p> 
				<!--p class="powered">Powered by Maximetinu</p-->
				<p class="site-credits">
					<span class="love">Handcrafted with <i class="icon ion-heart"></i> in Florence</span> 
					<span class="middot"> &middot; </span>
					<span class="site-links">
						<a onclick="openModal();" href="javascript:void(0)">Uncopyright</a>
						 · 
						<a id="contact" href="javascript:void(0)" onclick="showEmail();">Get in touch</a>
					 </span>
				 </p>
				<p class="social-links">
					<a href="http://www.facebook.com/maximetinu" target="_blank">Facebook</a>
					<span class="line"> — </span>
					<a href="http://twitter.com/maximetinu" target="_blank">Twitter</a>
					<span class="line"> — </span>
					<a href="http://lanaciondelcosmopolita.tumblr.com/" target="_blank">Tumblr</a>
				</p>
			</div>
		</div>
	</div>
	<div id="copyright-modal" class="modal">
		<div class=modal-top-bar>
			<h1>Uncopyright</h1>
		</div>
		<div class="modal-body">
			<p>“Life is really simple, but we insist on making it complicated.” — Confucius</p>
			<p>This website is Uncopyrighted. As its author, I am releasing all claims on copyright and have put the content here into the public domain. I’m simply making a statement by applying the <a class="enable-anchor" href="https://zenhabits.net/uncopyright/">uncopyright license</a> to this entire project.</p>
			<p>I want to demonstrate my desire to live an intentional and authentic life. Consider this project an open book, and my way of paying it forward.</p>
			<p>No permission is needed to copy, distribute, or modify any content on this game or site. Credit is appreciated but not required. Do what feels right, but don’t do anything out of obligation. It’s all good.</p>
			<p>So if you like anything you see, be creative and make something awesome.</p>
			<p class="github-links">
				<a class="enable-anchor" target="_blank" href="https://github.com/Maximetinu/No-Mans-Flappy-Unity">game repo</a>
				<span class="line"> — </span>
				<a class="enable-anchor" target="_blank" href="https://github.com/Maximetinu/No-Mans-Flappy-web">website repo</a>
			</p>
			<p>— Metinu</p>
		</div>
		<div class= modal-bottom-bar>
			<div id="close-modal" onclick="closeModal();" class="button clickable">
				<input class="toggle" type="checkbox"/>
				<div class="anim"></div><span>I get it</span>
			</div>
		</div>
	</div>
	</body>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', '*** GOOGLE ANALYTICS UA***', 'auto');
	  ga('send', 'pageview');

	</script>
</html>