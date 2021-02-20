<?php

use \Hcode\Page;
use \Hcode\Model\Product;

$app->get('/', function(){

    $products = \Hcode\Model\Product::listAll();

    $page = new \Hcode\Page();

    $page->setTpl("index", [
        'products'=>Product::checkList($products)
    ]);

});

?>