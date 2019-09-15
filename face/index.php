<?php header('Access-Control-Allow-Origin: *');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<title>chat</title>
<link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">

<script src="https://kit.fontawesome.com/d0c14497d0.js"></script>
</head>

<body>

<style>
*{

font-family: 'Oswald', sans-serif;
}
.content {
    position: relative;
}

.chat-window button:focus {
	-webkit-tap-highlight-color: rgba(255,255,255,0);
	-webkit-tap-highlight-color: transparent;
	outline: none;
}

.chat-window {
	width: 280px;
	margin: 0 auto;
	overflow: hidden;
	border: 4px solid #000066;
	color: #474c57;
	border-radius: 20px;

}



.chat-window a {
	color: #000066;
}

.chat-window a:hover,
.chat-window a:focus {
	color: #003399;
}

.chat-messages {
	height: 350px;
	overflow-x: hidden;
	overflow-y: auto;
	width: 100%;
	position: relative;
	border-radius: 2px 2px 0 0;
	background: #fff;
}

.chat-messages-list {
	list-style-type: none;
	padding: 0;
	margin: 0;
	width: 100%;
	padding: 20px 0 20px 0;
}

.chat-message {
	position: relative;
	font-size: 0;
	margin-bottom: 10px;	
    width: 90%;
    margin: 10px 5% 10px 5%;
}

.chat-message-effect {
	position: absolute;
}

.chat-message-bubble {
	display: inline-block;
	font-size: 14px;
	max-width: 350px;
	background: #E6E8F4;
	padding: 8px 14px;
	border-radius: 8px;
	min-width: 0;
}

.chat-message-self.chat-message-merge-start .chat-message-bubble {
	border-bottom-right-radius: 0;
}

.chat-message-self.chat-message-merge-middle .chat-message-bubble {
	border-top-right-radius: 0;
	border-bottom-right-radius: 0;
}

.chat-message-self.chat-message-merge-end .chat-message-bubble {
	border-top-right-radius: 0;
}

.chat-message-self {
	text-align: right;
}

.chat-message-self .chat-message-bubble,
.chat-message-effect .chat-message-bubble { 
	background: #e8e8e8;
	text-align: left;
}

.chat-input-bar {
	position: relative;
	background:#200348;
}

.chat-input-wrapper {
	position: relative;
	z-index: 2;
	background: #200348;
	padding: 0.5em 0;
	border-radius: 0 0 2px 2px;
	color: #fff;
}

.chat-input-wrapper,
.chat-send {
	display: -webkit-flex;
	display: -ms-flexbox;
	display: flex;
	-webkit-flex-wrap: wrap;
	-ms-flex-wrap: wrap;
	flex-wrap: wrap;
	-webkit-justify-content: center;
	justify-content: center;
	font-size: 16px;
}

.chat-input-tool {
	background: transparent;
	border: none;
	padding: 0 0.75em;
	color: inherit;
}

.chat-input {
	outline: none;
	resize: none;
	overflow: hidden;
	min-height: 38px;
	-webkit-flex: 1;
	flex: 1;
	font-size: 14px;
	padding: 10px 0 7px;
	cursor: text;
	
    width: 250px;
    margin: 0 0 0 20px;
	
    border: 1px solid rgba(167, 214, 239, 0.5);
    border-radius: 6px;
}

.chat-input:empty::before {
	content: "Start typing...";
	color: #ececec;
}

.chat-input:focus::before {
	content: "";
}

.chat-send {
	background: transparent;
	border: none;
	position: relative;
	overflow: hidden;
	padding: 0 0.75em;
	color: inherit;
	-webkit-transition: color 0.6s;
	transition: color 0.6s;
}

.chat-input:empty + .chat-send {
	color: #a7d6ef;
}

.chat-send>i {
	position: relative;
}

.chat-effect-container {
	position: absolute;
	top: -100px;
	width: 100%;
}

.chat-effect-bar {
	background: #200348;
	position: absolute;
	top: 100px;
	width: 100%;
	height: 40px;
	-webkit-transform: rotateY(0);
	transform: rotateY(0);
}

.chat-effect-dots {
	position: absolute;
}

.chat-effect-dot {
	background: #200348;
	position: absolute;
	width: 15px;
	height: 15px;
	border-radius: 100%;
}

.chat-info-container {
	position: absolute;
	top: -20px;
	font-size: 12px;
	color: #2B8EC2;
}

.chat-info-typing {
	position: absolute;
	left: 80px;
	white-space: nowrap;
}
.botonmas {
    font-style: normal;
    font-size: 24px;
    font-weight: bold;
	cursor:pointer;
	text-align:center
}

.caja_opciones{
    position: absolute;
    width: 280px;
    z-index: 1000000;
	bottom:10px;
	display:none;
}

.caja_opciones ul {
	list-style:none;
	margin:0;
	padding:0;
    background: #eee;
    border-radius: 15px;
}

.caja_opciones ul li{
    padding: 8px ;
	border-bottom:1px solid #FFF;
	cursor:pointer;
}

.caja_opciones ul li:last-child{
	border-bottom:0px
}

.caja_opciones ul li i{
	margin:0 10px 0 0;
}

.caja_opciones .opc_cancelar{
	background: #eee;
    text-align: center;
    border-radius: 10px;
    padding: 12px 0;
    margin: 5px 0 0 0;
	cursor:pointer;
}




.caja_opciones_contexto{
    position: absolute;
    width: 280px;
    z-index: 1000000;
	bottom:10px;
	display:none;
}

.caja_opciones_contexto ul {
	list-style:none;
	margin:0;
	padding:0;
    background: #eee;
    border-radius: 15px;
}

.caja_opciones_contexto ul li{
    padding: 8px ;
	border-bottom:1px solid #FFF;
	cursor:pointer;
}

.caja_opciones_contexto ul li:last-child{
	border-bottom:0px
}

.caja_opciones_contexto ul li i{
	margin:0 10px 0 0;
}

.caja_opciones_contexto .opc_cancelar{
	background: #eee;
    text-align: center;
    border-radius: 10px;
    padding: 12px 0;
    margin: 5px 0 0 0;
	cursor:pointer;
}



.caja_opciones_lenguag{
    position: absolute;
    width: 280px;
    z-index: 1000000;
	bottom:10px;
	display:none;
}

.caja_opciones_lenguag ul {
	list-style:none;
	margin:0;
	padding:0;
    background: #eee;
    border-radius: 15px;
}

.caja_opciones_lenguag ul li{
    padding: 8px ;
	border-bottom:1px solid #FFF;
	cursor:pointer;
}

.caja_opciones_lenguag ul li:last-child{
	border-bottom:0px
}

.caja_opciones_lenguag ul li i{
	margin:0 10px 0 0;
}

.caja_opciones_lenguag .opc_cancelar{
	background: #eee;
    text-align: center;
    border-radius: 10px;
    padding: 12px 0;
    margin: 5px 0 0 0;
	cursor:pointer;
}


.cajasugerencias {
    min-height: 40px;
    width: 100%;
    display: block;
}
.cajasugerencias ul{
	list-style:none;
    padding: 0;
}
.cajasugerencias ul li{
    display: inline-block;
    text-align: center;
    width: 32%;
    color: #FFF;
    font-size: 14px;
	vertical-align:middle;
}
</style>
			<div class="content">
				<div class="chat-window">
                	<div class="caja_opciones">
                    	<ul>
                        	<li><i class="fa fa-camera"></i>Camera</li>
                        	<li><i class="fa fa-image"></i>Photo</li>
                        	<li class="bot_contexto"><i class="fa fa-file-text"></i>Context</li>
                        	<li><i class="fa fa-location-arrow"></i>Location</li>
                        	<li class="bot_lenguag"><i class="fa fa-pencil"></i>Language</li>
                        </ul>
                        <div class="opc_cancelar">Cancel</div>
                    </div>
                	<div class="caja_opciones_contexto">
                    	<ul>
                        	<li class="d_doctor"><i class="fas fa-stethoscope"></i>Doctor</li>
                        	<li class="d_isp"><i class="fas fa-phone-alt"></i>ISP</li>
                        	<li class="d_restaurant"><i class="fas fa-utensils"></i>Restaurant</li>
                        </ul>
                        <div class="opc_cancelar">Cancel</div>
                    </div>
                	<div class="caja_opciones_lenguag">
                    	<ul>
                        	<li><i class="fas fa-globe-americas"></i>English</li>
                        	<li><i class="fas fa-globe-americas"></i>Español</li>
                        	<li><i class="fas fa-globe-americas"></i>Deutsch</li>
                        	<li><i class="fas fa-globe-americas"></i>Poliski</li>
                        	<li><i class="fas fa-globe-americas"></i>Italiano</li>
                        </ul>
                        <div class="opc_cancelar">Cancel</div>
                    </div>
					<div class="chat-messages">
						<ol class="chat-messages-list">
							
						</ol>
					</div>
					<div class="chat-input-bar">
						<div class="chat-info-container">

						</div>
						<div class="chat-effect-container">
							<div class="chat-effect-bar"></div>
						</div>
						<div class="chat-input-wrapper">
							<div class="botonmas">+</div>
							<div class="chat-input" contenteditable></div>
							<button class="chat-send">
								<i class="fa fa-paper-plane"></i>
							</button>
                            <div class="cajasugerencias">
                            	<ul class="infosugerencias">
                                </ul>
                            </div>
						</div>
					</div>
				</div>
			</div>
            <input type="hidden" id="destino" value="1"/>
			<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="800">
			  <defs>
			    <filter id="goo">
			      <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
			      <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
			      <feComposite in="SourceGraphic" in2="goo" />
			    </filter>
			  </defs>
			</svg>
			
		</div><!-- /container -->
		<script src="jquery.min.js"></script>
		<script src="TweenMax.min.js"></script>
		<script src="chat.js"></script>
        <script>
			$(".opc_cancelar").click(function(){
			  $(".caja_opciones").hide();
			  $(".caja_opciones_lenguag").hide();
			  $(".caja_opciones_contexto").hide();
			});		
			$(".botonmas").click(function(){
			  $(".caja_opciones").show();
			});	
			$(".bot_lenguag").click(function(){
			  $(".caja_opciones").hide();
			  $(".caja_opciones_lenguag").show();
			});
			$(".bot_contexto").click(function(){
			  $(".caja_opciones").hide();
			  $(".caja_opciones_contexto").show();
			});		
			
			$(".d_doctor").click(function(){
				$("#destino").val("2");
			});		
			
			$(".d_isp").click(function(){
				$("#destino").val("3");
			});		
			
			$(".d_doctor").click(function(){
				$("#d_restaurant").val("3");
			});	
			
			

		</script>
        
</body>
</html>
