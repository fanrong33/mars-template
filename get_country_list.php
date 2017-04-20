<?php
file_put_contents('1.txt', http_build_query($_REQUEST));

$list = array(
    array('name'=>'Antarctica', 'value'=>'AQ'),
);

echo json_encode($list);

