<?php
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
$app = new \Slim\Slim();

$app->config('debug', true);

//Rota principal
$app->get('/', function() {

	$page = new Page();

	$page->setTpl("index");

});

//Rota admin
$app->get("/admin", function() {

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("index");

});

//rota loginAdmin
$app->get("/admin/login", function(){
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("login");
});

//Rota de login admin POST
$app->post("/admin/login", function(){

	User::login($_POST["login"], $_POST["password"]);

	header("Location: /admin");
	exit;
});

//rota de logout admin
$app->get("/admin/logout", function(){
	User::logout();
	header("Location: /admin/login");
	exit;
});

//
$app->get("/admin/users", function(){
	User::verifyLogin();

	$users = User::listAll();

	$page = new PageAdmin();

	$page->setTpl("users", array(
		"users"=>$users
	));
});
//tela de listar usuários
$app->get("/admin/users/create", function(){
	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-create");
});

//deletar usuarios
$app->get("/admin/users/:iduser/delete", function($iduser){
	User::verifyLogin();
});
//alterar usuarios
$app->get("/admin/users/:iduser", function($iduser){
	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-update");
});

//salvar usuarios no banco
$app->post("/admin/users/create", function(){
	User::verifyLogin();
});

$app->post("/admin/users/:iduser", function($iduser){
	User::verifyLogin();
});



$app->run();

 ?>
