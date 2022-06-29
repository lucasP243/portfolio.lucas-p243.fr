<?php

$lang = detect_user_lang();
setcookie(
	name              : 'lang',
	value             : $lang,
	expires_or_options: strtotime('+30 days', time()), // cookie lasts 30 days
	domain            : '.lucas-p243.fr', // make cookie available for whole domain
	path              : "/",
	httponly          : TRUE,
);
include "../core/templates/home.$lang.tpl";

print_r($_SERVER['SERVER_NAME']);


function detect_user_lang(): string
{
	$lang = ['en', 'fr'];

	if (isset($_GET['lang']) && in_array($_GET['lang'], $lang))
	{
		return $_GET['lang'];
	}

	if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], $lang))
	{
		return $_COOKIE['lang'];
	}

	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
	{
		$http_accept_language = array_map(
			fn($value) => substr($value, 0, 2),
			explode(
				',',
				$_SERVER['HTTP_ACCEPT_LANGUAGE']
			)
		);
		foreach ($http_accept_language as $value)
		{
			if (in_array($value, $lang)) return $value;
		}
	}

	return 'en'; // Default
}