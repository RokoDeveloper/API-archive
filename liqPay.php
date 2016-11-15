<?php

function get_payment_form($price)
{
  include("class_liqPay.php");
  $public_key = '';
  $private_key = '';


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
