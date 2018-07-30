<a href="add.php">場所追加ページ</a>

<?php

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

//var_dump($json_data);
?>

<script>

<!-- ex. 
test[0][0] 
= {0: "1414", 1: "36.5806", 2: "136.648722", 3: "駐車場・駐輪場", 4: "駐車場", 5: "", 6: "", 7: "", 8: "", 9: "金沢駅西口時計駐車場", 10: "収容台数：1500台", 11: "920-0031", 12: "金沢市広岡1-401", 13: "076-263-5151", id: "1414", latitude: "36.5806", longitude: "136.648722", genre: "駐車場・駐輪場", name: "駐車場", …}

test[0][0][2] 
= "136.648722"
-->
var test=JSON.parse('<?php echo  $json_data; ?>');

</script>
