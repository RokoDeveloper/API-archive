<?php

  session_start();
  $client_id = ''; // ID
  $client_secret = ''; // Секретный ключ
  $redirect_uri = ''; // Ссылка на приложение }

  $url = 'https://connect.mail.ru/oauth/authorize';
  $params = array(
    'client_id'     => $client_id,
    'response_type' => 'code',
    'redirect_uri'  => $redirect_uri
  );


  if (isset($_GET['code']))
  {
    $result = false;
    $params = array(
        'client_id'     => $client_id,
        'client_secret' => $client_secret,
        'grant_type'    => 'authorization_code',
        'code'          => $_GET['code'],
        'redirect_uri'  => $redirect_uri
    );


    $url = 'https://connect.mail.ru/oauth/token';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl);
    curl_close($curl);

    $tokenInfo = json_decode($result, true);

    if (isset($tokenInfo['access_token']))
    {
      $sign = md5("app_id={$client_id}method=users.getInfosecure=1session_key={$tokenInfo['access_token']}{$client_secret}");
      $params = array(
        'method'       => 'users.getInfo',
        'secure'       => '1',
        'app_id'       => $client_id,
        'session_key'  => $tokenInfo['access_token'],
        'sig'          => $sign
        );

      $userInfo = json_decode(file_get_contents('http://www.appsmail.ru/platform/api' . '?' . urldecode(http_build_query($params))), true);
      if (isset($userInfo[0]['uid']))
      {
        $userInfo = array_shift($userInfo);
        $result = true;
      }
    }
  }

  if ($result) {
    $img = '';
    $info = array('id' => $userInfo['uid'],
                  'socialservice' => 'mailru',
                  'last_name' => $userInfo['last_name'],
                  'first_name' => $userInfo['first_name']);
if(isset($userInfo['pic_small']) && !empty($userInfo['pic_small']))
{
   $img = $userInfo['pic_small'];
}

                  require_once("auth.php");

  }
