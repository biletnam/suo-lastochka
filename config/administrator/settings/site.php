<?php

/**
 * The main site settings page
 */
return [
	/**
	 * Settings page title
	 *
	 * @type string
	 */
	'title' => 'Настройки программы',

	/**
	 * The edit fields array
	 *
	 * @type array
	 */
	'edit_fields' => [
		'site_name' => [
			'title' => 'Название программы',
			'type' => 'text',
			'limit' => 50,
		],
    ]
];