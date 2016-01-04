
// Create the canvas
var canvas = document.createElement("canvas");
var ctx = canvas.getContext("2d");
canvas.width = 1280;
canvas.height = 914;
document.body.appendChild(canvas);

// Background image
var bgReady = false;
var bgImage = new Image();
bgImage.onload = function () {
	bgReady = true;
};
bgImage.src = "forest.jpg";

// mom image
var momReady = false;
var momImage = new Image();
momImage.onload = function () {
	momReady = true;
};
momImage.src = "gotchaMom.png";

// reese image
var reeseReady = false;
var reeseImage = new Image();
reeseImage.onload = function () {
	reeseReady = true;
};
reeseImage.src = "scaryReese.png";

//Gotcha image is broken for now, will fix later. Goal is for word "Gotcha" to
// flash on screen if Reese is caught.
// var gotchaImage = false;
// var gotchaImage = new Image();
// gotchaImage.onload = function (){
//   gotchaImage = true;
// };
// gotchaImage.src = "Gotcha_pic.png";

// Game objects
var mom = {
	speed: 200 // movement in pixels per second
};
var reese = {};
var reesesCaught = 0;

// Handle keyboard controls
var keysDown = {};

addEventListener("keydown", function (e) {
	keysDown[e.keyCode] = true;
}, false);

addEventListener("keyup", function (e) {
	delete keysDown[e.keyCode];
}, false);

// Reset the game when the player catches reese
var reset = function () {
	mom.x = canvas.width / 2;
	mom.y = canvas.height / 2;

	// Puts reese somewhere on the screen randomly
	reese.x = 32 + (Math.random() * (canvas.width - 80));
	reese.y = 32 + (Math.random() * (canvas.height - 80));
};

// Update game objects
var update = function (modifier) {
	if (38 in keysDown) { // Player holding up
		mom.y -= mom.speed * modifier;
	}
	if (40 in keysDown) { // Player holding down
		mom.y += mom.speed * modifier;
	}
	if (37 in keysDown) { // Player holding left
		mom.x -= mom.speed * modifier;
	}
	if (39 in keysDown) { // Player holding right
		mom.x += mom.speed * modifier;
	}

	// Are they touching?
	if (
		mom.x <= (reese.x + 32)
		&& reese.x <= (mom.x + 32)
		&& mom.y <= (reese.y + 32)
		&& reese.y <= (mom.y + 32)
	) {
		++reesesCaught;
		reset();
	}
};

// Draw everything
var render = function () {
	if (bgReady) {
		ctx.drawImage(bgImage, 0, 0);
	}

	if (momReady) {
		ctx.drawImage(momImage, mom.x, mom.y);
	}

	if (reeseReady) {
		ctx.drawImage(reeseImage, reese.x, reese.y);
	}

	// Score
	ctx.fillStyle = "rgb(255, 0, 0)";
	ctx.font = "2.5em Arial"
	ctx.textAlign = "left";
	ctx.textBaseline = "top";
	ctx.fillText("Times mom caught Reese: " + reesesCaught, 32, 32);
};

// The main game loop
var main = function () {
	var now = Date.now();
	var delta = now - then;

	update(delta / 1000);
	render();

	then = now;

	// Request to do this again ASAP
	requestAnimationFrame(main);
};

// Cross-browser support for requestAnimationFrame
var w = window;
requestAnimationFrame = w.requestAnimationFrame || w.webkitRequestAnimationFrame || w.msRequestAnimationFrame || w.mozRequestAnimationFrame;

// Let's play this game!
var then = Date.now();
reset();
main();
