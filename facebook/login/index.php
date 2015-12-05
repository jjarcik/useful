<?php

require 'lib/facebook.php';

// your app ID
$APPID = '0123456789012345';
// your app secret
$SECRET = 'abcdefghijklmnopqrstivwxyz12345678';
// your app URL
$URL = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']); // or http://example.com/facebook


// facebook instance
$facebook = new Facebook(array('appId' => $APPID, 'secret' => $SECRET, 'cookie' => true));


if (isset($_GET['logout'])){
     // or try $facebook->setSession(null);
    session_destroy();
    header('Location: http://' . $URL);
    exit();
}

if (isset($_GET['login'])) {
    $session = $facebook->getSession();
    header('Location: http://' . $URL);
    exit();
}


// get user 
$user = $facebook->getUser();

if ($user) {

    try {

        // Proceed knowing you have a logged in user who's authenticated.        
        $user_profile = $facebook->api('/me');

    } catch (FacebookApiException $e) {

        // error catch here
        die ($e);
    }
}

// Login or logout button / url will be needed depending on current user state.
if ($user) {

    // if you want complete logout user
    // $logoutUrl = $facebook->getLogoutUrl(array('next' => $URL . '?logout=1'));

    // if you want unconnect user from your session
    $logoutUrl = 'http://' . $URL . '?logout=1';

} else {  
    $loginUrl = $facebook->getLoginUrl(array('next' => $URL . '?login=1'));
}

?>

<!doctype html>
<html>
<title>Facebook login example</title>

<body>

    <?php if ($user) { ?>

    <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">
    <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <h3>Your User Object (/me)</h3>
    <pre><?php print_r($user_profile); ?></pre>

    <?php } else { ?>

    <strong><em>You are not Connected.</em></strong>
    <br />
    <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>

    <?php } ?>

</body>

</html>