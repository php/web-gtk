<?php

/*
 * email_validation.inc
 * $Id$
 */

/* Try to keep 'badwords' up to date, there are rarely more than 5 per category */
$badwords = array(' drugs ', 'viagra', ' cialis ', 'levitra', 'pharmac', // drugs
				  ' sex ', 'lesbian', ' porn ', ' chicks ', 'fuck', // sex
				  'gambling', 'casino', 'poker', 'blackjack', // gambling
				  ' loans ', 'mortgage', 'make money', // finance
				  );

/* Stole this wholesale from master, but someone might know a better one... */
$email_regex = ":^([-!#\$%&'*+./0-9=?A-Z^_`a-z{|}~ ])+" .
				"@([-!#\$%&'*+/0-9=?A-Z^_`a-z{|}~ ]+\\.)+" .
				"[a-zA-Z]{2,6}\$:i";

?>
