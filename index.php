<?php
require_once("modelo/router.php");

$roteador = new Router();

$roteador->get("/usuario", function(){
    require_once("controle/usuario/controle_usuario_read_all.php");
});

$roteador->get("/usuario/(\d+)", function($id_usuario){
    require_once("controle/usuario/controle_usuario_read_by_id.php");
});

$roteador->post("/usuario", function(){
    require_once("controle/usuario/controle_usuario_create.php");
});


$roteador->put("/usuario/(\d+)", function($id_usuario){
    require_once("controle/usuario/controle_usuario_update.php");
});

$roteador->delete("/usuario/(\d+)", function($id_usuario){
    require_once("controle/usuario/controle_usuario_delete.php");
});

$roteador->post("/login", function(){
    require_once("controle/usuario/controle_usuario_login.php");
});



$roteador->get("/jogos", function(){
    require_once("controle/jogos/controle_jogos_read_all.php");
});

$roteador->get("/jogos/(\d+)", function($id_jogo){
    require_once("controle/jogos/controle_jogos_read_by_id.php");
});

$roteador->post("/jogos", function(){
    require_once("controle/jogos/controle_jogos_create.php");
});


$roteador->put("/jogos/(\d+)", function($id_jogo){
    require_once("controle/jogos/controle_jogos_update.php");
});

$roteador->delete("/jogos/(\d+)", function($id_jogo){
    require_once("controle/jogos/controle_jogos_delete.php");
});




$roteador->get("/itens_emprestimo", function(){
    require_once("controle/itens_emprestimo/controle_itens_emprestimo_read.php");
});

$roteador->get("/itens_emprestimo/(\d+)", function($iditens_emprestimo){
    require_once("controle/itens_emprestimo/controle_itens_emprestimo_read_by_id.php");
});

$roteador->post("/itens_emprestimo", function(){
    require_once("controle/itens_emprestimo/controle_itens_emprestimo_create.php");
});


$roteador->put("/itens_emprestimo/(\d+)", function($iditens_emprestimo){
    require_once("controle/itens_emprestimo/controle_itens_emprestimo_update.php");
});

$roteador->delete("/itens_emprestimo/(\d+)", function($iditens_emprestimo){
    require_once("controle/itens_emprestimo/controle_itens_emprestimo_delete.php");
});




$roteador->get("/emprestimo_usuario", function(){
    require_once("controle/emprestimo_usuario/controle_emprestimo_usuario_read.php");
});

$roteador->get("/emprestimo_usuario/(\d+)", function($idemprestimo_usuario){
    require_once("controle/emprestimo_usuario/controle_emprestimo_usuario_read_by_id.php");
});

$roteador->post("/emprestimo_usuario", function(){
    require_once("controle/emprestimo_usuario/controle_emprestimo_usuario_create.php");
});


$roteador->put("/emprestimo_usuario/(\d+)", function($idemprestimo_usuario){
    require_once("controle/emprestimo_usuario/controle_emprestimo_usuario_update.php");
});

$roteador->delete("/emprestimo_usuario/(\d+)", function($idemprestimo_usuario){
    require_once("controle/emprestimo_usuario/controle_emprestimo_usuario_delete.php");
});




$roteador->get("/categoria_jogo", function(){
    require_once("controle/categoria_jogo/controle_categoria_jogo_read.php");
});

$roteador->get("/categoria_jogo/(\d+)", function($idcategoria_jogo){
    require_once("controle/categoria_jogo/controle_categoria_jogo_read_by_id.php");
});

$roteador->post("/categoria_jogo", function(){
    require_once("controle/categoria_jogo/controle_categoria_jogo_create.php");
});


$roteador->put("/categoria_jogo/(\d+)", function($idcategoria_jogo){
    require_once("controle/categoria_jogo/controle_categoria_jogo_update.php");
});

$roteador->delete("/categoria_jogo/(\d+)", function($idcategoria_jogo){
    require_once("controle/categoria_jogo/controle_categoria_jogo_delete.php");
});


$roteador->run();
?>