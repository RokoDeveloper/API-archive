<?php 


function getPaymentForm($type,$order)
{
  $order_id = $order['id'];
  $formid = genFormID();

	$title = 'title';
  $url = 'http://'._SITE.'/personal/olympiad/';
  $price = 100;

  $merchant_id = _PAYBOX_MERCHANT_ID;
  $secret_code = _PAYBOX_SECRET_CODE;

// saltd1 - get salt on api documents

  $pg_sig = md5('paybox.php;'.$price.';'.$title.';'.$merchant_id.';'.$order_id.';saltd1;'.$url.';'.$secret_code);

          echo "<form id='" . $formid  . "' name='" . $formid  . "' method='GET' action='https://www.paybox.kz/payment.php'>
            <input type='hidden' name='pg_description' value='".$title."' />
            <input type='hidden' name='pg_salt' value='saltd1' />
            <input type='hidden' name='pg_merchant_id' value='".$merchant_id."' />
            <input type='hidden' name='pg_amount' value='".$price."' />
            <input type='hidden' name='pg_order_id' value='".$order_id."' />
            <input type='hidden' name='pg_success_url' value='".$url."' />
            <input type='hidden' name='pg_sig' value='".$pg_sig."' />
          </form>";;

	return $formid ;

}
