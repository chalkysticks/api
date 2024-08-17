<?php

return [
	/*
	   |--------------------------------------------------------------------------
	   | Authentication Language Lines
	   |--------------------------------------------------------------------------
	   |
	   | The following language lines are used during authentication for various
	   | messages that we need to display to the user. You are free to modify
	   | these language lines according to your application's requirements.
	   |
	   */

	// TYPE_VENUE_ADD
	'100' => 'Check out the newly added {{ type }}, <a href="{{ url }}">{{ name }}</a>.',

	// TYPE_VENUEMEDIA_ADD
	'105' => 'There\'s a new image for <a href="{{ url }}">{{ name }}</a>.',

	// TYPE_VENUE_UPDATE
	'110' => 'The {{ type }}, <a href="{{ url }}">{{ name }}</a>, was recently updated.',

	// TYPE_VENUE_CHECKIN
	'120' => '<a href="{{ user_url }}">{{ user_name }}</a> just checked in at <a href="{{ venue_url }}">{{ venue_name }}</a>.',

	// TYPE_BEACON_ADD
	'200' => '<a href="{{ url }}">{{ name }}</a> just sent out a beacon.',

	// TYPE_TOURNAMENT_ADD
	'300' => 'New tournament, <a href="{{ tournament_url }}">{{ tournament_name }}</a>, announced at <a href="{{ venue_url }}">{{ venue_name }}</a> and created by <a href="{{ user_url }}">{{ user_name }}</a>.',

	// TYPE_LEAGUE_ADD
	'400' => '',

	// TYPE_CONTENT_ADD
	'500' => 'New content up for grabs! <a href="{{ url }}">{{ name }}</a>',

	// TYPE_CONTENT_PAD
	'510' => 'View the new Pad diagram <a href="{{ url }}">{{ name }}</a>',

	// TYPE_CONTENT_NEWS
	'520' => 'Read all about it! <a href="{{ url }}">{{ name }}</a>',

	// TYPE_CONTENT_VIDEO
	'530' => '<a href="{{ url }}">{{ name }}</a> - New video posted!',

];
