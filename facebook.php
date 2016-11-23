<?php

  session_start();
  $app_id = "";
  $app_secret = "";
  $my_url = "";


  $code = $_REQUEST["code"];

  if(empty($code)) {
    $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
    $dialog_url = "http://www.facebook.com/dialog/oauth?client_id="
      . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
      . $_SESSION['state'];

    echo("<script> top.location.href='" . $dialog_url . "'</script>");
  }

  if($_REQUEST['state'] == $_SESSION['state']) {
    $token_url = "https://graph.facebook.com/oauth/access_token?"
      . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
      . "&client_secret=" . $app_secret . "&code=" . $code;

    $response = file_get_contents($token_url);
    $params = null;
    parse_str($response, $params);

    $graph_url = "https://graph.facebook.com/me?fields=picture,first_name,last_name&access_token="
      . $params['access_token'];

    $user = json_decode(file_get_contents($graph_url));
  //  echo("Hello " . $user->name);
  $user =(array)$user;

  if(isset($user['name']))
  {
    $first_name = '';
    $last_name = '';
    $part = explode(' ',$user['name']);
    if(isset($part[0]))
    {
      $first_name = $part[0];
    }
    if(isset($part[1]))
    {
      $last_name = $part[1];
    }
  }
    $img = '';
    $info = array('id' => $user['id'],
                  'socialservice' => 'facebook',
                  'last_name' => $user['last_name'],
                  'first_name' => $user['first_name']);
  if(isset($user['picture']->data->url) && !empty($user['picture']->data->url))
  {
    $img = $user['picture']->data->url;
  }


  }
  else {
    echo("The state does not match. You may be a victim of CSRF.");
  }



require_once("auth.php");
