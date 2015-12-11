<?php
	include_once("header.php");
	include_once("scripts/fs_action.php");

	if(!isset($_GET["id"])) {
		die("wrong get data");
	}

	$fsface = new ExpFS_Interface();
	$fses = $fsface->getFSList();

	foreach($fses as $item) {
		if($item->id() == $_GET["id"]) {
			$fs = $item;
			break;
		}
	}

	if(isset($_GET["act"])) {
		switch($_GET["act"]) {
			case "activate" : 
				$fs->setActive();
				break;
			case "rename":
				$fs->rename($_GET["fs_name"]);
				break;
		}
	}

	echo "<h3>".$fs->name()."</h3>";
	echo "<p>Active : ";
	if($fs->active()) echo "yes</p>";
	else echo "no</p>"
?>
	<form action="filesystem.php" method="GET">
		<input type="hidden" name="id" value="<?php echo $fs->id(); ?>" />
		<input type="hidden" name="act" value="activate" />
		<input type="submit" value="Set active"/>
	</form>

	<form action="filesystem.php" method="GET">
		<input type="hidden" name="id" value="<?php echo $fs->id(); ?>" />
		<input type="hidden" name="act" value="update" />
		<input type="submit" value="Update"/>
	</form>

	<form action="filesystem.php" method="GET">
		<input type="hidden" name="id" value="<?php echo $fs->id(); ?>" />
		<input type="hidden" name="act" value="clone" />
		<input type="text" name="fs_name" value="enter name for new fs">
		<input type="submit" value="Clone"/>
	</form>


