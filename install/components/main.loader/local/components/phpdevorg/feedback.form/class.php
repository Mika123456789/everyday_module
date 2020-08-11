<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
class CPhphdevorgFeedbackForm extends CBitrixComponent{
	public function sendToAmoCRM ($post){
		$data = $post;
		$data['cookies'] = $_COOKIE;
		// $data['server'] = @$_SERVER; // это опционально
		file_get_contents('https://b2b.rocketcrm.bz/api/channels/site/form?hash=43f5c80d18', false, stream_context_create(
			array(
				'http' => array(
					'method'  => 'POST',
					'header'  => implode("\r\n", [
							'Content-type: application/x-www-form-urlencoded'
						]) . "\r\n",
					'content' => http_build_query($data),
					'timeout' => 10
				)
			)
		));
	}
}