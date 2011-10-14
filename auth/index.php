<?php
header('Location: ./..');
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */

/* Load required lib files. */
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

/* If access tokens are not available redirect to connect page. */
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
    header('Location: ./clearsessions.php');
}
/* Get user access tokens out of the session. */
$access_token = $_SESSION['access_token'];

/* Create a TwitterOauth object with consumer/user tokens. */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

/* If method is set change API call made. Test is called by default. */
$nextCursor = -1;
while ($nextCursor!=0){
$content = $connection->get('statuses/friends', array('cursor' => $nextCursor));
$nextCursor = $content->{'next_cursor_str'};
?>
    <p>
      <pre>
        <?php print_r($content); ?>
      </pre>
    </p>
	<hr/>
<?php
}
//echo sizeof($content)."<br/>";
//echo $content[0];
//$content = $connection->get('users/lookup', array('user_id' => '273529558'));
//echo $content[0]->{'screen_name'}."<br/>";

/* Some example calls */
//$connection->get('users/show', array('screen_name' => 'abraham')));
//$connection->post('statuses/update', array('status' => date(DATE_RFC822)));
//$connection->post('statuses/destroy', array('id' => 5437877770));
//$connection->post('friendships/create', array('id' => 9436992)));
//$connection->post('friendships/destroy', array('id' => 9436992)));

/* Include HTML to display on the page */
include('html.inc');