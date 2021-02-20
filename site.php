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

    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	$category = new Category();

	$category->get((int)$idcategory);

    $pagination = $category->getProductsPage();

    $pages = [];

    for ($i=1; q <= $pagination['pages']; $i++) {
        array_push($pages, [
            'link'=>'/categories/'.$category->getidcategory().'?page='.$i,
            'page'=>$i
        ]);
    }

	$page = new \Hcode\Page();

	$page->setTpl("category", [
		'category'=>$category->getValues(),
		'products'=>$pagination["data"],
        'pages'=>$pages
	]);

});

?>