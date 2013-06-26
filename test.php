<?php

header('Content-Type: application/javascript');
$result = array('bob'=> 'law',
                'iHate' => 'my life');
exit(json_encode($result));

?>
