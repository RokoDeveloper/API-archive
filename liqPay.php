<?php

function get_payment_form($price)
{
  include("class_liqPay.php");
  $public_key = '345345';
  $private_key = 'UKQb2zzf1f3EUqZNwxCwreXDX67n2X5T';


  $liqpay = new LiqPay($public_key, $private_key);
  $html = $liqpay->cnb_form(array(
  'version'        => '3',
  'action'         => 'pay',
  'amount'         => $price,
  'currency'       => 'UAH',
  'description'    => 'description text',
  'order_id'       => 'order_id_112414',
  'result_url'     => ''
  ));

  print_r($html);

}
