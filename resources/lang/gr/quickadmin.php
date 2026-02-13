<?php

/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/
;

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
	'qa_create' => 'Δημιουργία',
	'qa_save' => 'Αποθήκευση',
	'qa_edit' => 'Επεξεργασία',
	'qa_view' => 'Εμφάνιση',
	'qa_update' => 'Ενημέρωησ',
	'qa_list' => 'Λίστα',
	'qa_no_entries_in_table' => 'Δεν υπάρχουν δεδομένα στην ταμπέλα',
	'qa_custom_controller_index' => 'index προσαρμοσμένου controller.',
	'qa_logout' => 'Αποσύνδεση',
	'qa_add_new' => 'Προσθήκη νέου',
	'qa_are_you_sure' => 'Είστε σίγουροι;',
	'qa_back_to_list' => 'Επιστροφή στην λίστα',
	'qa_dashboard' => 'Dashboard',
	'qa_delete' => 'Διαγραφή',
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
