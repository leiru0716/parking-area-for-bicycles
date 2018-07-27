<a href="add.php">場所追加ページ</a>

<?php
try {
	$dbh = new PDO('mysql:host=localhost;dbname=parking;charset=utf8;', 'root', '',array(PDO::ATTR_PERSISTENT => true));
	        foreach($dbh->query('SELECT * from parkings') as $row) {
			        print_r($json_data = json_encode($row,JSON_UNESCAPED_UNICODE));
				    }
	        $dbh = null;
} catch (PDOException $e) {
	    print "エラー!: " . $e->getMessage() . "<br/>";
	        die();
}
?>

<script>
var test=JSON.parse('<?php echo  $json_data; ?>');

</script>
