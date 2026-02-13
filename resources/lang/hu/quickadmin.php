<?php

return [
	
	'user-management' => [
		'title' => 'User management',
		'fields' => [
		],
	],
	
	'roles' => [
		'title' => 'Roles',
		'fields' => [
			'title' => 'Title',
		],
	],
	
	'users' => [
		'title' => 'Users',
		'fields' => [
			'name' => 'Name',
			'email' => 'Email',
			'password' => 'Password',
			'role' => 'Role',
			'remember-token' => 'Remember token',
		],
	],
	
	'cities' => [
		'title' => 'Cities',
		'fields' => [
			'name' => 'Name',
		],
	],
	
	'businesses' => [
		'title' => 'Businesses',
		'fields' => [
			'name' => 'Name',
		],
	],

	'plans' => [
		'title' => 'Plan Management',
		'fields' => [
			'frequency' => 'Frequency',
			'amount' => 'Amount',
		],
	],
	
	'listings' => [
		'title' => 'Listings',
		'fields' => [
			'name' => 'Name',
			'city' => 'City',
			'businesses' => 'Businesses',
			'address' => 'Address',
			'description' => 'Description',
			'logo' => 'Logo',
		],
	],
	//product tags
	'products_listing' => [
		'title' => 'Product Management',
	],
	'products' => [
		'title' => 'Products',
		'fields' => [
			'title'         =>  'Title',
			'name'          =>  'Product Name',
			'price'         =>  'Price',
			'type'          =>  'Type',
			'value'			=>  'Value',
			'option' => 'Option',
			'product' => 'Prodcuts',
			'product_images' => 'Product images',
			'product_faq' => 'Product Faqs',
			'product_description' => 'Description',
			'product_quetion' => 'Enter question',
			'product_answer' => 'Enter answer'
		],
	],
	'pcoupon'=> [
		'title' => 'Product Coupon',
		'fields' => [
			'title'         =>  'Title',
			'name'          =>  'Coupon Name',
			'code'          =>  'Coupon Code',
			'type'          =>  'Type',
			'value'			=>  'Value',
			'max_red'       =>  'Maximum Redemptions',
			'percentage'    =>  'Percentage',
			'flat'			=>  'Flat',
			'status'        =>  'Status',
			'select_product' => 'Please select product',
			'option' => 'Option',
			'product' => 'Prodcuts'
		],
	],
	//product end
	'qa_create' => 'Létrehozás',
	'qa_save' => 'Mentés',
	'qa_edit' => 'Szerkesztés',
	'qa_view' => 'Megtekintés',
	'qa_update' => 'Frissítés',
	'qa_list' => 'Lista',
	'qa_no_entries_in_table' => 'Nincs bejegyzés a táblában',
	'qa_logout' => 'Kijelentkezés',
	'qa_add_new' => 'Új hozzáadása',
	'qa_are_you_sure' => 'Biztosan így legyen?',
	'qa_back_to_list' => 'Vissza a listához',
	'qa_dashboard' => 'Vezérlőpult',
	'qa_delete' => 'Törlés',
	'qa_custom_controller_index' => 'Egyedi vezérlő index.',
	'quickadmin_title' => 'Gym Select',
	//04-06-2022
	'qa_sponsership' => 'Sponsors',
	'qa_sponsership_one' => 'First Sponsor',
	'qa_sponsership_two' => 'Second Sponsor',
	'qa_sponsership_three' => 'Third Sponsor',
	'sponsors' => [
		'title' => 'Sponsors',
		'fields' => [
			'title'         =>  'Title',
			'name'          =>  'Name',
			'link'          =>  'Website Link',
			'image'         =>  'Logo'
		],
	],
];
