<h2 style='margin:auto auto; text-align:center;'>Ieraksti no Threads</h2>
<?php

	if(isset($_POST['token'])){
		$token = $_POST['token'];
	}elseif(isset($_GET['token'])){
		$token = $_GET['token'];
	}else{
		$token = "";
	}

// var_dump($_GET);

function getPost($postURL,$token){
	$url = "https://graph.threads.net/v1.0/oembed?url=".$postURL."&access_token=".$token;
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	$result = curl_exec($ch);

	$output = json_decode($result);
	 
	echo $output->html."<br/>";
}

?>

<br/>
<div style="text-align: center; margin: auto auto;">

<form action="/threads" method="post">
  <label for="token">Token</label>: 
  <input type="text" name="token" value="<?php echo $token; ?>" style="width: 500px; padding:7px;"> 
  <input type="submit" value="Load" style="padding:7px;">
</form> 
<br/>
<?php
	getPost("https://www.threads.net/@meta/post/DIOuYBMBtQh",$token);
	getPost("https://www.threads.net/@threads/post/DIcJx-JS0fw",$token);
	getPost("https://www.threads.net/@meta/post/DH_Yse_OUA0",$token);

?>

	
</div>