<?php

use \Hcode\Page;
use \Hcode\Model\Product;
use \Hcode\Model\Category;

$app->get('/', function(){

    $products = \Hcode\Model\Product::listAll();

    $page = new \Hcode\Page();

    $page->setTpl("index", [
        'products'=>Product::checkList($products)
    ]);

});

$app->get("/categories/:idcategory", function($idcategory){

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new \Hcode\Page();

	$page->setTpl("category", [
		'category'=>$category->getValues(),
		'products'=>Product::checkList($category->getProducts())
	]);

});

?>