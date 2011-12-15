<?php
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
    header('Location: ./clearsessions.php');
}
$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

$content = $connection->get('statuses/user_timeline', array('count' => 200));
?>
    <p>
      <pre>
        <?php 
		for ($i=0;$i<200;$i++){
			if (strlen(stristr($content[$i]->{'text'},'paldies'))>0) {
				echo $content[$i]->{'text'}."<br/>";
			}
		}
		?>
      </pre>
    </p>
<?php
//echo sizeof($content)."<br/>";
//echo $content[0];
//$content = $connection->get('users/lookup', array('user_id' => '273529558'));
//echo $content[0]->{'screen_name'}."<br/>";

/* Some example calls */
//$connection->get('users/show', array('screen_name' => 'abraham'));
//$connection->post('statuses/update', array('status' => date(DATE_RFC822)));
//$connection->post('statuses/destroy', array('id' => 5437877770));
//$connection->post('friendships/create', array('id' => 9436992)));
//$connection->post('friendships/destroy', array('id' => 9436992)));

/* Include HTML to display on the page */
?>