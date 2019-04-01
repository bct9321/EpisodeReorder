<?php
$commitRename = false;
if(!isset($argv[1])){
	die("Must provide Path to file directory\n");
} else if(!isset($argv[2])){
	die("Must provide Season\n");
} else if(!isset($argv[3]) || $argv[3] === "false") {
	echo "Previewing Filename changes\n";
} else if(!isset($argv[4])){
	die("Must provide Original Episode Numbering Length\n");
} else if($argv[3] === "true") {
	$commitRename = true;
	echo "Renaming Files...\n";
}

$season = str_pad($argv[2], 2, '0', STR_PAD_LEFT);
$filePath = $argv[1];
$epLength = $argv[4];
echo "Renaming Season $season\n";



function my_ofset($text){
    preg_match('/^\D*(?=\d)/', $text, $m);
    return isset($m[0]) ? strlen($m[0]) : false;
}


echo "Loading File Names\n";
$files = (scandir($filePath)); 

$episodeNumber = 1;
foreach($files as $fileName) {
	$invalidFiles = ['.', '..', 'rename.bat', 'rename.php'];
	if (in_array($fileName, $invalidFiles)) {
		continue;
	}
	
	echo "Parsing: $fileName\n";
	$firstInt = my_ofset($fileName, "0123456789");
	$lastInt = $firstInt+$epLength;
	echo "first int: $firstInt\n";
	echo "last int: $lastInt\n";
	
	$strBeforeFirstInt = substr($fileName, 0, $firstInt);
	$strAfterFirstInt = substr($fileName, $lastInt);
	$spaceAfterInt = strpos($strAfterFirstInt, ' ');
	//echo "spaceAfterInt: $spaceAfterInt\n";
	$episode = substr($strAfterFirstInt, 0, $spaceAfterInt);
	//echo "$episode\n";
	
	$strAfterEp = substr($strAfterFirstInt, $spaceAfterInt);
	
	$newName = $strBeforeFirstInt . "S" . $season . "E" . str_pad($episodeNumber, 3, '0', STR_PAD_LEFT) . $strAfterEp;
	
	
	if ($commitRename === true) {
		if (rename($filePath."/".$fileName, $filePath."/".$newName)) {
			$foreground = "\033[1;37m";
			$background = "\033[42m";
			echo $coloredString = $foreground . $background . "RENAMED" . "\033[0m";
		} else {
			$foreground = "\033[1;37m";
			$background = "\033[41m";
			echo $coloredString = $foreground . $background . "FAIL" . "\033[0m";
		}
	}
	 echo " $newName\n"; 
	
	$episodeNumber++;
	
}
echo "\n";
echo "Done\n";
echo "\n";
