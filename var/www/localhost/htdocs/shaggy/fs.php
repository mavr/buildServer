<?php 
	include_once("scripts/fs_action.php");

	$fsface = new ExpFS_Interface();
	$fses = $fsface->getFSList();
//	$fses = $fsface->fses();
	foreach($fses as $fs) {
		echo "<a href=filesystem.php?id=".$fs->id().">";
		if($fs->active())
			echo "<p><b>[".$fs->id()."] ".$fs->name()."; </b></p>";
		else 
			echo "<p>[".$fs->id()."] ".$fs->name().";</p>";
		echo "</a>";
	}
?>
