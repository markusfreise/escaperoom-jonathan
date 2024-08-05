wHvelocity = 0;
jetty_y = 0;
obstacle = [];
obstacle_height = [];
_pillars = 4;
distance = 240; // Abstand

ignition = 0;

speed = 0; // Fluggeschwindigkeit vertikal

background = 0;

loop = 0;

timer = new Date();

wH = jQuery("#space").height();

function initJetty() {

	jQuery("#space").click(function(e) {
		console.log(e);
		_ignite();
		e.preventDefault();
	});

	wH = jQuery("#space").height();

	intro();

}

function intro() {
	jQuery(".pillar").hide();
	clearInterval(loop);
	loop = window.setInterval("_intro_loop()",20);
	speed = 2;
	jQuery("#credits").fadeIn();
}

function _intro_loop() {

	jetty_pi = background/15;
	jetty_y = 320+Math.floor(80*Math.sin(jetty_pi));
	jQuery("#jetty").css("top",jetty_y+"px");
	if(jetty_pi%(2*3.1415927)>3.141/2 && jetty_pi%(2*3.1415927)<3.141*1.5) {
		jQuery("#jetty").addClass("ignite");
	}else{
		jQuery("#jetty").removeClass("ignite");
	}

	jQuery("#space").css("background-position-x",Math.floor(background)+"px");
	background -= speed/3;

}

function _restart() {

	for(i=0;i<_pillars;i++) {
		obstacle[i] = 480+i*distance;
		obstacle_height[i] = Math.floor(Math.random()*320);
		jQuery("#p"+(i+1)+"a").css("height",obstacle_height[i]+"px");
		jQuery("#p"+(i+1)+"b").css("height",(wH-obstacle_height[i]-220)+"px");
	}
	ignition = -3;
	speed = 2;
	velocity = 0;
	_jetty_y = 320;

	jQuery(".pillar").show();

	clearInterval(loop);
	loop = window.setInterval("_jetty()",20);

	jQuery("#credits").fadeOut();

}

function _ignite() {

	if(ignition!=0) {
		velocity = ignition;
		jQuery("#jetty").addClass("ignite");
		window.setTimeout("_ignite_off()",500);
	}else{
		_restart();
	}
}

function _ignite_off() {
	jQuery("#jetty").removeClass("ignite");
}

function _jetty() {

	jetty_y = Math.max(0,Math.min(608,jetty_y + velocity));
	if(jetty_y==608) {
		velocity = 0;
	}
	if((jetty_y==0 && velocity<0)) {
		velocity = 0;
	}
	velocity = Math.min(20,velocity + 0.1);

	_jy = Math.floor(jetty_y);
	jQuery("#jetty").css("top",_jy+"px");

	for(i=0;i<_pillars;i++) {
		obstacle[i] -= speed;
		if(obstacle[i]==-1*distance-80) {
			obstacle_height[i] = Math.floor(Math.random()*320);
			jQuery("#p"+(i+1)+"a").css("height",obstacle_height[i]+"px");
			jQuery("#p"+(i+1)+"b").css("height",(wH-obstacle_height[i]-220)+"px");
			obstacle[i] = 400+distance;
		}

		/* BAMM! */
		if(obstacle[i]<112 && obstacle[i]+79>80) {
			if(_jy<obstacle_height[i] || _jy+32>wH-(wH-obstacle_height[i]-220)) {
				ignition = 0;
				speed = 0;
				intro();
			}

		}
		jQuery("#p"+(i+1)+"a").css("left",obstacle[i]+"px");
		jQuery("#p"+(i+1)+"b").css("left",obstacle[i]+"px");
	}

	jQuery("#space").css("background-position-x",Math.floor(background)+"px");
	background -= speed/3;

}
