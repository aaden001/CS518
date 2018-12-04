<?php 

declare(strict_types=1);
include_once __DIR__.'src/FixedBitNotation.php';
include_once __DIR__.'src/GoogleAuthenticator.php';
 $g = new \Google\Authenticator\GoogleAuthenticator();
$salt = '7WAO342QFANY6IKBF7L7SWEUU79WL3VMT920VB5NQMW';
$secret = $username.$salt;
echo '<img src="'.$g->getURL($username, 'http://aaden001.cs518.cs.odu.edu', $secret).'" />';
?>
