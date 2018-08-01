<?php
header("Access-Control-Allow-Origin: *");
$data = array();

try {
	$dbh = new PDO('mysql:host=localhost;dbname=parking;charset=utf8;', 'root', '',array(PDO::ATTR_PERSISTENT => true));
	        foreach($dbh->query('SELECT * from parkings') as $row) {
			#     print_r($json_data = json_encode($row,JSON_UNESCAPED_UNICODE));
			$data[] = array($row);
				    }
	        $dbh = null;
} catch (PDOException $e) {
	    print "エラー!: " . $e->getMessage() . "<br/>";
	        die();
}

$json_data = json_encode($data,JSON_UNESCAPED_UNICODE);

echo  $json_data; 
//var_dump($json_data);
?>
