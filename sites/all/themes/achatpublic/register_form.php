<?php

echo(ini_get('include_path'));
if(isset($_POST)){
	extract($_POST);
}
if(isset($_GET)){
	extract($_GET);
}

if(trim($nom) != '' && trim($organisme) != '' && trim($telephone) != '' && trim($email) != '' && trim($cp) != ''){
	$result = db_query_range('SELECT n.nid, n.title, n.created
FROM {node} n WHERE n.uid = %d', $uid, 0, 10);
while ($node = db_fetch_object($result)) {
// Perform operations on $node->body, etc. here.
echo 'test';
  }

}

?>