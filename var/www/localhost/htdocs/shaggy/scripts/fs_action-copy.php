<?php 
	include_once("shaggy.conf");

	class ExpFileSystem {
		private $name;
		private $id;
		private $tag;
		private $upd_date;
		private $active;

		function __construct($name, $id, $active) {
			$this->name = $name;
			$this->active = $active;
			$this->id = $id;
		}

		function name() { return $this->name; }
		function active(){ return $this->active; }
		function id() { return $this->id; }

		function setActive() {
			$cmd = "eselect exportfs set ".$this->id;
			exec($cmd, $output, $retval);
			if($retval != 0) {
				echo "Error: cant run eselect exportfs set ".$this->id;
				return 1;
			}
		}

		function fs_clone($newname) {
			global $SCRIPTPATH;
			$cmd = $SCRIPTPATH."/clone.sh fs_".$this->name." fs_".$newname;
			echo "Clonning.....\t\t";
			//exec($cmd, $output, $retval);
			if($retval == 0) echo "[ok]";
			else echo "[fail]";
		}
	}

	class ExpFS_Interface {
		private $fses = array();

		public function getFSList() {
			$cmd = "eselect exportfs list";
			exec($cmd, $output, $retval);
			if($retval != 0) {
				echo "Error: something wrong with module exportfs for eselect";
				return;
			}
			for($i = 1; $i < count($output) ; $i++) {
				$active = false;
				$eselect_id = 0;
				if(preg_match('|\[\d\]|i', $output[$i], $id)) {
					$eselect_id = str_replace(array("[", "]"), "", $id[0]);
				} else {
					echo "Error: preg_match(), something wrong with module for eselect";
				}
				if( strpos($output[$i], "*") ) {
					$output[$i] = substr($output[$i], 0, strlen($output[$i]) - 2);
					$active = true;
				}
				$this->fses[] = new ExpFileSystem(substr($output[$i], 11), $eselect_id, $active);
			}
			return $this->fses();
		}

		public function fses() { return $this->fses; }
	}
