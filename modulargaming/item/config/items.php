<?php defined('SYSPATH') OR die('No direct access allowed.');

return array (
	'image' => array(
		'width' => 80,
		'heigth' => 80		
	),
	'inventory' => array(
		'pagination' => 20,
		'ajax' => true,
		'consume_show_results' => 'all', // (all|first) show all or the first result the item commands return when consuming an item
	),
	'cookbook' => array(
		'ajax' => true		
	),
	'safe' => array(
		'pagination' => 30
	),
	'user_shop' => array(
		'description_char_limit' => 500, //character length of the user's shop description
		'creation_cost' => 200, //set to 0 or false to disable
		'size' => array( //put a limit on how many items that shop can contain
			'active' => true, 
			'unit_cost' => 100,	//cost of upgrading to one unit higher
			'unit_size' => 10 //how many items can be stored per unit
		)	
	),
	'trade' => array(
		'currency_image' => false,
		'lots' => array(
			'max_results' => 25, //max amount of trade lots per page
			'max_items' => 10, //Max amount of items a user can put up for trade
			'count_amount' => true //count the amount of items(true) or item stacks(false)
		),
		'bids' => array(
			'max_results' => 20, //max amount of bids per page
			'max_items' => 11, //Max amount of items (including 1 slot for points) a user can bid
			'count_amount' => true //count the amount of items(true) or item stacks(false)
		)
	)
);