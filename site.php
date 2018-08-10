<?php

use \Hcode\Page;

//Rota principal
$app->get('/', function() {

	$page = new Page();

	$page->setTpl("index");

});

?>
