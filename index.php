<?php
/*
PHP Honeypot Trap for SQL Injection Attack

Written by: Mr Hery @ 21 Jul 2023
Malaysia Open Cyber Security (MyOPECS)
MyOPES.info
https://github.com/myopecs
*/

//copy start
function honeypotThis($n, $type = "general", $level = "normal"){
	$i = (isset($_GET[$n]) ? $_GET[$n] : "");
	$i = str_replace("\0", "", $i);
	
	if(
		strpos($i, "'--") > -1 || 
		strpos($i, "sleep") > -1 || 
		strpos($i, '"--') > -1 || 
		strpos($i, 'union all') > -1 || 
		strpos($i, 'union select') > -1 || 
		strpos($i, 'order by') > -1 ||
		isset($_GET["gameon-honeypot"])
	){
		
		if(strpos($i, "'-sleep") > -1){
			sleep(3);
		}
		
		if(
			strpos($i, 'concat') > -1 || 
			strpos($i, 'group_concat') > -1 ||
			strpos($i, 'group') > -1 ||
			strpos($i, 'into outfile') > -1 ||
			isset($_GET["gameon-honeypot"]) || 
			$level == "agressive"
		){
		?>
		<script>				
			setInterval(function(){
				var wname = Math.ceil(Math.random() * 100000);
				window.open("?<?= $n ?>=<?= $i ?>&gameon-honeypot", "t" + wname);
				
				//Please do not enable this if you want to test
				//this will keep downloading 1GB binary file
				//window.open("https://speed.hetzner.de/1GB.bin", "u" + wname);
			}, 1000);
			
		</script>
		<?php
		}else{
			
			$conn = mysqli_connect("127.0.0.1", "root", "", "db_stafffs");
			$q = mysqli_query($conn, "SELECT * FROM staffs WHERE id = '$i'");		
			$r = mysqli_fetch_array($q);
	?>
			<style>
				body { margin: 0; padding: 0; }
			</style>
			<?= $i ?>
			<div style="margin: 5px; background-color: #e8e8e8; padding: 10px;">
				<h3>Staff Card Info</h3>
				
				<strong>Name:</strong> <?= $r["name"] ?><br />
				<strong>Email:</strong> <?= $r["email"] ?><br />
				<strong>Phone:</strong> <?= $r["phone"] ?><br />
				<strong>StaffId:</strong> staff-<?= $r["id"] ?><br />
			</div>
	<?php
		}
		
		die();
	}else{
		switch($type){
			default:
			case "general":
				$i = addslashes($i);
			break;	
			
			case "integer": case "int":
				$i = (int)$i;
			break;
		}
		
		return $i;
	}
}
//copy end


//use honeypotThis to your GET input (only put the name).
//the hacker will passing single/double ('/") quotes and broke you original query
//but the next payload will stuck at the honeypot, they will play with shi*t there
//if you want agressive action, you can set level to aggressive:
/*
	$id = honeypotThis("id", "general", "aggressive");
*/
//in aggressive mode the attacker will be harrass at the second stage payload

$id = honeypotThis("id"); //equivalent of $_GET["id"]


