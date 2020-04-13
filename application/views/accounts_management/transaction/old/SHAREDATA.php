<?PHP


$link="https://www.nseindia.com/live_market/dynaContent/live_watch/get_quote/getHistoricalData.jsp?symbol=SBIN&series=EQ&fromDate=14-10-2017&toDate=24-10-2018";
/*$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);
curl_close($ch);

$obj = json_decode($result);*/


//$json = file_get_contents($url);
//$obj = json_decode($json);
//print_r($obj);

$context = stream_context_create(
    array(
        "http" => array(
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
        )
    )
);

$jsonData= file_get_contents($link, false, $context);
//$jsonData   = file_get_contents($link);
 $All = array();
$dom = new DOMDocument;
$dom->loadHTML($jsonData);

$tables = $dom->getElementsByTagName('table');
$tr     = $dom->getElementsByTagName('tr'); 

foreach ($tr as $element1) {        
    for ($i = 0; $i < count($element1); $i++) {

        //Not able to fetch the user's link :(

        //$link       = $element1->getElementsByTagName('td')->item(0)->getElementsByTagName('th');    // To fetch user link
        $date       = $element1->getElementsByTagName('td')->item(0)->textContent;                  // To fetch name
        $Symbol     = $element1->getElementsByTagName('td')->item(1)->textContent;                  // To fetch height
        $Series     = $element1->getElementsByTagName('td')->item(2)->textContent;                  // To fetch weight
        $Open       = $element1->getElementsByTagName('td')->item(3)->textContent;                  // To fetch date
        $High       = $element1->getElementsByTagName('td')->item(4)->textContent;                  // To fetch info
        $Low    = $element1->getElementsByTagName('td')->item(5)->textContent;                  // To fetch country
		$Last_Traded_Price    = $element1->getElementsByTagName('td')->item(6)->textContent;  
		$Close    = $element1->getElementsByTagName('td')->item(7)->textContent;   
		$volume    = $element1->getElementsByTagName('td')->item(8)->textContent;   
		//$Low    = $element1->getElementsByTagName('td')->item(5)->textContent;    

        array_push($All, array(
            //"user_link" => $link,
            "date"      => $date,
            "Symbol"    => $Symbol,
            "Series"    => $Series,
            "Open"      => $Open,
            "High"      => $High,
            "Low"   => $Low,
			"Last_Traded_Price"   => $Last_Traded_Price,
			"Close"   => $Close,
			"volume"   => $volume
			   
        ));
    }
}

echo json_encode($All, JSON_PRETTY_PRINT);

 //$obj = json_encode($json);
//print_r($obj);



//echo $obj->access_token;




?>