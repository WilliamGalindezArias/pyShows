var KEY_ENTER=13;
$(document).ready(function(){
	var $input=$(".chat-input")
		,$sendButton=$(".chat-send")
		,$messagesContainer=$(".chat-messages")
		,$messagesList=$(".chat-messages-list")
		,$effectContainer=$(".chat-effect-container")
		,$infoContainer=$(".chat-info-container")

		,messages=0
		,bleeding=100
		,isFriendTyping=false
		,incomingMessages=0
		,lastMessage=""
	;
	
	

	function gooOn(){
		setFilter('url(#goo)');
	}
	function gooOff(){
		setFilter('none');
	}
	function setFilter(value){
		$effectContainer.css({
			webkitFilter:value,
			mozFilter:value,
			filter:value,
		});
	}

	function addMessage(message,self){
		var $messageContainer=$("<li/>")
			.addClass('chat-message '+(self?'chat-message-self':'chat-message-friend'))
			.appendTo($messagesList)
		;
		var $messageBubble=$("<div/>")
			.addClass('chat-message-bubble')
			.appendTo($messageContainer)
		;
		$messageBubble.text(message);

		var oldScroll=$messagesContainer.scrollTop();
		$messagesContainer.scrollTop(9999999);
		var newScroll=$messagesContainer.scrollTop();
		var scrollDiff=newScroll-oldScroll;
		TweenMax.fromTo(
			$messagesList,0.4,{
				y:scrollDiff
			},{
				y:0,
				ease:Quint.easeOut
			}
		);

		return {
			$container:$messageContainer,
			$bubble:$messageBubble
		};
	}
	function sendMessage(){
		var message=$input.text();
		
		if(message=="") return;

				 
				var contenido = message.includes("chucha");
	   if(contenido === true){
		   
				
				
			$(".chat-messages").css("background-image", "url(img/chucha.png)");
			setTimeout(function(){ $(".chat-messages").css("background-image", "url(img/fondo.png)"); },3000);

	   }
	   
	$('ul.infosugerencias').empty();


	
    $.ajax({
        type: 'POST',
        url: 'http://localhost:5005/webhooks/rest/webhook', //Acá pone la direccion a donde manda el msj q el usuario escribe
		//url: 'http://localhost:5000/parser',
		dataType: 'json',
		contentType: 'application/json',
		data: JSON.stringify( { "sender": "00001", "message": message } ),
        success: function(respuesta) {
			
				/*
				El formato para q mande los datos en json es:
				 json_encode(array(
							'mensaje' => 'ACÁ MANDA EL MENSAJE',
							'sugerenciap' => 'ACÁ MANDA LA PRIMERA SUGERENCIA',
							'sugerencias' => 'ACÁ MANDA LA SEGUNDA SUGERENCIA',
							'sugerenciat' => 'ACÁ MANDA LA TERCERA SUGERENCIA',
							
						));
				*/
				if(respuesta !== ""){
					respuestatxt = JSON.parse(JSON.stringify(respuesta));
					
					//var contenido = respuestatxt.mensaje.includes("chucha");
					/*
					var contenido = respuestatxt.message.includes("chucha");
					if(contenido==true){
						$(".chat-messages").css("background-image", "url(img/chucha.png)");
						setTimeout(function(){ $(".chat-messages").css("background-image", "url(img/fondo.png)"); },3000);			
					}
					*/
					//$("ol"). append("<li class=\"chat-message chat-message-friend\"><div class=\"chat-message-bubble\">"+respuestatxt.mensaje+"</div></li>");
					$("ol"). append("<li class=\"chat-message chat-message-friend\"><div class=\"chat-message-bubble\">"+respuestatxt[0].text+"</div></li>");
					
					if(respuestatxt.sugerenciap!="" || respuestatxt.sugerencias!="" ||  respuestatxt.sugerenciat!="" ){
						$('ul.infosugerencias').empty()
						if(respuestatxt.sugerenciap!=""){
							$("ul"). append("<li >"+respuestatxt.sugerenciap+"</li>");
						}
						if(respuestatxt.sugerencias!=""){
							$("ul"). append("<li >"+respuestatxt.sugerencias+"</li>");
						}
						if(respuestatxt.sugerenciat!=""){
							$("ul"). append("<li >"+respuestatxt.sugerenciat+"</li>");
						}
					}
				}
	
			
        }
    });
	

		lastMessage=message;

		var messageElements=addMessage(message,true)
			,$messageContainer=messageElements.$container
			,$messageBubble=messageElements.$bubble
		;

		var oldInputHeight=$(".chat-input-bar").height();
		$input.text('');
		updateChatHeight();
		var newInputHeight=$(".chat-input-bar").height();
		var inputHeightDiff=newInputHeight-oldInputHeight

		var $messageEffect=$("<div/>")
			.addClass('chat-message-effect')
			.append($messageBubble.clone())
			.appendTo($effectContainer)
			.css({
				left:$input.position().left-12,
				top:$input.position().top+bleeding+inputHeightDiff
			})
		;


		var messagePos=$messageBubble.offset();
		var effectPos=$messageEffect.offset();
		var pos={
			x:messagePos.left-effectPos.left,
			y:messagePos.top-effectPos.top
		}

		var $sendIcon=$sendButton.children("i");
		TweenMax.to(
			$sendIcon,0.15,{
				x:30,
				y:-30,
				force3D:true,
				ease:Quad.easeOut,
				onComplete:function(){
					TweenMax.fromTo(
						$sendIcon,0.15,{
							x:-30,
							y:30
						},
						{
							x:0,
							y:0,
							force3D:true,
							ease:Quad.easeOut
						}
					);
				}
			}
		);

		gooOn();

		
		TweenMax.from(
			$messageBubble,0.8,{
				y:-pos.y,
				ease:Sine.easeInOut,
				force3D:true
			}
		);

		var startingScroll=$messagesContainer.scrollTop();
		var curScrollDiff=0;
		var effectYTransition;
		var setEffectYTransition=function(dest,dur,ease){
			return TweenMax.to(
				$messageEffect,dur,{
					y:dest,
					ease:ease,
					force3D:true,
					onUpdate:function(){
						var curScroll=$messagesContainer.scrollTop();
						var scrollDiff=curScroll-startingScroll;
						if(scrollDiff>0){
							curScrollDiff+=scrollDiff;
							startingScroll=curScroll;

							var time=effectYTransition.time();
							effectYTransition.kill();
							effectYTransition=setEffectYTransition(pos.y-curScrollDiff,0.8-time,Sine.easeOut);
						}
					}
				}
			);
		}

		effectYTransition=setEffectYTransition(pos.y,0.8,Sine.easeInOut);
		
		// effectYTransition.updateTo({y:800});

		TweenMax.from(
			$messageBubble,0.6,{
				delay:0.2,
				x:-pos.x,
				ease:Quad.easeInOut,
				force3D:true
			}
		);
		TweenMax.to(
			$messageEffect,0.6,{
				delay:0.2,
				x:pos.x,
				ease:Quad.easeInOut,
				force3D:true
			}
		);

		TweenMax.from(
			$messageBubble,0.2,{
				delay:0.65,
				opacity:0,
				ease:Quad.easeInOut,
				onComplete:function(){
					TweenMax.killTweensOf($messageEffect);
					$messageEffect.remove();
					if(!isFriendTyping)
						gooOff();
				}
			}
		);


	}
	
	function friendIsTyping(){
		if(isFriendTyping) return;

		isFriendTyping=true;

		var $dots=$("<div/>")
			.addClass('chat-effect-dots')
			.css({
				top:-30+bleeding,
				left:10
			})
			.appendTo($effectContainer)
		;
		for (var i = 0; i < 3; i++) {
			var $dot=$("<div/>")
				.addClass("chat-effect-dot")
				.css({
					left:i*20
				})
				.appendTo($dots)
			;
			TweenMax.to($dot,0.3,{
				delay:-i*0.1,
				y:30,
				yoyo:true,
				repeat:-1,
				ease:Quad.easeInOut
			})
		};

		var $info=$("<div/>")
			.addClass("chat-info-typing")
			.text("Your friend is typing...")
			.css({
				transform:"translate3d(0,30px,0)"
			})
			.appendTo($infoContainer)

		TweenMax.to($info, 0.3,{
			y:0,
			force3D:true
		});

		gooOn();
	}

	function friendStoppedTyping(){
		if(!isFriendTyping) return

		isFriendTyping=false;

		var $dots=$effectContainer.find(".chat-effect-dots");
		TweenMax.to($dots,0.3,{
			y:40,
			force3D:true,
			ease:Quad.easeIn,
		});

		var $info=$infoContainer.find(".chat-info-typing");
		TweenMax.to($info,0.3,{
			y:30,
			force3D:true,
			ease:Quad.easeIn,
			onComplete:function(){
				$dots.remove();
				$info.remove();

				gooOff();
			}
		});
	}
	function receiveMessage(message){
		var messageElements=addMessage(message,false)
			,$messageContainer=messageElements.$container
			,$messageBubble=messageElements.$bubble
		;

		TweenMax.set($messageBubble,{
			transformOrigin:"60px 50%"
		})
		TweenMax.from($messageBubble,0.4,{
			scale:0,
			force3D:true,
			ease:Back.easeOut
		})
		TweenMax.from($messageBubble,0.4,{
			x:-100,
			force3D:true,
			ease:Quint.easeOut
		})
	}

	function updateChatHeight(){
		$messagesContainer.css({
			height:460-$(".chat-input-bar").height()
		});
	}

	$input.keydown(function(event) {
		if(event.keyCode==KEY_ENTER){
			event.preventDefault();
			sendMessage();
		}
	});
	$sendButton.click(function(event){
		event.preventDefault();
		sendMessage();
		// $input.focus();
	});
	$sendButton.on("touchstart",function(event){
		event.preventDefault();
		sendMessage();
		// $input.focus();
	});

	$input.on("input",function(){
		updateChatHeight();
	});

	gooOff();
	updateChatHeight();


})