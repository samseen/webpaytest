<?php
/**
 * Created by PhpStorm.
 * User: Babafemi.Adigun
 * Date: 3/11/16
 * Time: 11:29 AM
 */

    $pdtid = 6205;
    $payitemid = 101;
    $currencycode = 566;
    $paytest = "https://stageserv.interswitchng.com/test_paydirect/pay";
    $paylive = "https://webpay.interswitchng.com/paydirect/pay";
    $callbackpage = "http://localhost/webpaytest/tpay.php";
    $reference = dotref();
    $mackey = "D3D1D05AFE42AD50818167EAC73C109168A0F108F32645C8B59E897FA930DA44F9230910DAC9E20641823799A107A02068F7BC0F4CC41D2952E249552255710F";
    
    function dquery($amt,$ref){
        $pdt = $GLOBALS['pdtid'];
		$thash = queryHash($ref);
        $parami = array(
            "productid"=>$GLOBALS['pdtid'],
            "transactionreference"=>$ref,
            "amount"=>$amt,
        );
        $ponmo = http_build_query($parami) . "\n";

        $query_url = 'https://stageserv.interswitchng.com/test_paydirect/api/v1/gettransaction.json';
        //$query_url = 'https://webpay.interswitchng.com/paydirect/api/v1/gettransaction.json';
        $url 	= "$query_url?productid=$pdt&transactionreference=$ref&amount=$amt";
        //note the variables appended to the url as get values for these parameters
        $headers = array(
            "GET /HTTP/1.1",
            "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1",
            "Accept-Language: en-us,en;q=0.5",
            "Keep-Alive: 300",
            "Connection: keep-alive",
            "Hash: $thash " );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt( $ch, CURLOPT_POST, false );

        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            print "Error: " . curl_error($ch);
        }
        else {
            $json = json_decode($data, TRUE);
            curl_close($ch);
            return $json;
        }


    }


    function dohash($amt1){
        $tohash = $GLOBALS['reference'].$GLOBALS['pdtid'].$GLOBALS['payitemid'].$amt1.$GLOBALS['callbackpage'].$GLOBALS['mackey'];
        $dhash =  hash('sha512',$tohash);
        return $dhash;
    }

    function queryHash($refi){
        $tryhash = $GLOBALS['pdtid'].$refi.$GLOBALS['mackey'];
        $dhash = hash('sha512', $tryhash);
        return $dhash;
    }

    function dotref (){
        $tref = mt_rand(100000,999999);
        
        return $tref;
    }
