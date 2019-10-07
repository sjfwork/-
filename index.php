<?php

stream_context_set_default( [
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]);
stream_context_set_default(
    array(
        'http' => array(
            'method' => 'POST'
        )
    )
);

	$urlLogin = 'https://pub.fsa.gov.ru/login';
	$urlItems = 'https://pub.fsa.gov.ru/api/v1/rss/common/certificates/get';
	$LoginBody = '{"username":"","password":""}';
	$itemsBody = '{"size":10,"page":0,"filter":{"idTechReg":[11],"regDate":{"minDate":"","maxDate":""},"endDate":{"minDate":"","maxDate":"2019-09-01T00:00:00.000Z"},"columnsSearch":[]},"columnsSort":[{"column":"date","sort":"DESC"}]}';

	$headers=get_headers($urlLogin,1);
	$Cookie=explode(";", $headers['Set-Cookie']);
	$ch = curl_init($urlLogin);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $LoginBody);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'Host: pub.fsa.gov.ru',
	'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:61.0) Gecko/20100101 Firefox/61.0',
	'Accept: application/json, text/plain, */*',
	'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
	'Accept-Encoding: gzip, deflate, br',
	'Referer: https://pub.fsa.gov.ru/rss/certificate',
	'Authorization: Bearer null',
	'Pragma: no-cache',
	'Cache-Control: no-cache',
	'Content-Type: application/json',
	'Content-Length: '.strlen($LoginBody),
	'Cookie: '.$Cookie[0],
	'Connection: keep-alive'
	));
	$result = curl_exec($ch);
	if($errno = curl_errno($ch)) {
	    $error_message = curl_strerror($errno);
	    echo "cURL error ({$errno}):\n {$error_message}";
	}
	curl_close($ch);
	$result2=json_decode($result,true);
    $headersAll = array();
    $header_text = substr($result, 0, strpos($result, "\r\n\r\n"));
	foreach (explode("\r\n", $header_text) as $i => $line)
        if ($i === 0)
            $headersAll['http_code'] = $line;
        else
        {
            list ($key, $value) = explode(': ', $line);

            $headersAll[$key] = $value;
        }

    $headers=get_headers($urlItems,1);
	$Cookie=explode(";", $headers['Set-Cookie']);
	$ch = curl_init($urlItems);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $itemsBody);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'Host: pub.fsa.gov.ru',
	'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:61.0) Gecko/20100101 Firefox/61.0',
	'Accept: application/json, text/plain, */*',
	'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
	'Accept-Encoding: gzip, deflate, br',
	'Referer: https://pub.fsa.gov.ru/rss/certificate',
	'Authorization: '.$headersAll['Authorization'],
	'Pragma: no-cache',
	'Cache-Control: no-cache',
	'Content-Type: application/json',
	'Content-Length: '.strlen($itemsBody),
	'Cookie: '.$Cookie[0],
	'Connection: keep-alive'
	));
	$result = curl_exec($ch);
	if($errno = curl_errno($ch)) {
	    $error_message = curl_strerror($errno);
	    echo "cURL error ({$errno}):\n {$error_message}";
	}
	curl_close($ch);
	print_r($result);
//https://pub.fsa.gov.ru/api/v1/rss/common/certificates/2360455



 

?>

