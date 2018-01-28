<?php
$router=App::router();
$router->before('GET','/.*',function(){
	header("Access-Control-Allow-Origin:*");
});
$router->get('/news','NewsController@news');
$router->get('/after/(\d+)','NewsController@after');

$router->mount('/admin', function() use ($router) {
    // will result in '/movies/'
    $router->match("POST|GET","/", "AdminController@login");
    $router->match("POST|GET",'/login', "AdminController@login");
    $router->get('/new', "AdminController@new");
    $router->get('edit/{int}', "AdminController@edit");
});
$router->set404(function(){
	echo "<br>This the 404 handler<br>";
});

