<?php 
	include_once("scripts/fs_action.php");

	$fsface = new ExpFS_Interface();
	$fses = $fsface->getFSList();
//	$fses = $fsface->fses();
	foreach($fses as $fs) {
		if($fs->active())
			echo "<p><b>[".$fs->id()."] ".$fs->name()."; </b></p>";
		else 
			echo "<p>[".$fs->id()."] ".$fs->name().";</p>";
	}

	$cmd = "whoami";
	exec($cmd, $output, $retval);
	echo "<p>".var_dump($output)."</p>";
	$fses[1]->setActive();
	
//	$fses[0]->fs_clone($fses[0]->name()."new");
	$arr = parse_ini_file("/etc/shaggy/shaggy.conf");
	print_r($arr);
	echo "bash script path : ".$arr["SHAGGYPATH"].$arr["SCRIPTPATH"];
?>
