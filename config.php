<?php

	/**
	 * BU MB bilan ishlash 203-guruh tomonidan ishlab chiqilgan kichik ORM
	 */
	class Spes
	{
		private $host = "localhost"; 
		private $user = "mysql";
		private $parol = "mysql";
		private $db_name = "coffeeshop";
		private $link;
		public $ret = [];
		function __construct()
		{
			$this->link = mysqli_connect($this->host,$this->user,$this->parol,$this->db_name);
			if(!$this->link){
				exit('Baza bilan bog\'lanmadi');
			}
		}
		public function getdata($table,$arr,$cond="no")
		{
			$sql = "SELECT * FROM ".$table." WHERE ";
			$t = "";
			$n = count($arr);
			$i = 0;
			if($cond=="no"){
				foreach ($arr as $key => $value) {
					$i++;
					if($i==$n){
						$t .= "$key='$value'";
					}
					else{
						$t .= "$key='$value'  AND ";
					}
				}
				$sql .= $t;
			}
			else{
				$sql .= $cond;
			}			
			$fetch = mysqli_fetch_assoc($this->query($sql));
			return $fetch;
		}
		public function getdatas($table,$arr,$cond="no")
		{
			$sql = "SELECT * FROM ".$table." WHERE ";
			$t = "";
			$n = count($arr);
			$i = 0;
			if($cond=="no"){
				foreach ($arr as $key => $value) {
					$i++;
					if($i==$n){
						$t .= "$key='$value'";
					}
					else{
						$t .= "$key='$value'  AND ";
					}
				}
				$sql .= $t;
			}
			else{
				$sql .= $cond;
			}
			$fetchs = [];
			$r = $this->query($sql);
			while ($fetch = mysqli_fetch_assoc($r)) {
				array_push($fetchs, $fetch);
			}
			return $fetchs;
		}
		public function insert($table,$arr)
		{
			$sql = "INSERT INTO ".$table." ";
			$t1 = "";
			$t2 = "";
			$n = count($arr);
			$i = 0;
			foreach ($arr as $key => $value) {
				$i++;
				if($i==$n){
					$t1 .= $key;
					$t2 .= "'".$value."'";
				}
				else{
					$t1 .= $key.",";
					$t2 .= "'".$value."',";
				}
			}
			$sql .= "($t1) VALUES ($t2)";
			return $this->query($sql);
		}
		public function query($query)
		{
			return mysqli_query($this->link,$query);
		}
		public function update($table,$data,$arr,$cond="no")
		{
			$sql = "UPDATE ".$table." SET ";
			$t = "";
			$n = count($data);
			$i = 0;
			foreach ($data as $key => $value) {
				$i++;
				if($i==$n){
					$t .= "$key='$value'";
				}
				else{
					$t .= "$key='$value',";
				}
			}
			$sql .= $t;
			$sql .= " WHERE ";
			$t = "";
			$n = count($arr);
			$i = 0;
			if($cond=="no"){
				foreach ($arr as $key => $value) {
					$i++;
					if($i==$n){
						$t .= "$key='$value'";
					}
					else{
						$t .= "$key='$value'  AND ";
					}
				}
				$sql .= $t;
			}
			else{
				$sql .= $cond;
			}			
			return $this->query($sql);
		}
		public function delete($table,$arr,$cond="no")
		{
			$sql = "DELETE FROM ".$table." WHERE ";
			$t = "";
			$n = count($arr);
			$i = 0;
			if($cond=="no"){
				foreach ($arr as $key => $value) {
					$i++;
					if($i==$n){
						$t .= "$key='$value'";
					}
					else{
						$t .= "$key='$value'  AND ";
					}
				}
				$sql .= $t;
			}
			else{
				$sql .= $cond;
			}			
			return $this->query($sql);
		}
		public function get_client_ip() {
		    $ipaddress = '';
		    if (getenv('HTTP_CLIENT_IP'))
		        $ipaddress = getenv('HTTP_CLIENT_IP');
		    else if(getenv('HTTP_X_FORWARDED_FOR'))
		        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		    else if(getenv('HTTP_X_FORWARDED'))
		        $ipaddress = getenv('HTTP_X_FORWARDED');
		    else if(getenv('HTTP_FORWARDED_FOR'))
		        $ipaddress = getenv('HTTP_FORWARDED_FOR');
		    else if(getenv('HTTP_FORWARDED'))
		       $ipaddress = getenv('HTTP_FORWARDED');
		    else if(getenv('REMOTE_ADDR'))
		        $ipaddress = getenv('REMOTE_ADDR');
		    else
		        $ipaddress = 'UNKNOWN';
		    return $ipaddress;
		}
		public function filter($s)
		{
			$s = htmlspecialchars($s,ENT_QUOTES);
			return $s;
		}
		public function print_json()
		{
			echo json_encode($this->ret);
		}
		function __destruct(){
			mysqli_close($this->link);
		}
	}
?>
