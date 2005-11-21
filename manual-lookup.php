<?php
require_once 'prepend.php';
require_once 'manual-lookup.inc';

$pattern = $_POST['pattern'];
$function = $_GET['function'];

if (!$function && $pattern) $function = $pattern;
$function = strtolower($function);

/* it gets messy trying to pass $lang around - so get it from the referral dir */
if(strstr(dirname($_SERVER[HTTP_REFERER]), "manual/")) {
	$lang = substr(dirname($_SERVER[HTTP_REFERER]), -2);
	}
else {
	$lang="en";
	}
/* there's always one, eh? */
if($lang == "BR") $lang = "pt_BR";

function make404($lang) {
	commonHeader("404 Not Found");
	$no_path = str_replace("/php-gtk-web/manual-lookup.php?lang=$lang&function=", "", htmlspecialchars($_SERVER[REQUEST_URI]));
	$no_path = ereg_replace('&[x]=[0-9]&[y]=[0-9]', '', $no_path);
	echo "<br>&nbsp;<H1>Not Found</H1><br>";
	if(strlen($no_path) < 3)
	echo "&nbsp;<B>" . $no_path . "</B> is too short to be used as a search string.  <a href=$_SERVER[HTTP_REFERER]>Go back and try something longer</a><br><br><br><br><br><br><br>";
	else echo "&nbsp;The function <B>" . $no_path . "</B> could not be found.  <a href=$_SERVER[HTTP_REFERER]>Try again</a><br><br><br><br><br><br><br>";
	commonFooter();
}

function multi_choice($file, $lang) {
	global $full_match;
	$request = $_GET['function'];
	$switch = (int)0;

	if($full_match > 1) {
		commonHeader('multiple choice');
		echo "<br><br>";
		echo "<h1>Which &quot;$request&quot; did you want?</h1>\n";
		echo "<br>";
	}
	elseif($full_match < 1) {
		commonHeader('multiple choice');
		echo "<br><br>";
		echo "<h1>There is no exact match for &quot;$request&quot;.<br>Here is a list of the nearest matches:</h1>\n";
		echo "<br>";
		$switch = 1;
	}
	for($i = 0; $i < sizeof($file); $i++) {
		$path[$i] = str_replace("/manual/", "", $file[$i]);
		$bits[$i][] = explode(".", $path[$i]);

		foreach($bits[$i] as $piece) {
		$GTK = substr(strtoupper($piece[0]), strlen($lang) + 1);
		$classlink = strtolower($file[$i]);
		if(strpos($classlink, "pt_br")) 
			$classlink = str_replace("pt_br", "pt_BR", $classlink);

		if(sizeof($piece) == 5 && $piece[2] == "method") {
		similar_text(strtolower($request), strtolower($piece[3]), $percent);
		if($percent == 100 && $full_match == 1) {
			header("Location: http://$_SERVER[HTTP_HOST]$classlink");
			exit;
/* We should have a nice clean separate function for $full_match == 1) */
			}
		elseif(($percent == 100 && $full_match > 1) || ($percent > 50 && $full_match == 0)) {
			echo "<P>&nbsp;$piece[3]() as in the <B><a href = 'http://$_SERVER[HTTP_HOST]$classlink'>$piece[1] $piece[2]</a></B>";
			if($switch == 0) echo "?";
			echo "</P>";
			}
		}
		elseif(sizeof($piece) == 5 && $piece[2] == "property") {
		$prop = strtolower(substr($piece[1], 3, strlen($piece[1])));
		if(strstr($prop, "event")) $prop = "event";
		similar_text(strtolower($request), strtolower($piece[3]), $percent);
		if($percent == 100 && $full_match == 1) {
			header("Location: http://$_SERVER[HTTP_HOST]$classlink");
			exit;
		}
		elseif(($percent == 100 && $full_match > 1) || ($percent > 50 && $full_match == 0)) {
			echo "<P>&nbsp;\$$prop-&gt;$piece[3] as in the <B><a href = 'http://$_SERVER[HTTP_HOST]$classlink'>$piece[1] $piece[2]</a></B>";
			if($switch == 0) echo "?";
			echo "</P>";
			}
		}
		elseif(sizeof($piece) == 5) {
		similar_text(strtolower($request), strtolower($piece[3]), $percent);
		if($percent == 100 && $full_match == 1) {
			header("Location: http://$_SERVER[HTTP_HOST]$classlink");
			exit;
			}
		elseif(($percent == 100 && $full_match > 1) || ($percent > 50 && $full_match == 0)) {
			echo "<P>&nbsp;&quot;$piece[3]&quot; as in the <B><a href = 'http://$_SERVER[HTTP_HOST]$classlink'>$piece[1] $piece[2]</a></B>";
			$i++;
			}
		}
		elseif(sizeof($piece) == 4 && $piece[1] == "enum") {
		similar_text(strtolower($request), strtolower($piece[2]), $percent);
		if($percent == 100 && $full_match == 1) {
			header("Location: http://$_SERVER[HTTP_HOST]$classlink");
			exit;
			}
		elseif(($percent == 100 && $full_match > 1) || ($percent > 50 && $full_match !== 1)) {
			echo "<P>&nbsp;[$piece[2]Value] as in the <B><a href = 'http://$_SERVER[HTTP_HOST]$classlink'>$piece[2] $piece[1]s</a></B>";
			if($switch == 0) echo "?";
			echo "</P>";
			}
		}
		elseif(sizeof($piece) == 4 && $piece[2] == "constructor") {
		similar_text(strtolower($request), strtolower($piece[1]), $percent);
		if($percent == 100 && $full_match == 1) {
			header("Location: http://$_SERVER[HTTP_HOST]$classlink");
			exit;
			}
		elseif(($percent == 100 && $full_match > 1) || ($percent > 50 && $full_match !== 1)) {
			echo "<P>&nbsp;$piece[1]() as in the <B><a href = 'http://$_SERVER[HTTP_HOST]$classlink'>$piece[1] $piece[2]</a></B>";
			if($switch == 0) echo "?";
			echo "</P>";
			}
		}
		elseif(sizeof($piece) == 4) {
		similar_text(strtolower($request), strtolower($piece[2]), $percent);
		if($percent == 100 && $full_match == 1) {
			header("Location: http://$_SERVER[HTTP_HOST]$classlink");
			exit;
			}
		elseif(($percent == 100 && $full_match > 1) || ($percent > 50 && $full_match !== 1)) {
			echo "<P>&nbsp;$piece[2]() as in the <B><a href = 'http://$_SERVER[HTTP_HOST]$classlink'>$GTK function</a></B>";
			if($switch == 0) echo "?";
			echo "</P>";
			}
		}
		elseif(sizeof($piece) == 3 && $piece[2] == "constructor") {
		similar_text(strtolower($request), strtolower($piece[1]), $percent);
		if($percent == 100 && $full_match == 1) {
			header("Location: http://$_SERVER[HTTP_HOST]$classlink");
			exit;
			}
		elseif(($percent == 100 && $full_match > 1) || ($percent > 50 && $full_match !== 1)) {
			echo "<P>&nbsp;$piece[1]() as in the <B><a href = 'http://$_SERVER[HTTP_HOST]$classlink.php'>$piece[1] $piece[2]</a></B>";
			if($switch == 0) echo "?";
			echo "</P>";
			}
		}
		elseif(sizeof($piece) == 3) {
		similar_text(strtolower($request), strtolower($piece[1]), $percent);
		if($percent == 100 && $full_match == 1) {
			header("Location: http://$_SERVER[HTTP_HOST]$classlink");
			exit;
			}
		elseif(($percent == 100 && $full_match > 1) || ($percent > 50 && $full_match !== 1)) {
			echo "<P>&nbsp;$piece[1] as in the <B><a href = 'http://$_SERVER[HTTP_HOST]$classlink'>$piece[1] class</a></B>";
			if($switch == 0) echo "?";
			echo "</P>";
			}
		}
	}
	}
	echo "<br><a href=$_SERVER[HTTP_REFERER]>Back</a>";
	commonFooter();
}

$function = strtolower($_GET['function']);

if(strlen($function) < 3) {
	make404($lang);
	exit;
}

$file = find_manual_page($lang, $function);

if(is_array($file)) {
	if(sizeof($file) < 2) {
		$file = strtolower($file[0]);
		if(strpos($file, "pt_br")) 
			$file = str_replace("pt_br", "pt_BR", $file);
		header("Location: http://$_SERVER[HTTP_HOST]$file");
		exit;
	}
	multi_choice($file, $lang);
	exit;
}

elseif($file  && !is_array($file)) {
	$file = strtolower($file);
	if(strpos($file, "pt_br")) 
		$file = str_replace("pt_br", "pt_BR", $file);
	header("Location: http://$_SERVER[HTTP_HOST]$file");
	exit;
}

else {
	make404($lang);
	exit;
}

?>
