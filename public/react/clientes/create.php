<?php

if(!empty($dados['senha'])) {
    $user = [
        "nome" => $dados['razao_social'],
        "nome_usuario" => \Helpers\Check::name($dados['razao_social']),
        "email" => $dados['email'],
        "password" => $dados['senha'],
        "setor" => 3,
        "nivel" => 1,
        "status" => $dados['ativo']
    ];

    $create = new \Conn\Create();
    $create->exeCreate("usuarios", $user);
    if($create->getResult()) {
        $dados['usuario_id'] = $create->getResult();
        $up = new \Conn\Update();
        $up->exeUpdate("clientes", $dados, "WHERE id = :id", "id={$dados['id']}");
    }
}