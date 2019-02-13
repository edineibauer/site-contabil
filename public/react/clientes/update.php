<?php

if(empty($dados['usuario_id']) && !empty($dados['senha'])) {
    $user = [
        "nome" => $dados['razao_social'],
        "email" => $dados['email'],
        "password" => $dados['senha'],
        "setor" => 3,
        "nivel" => 1,
        "status" => $dados['ativo']
    ];

    $read = new \Conn\Read();
    $read->exeRead("usuarios", "WHERE nome = :n", "n={$user['nome']}");
    $user['nome'] = $user['nome'] . ($read->getResult() ? strtotime('now') : "");
    $user["nome_usuario"] = \Helpers\Check::name($user['nome']);

    $create = new \Conn\Create();
    $create->exeCreate("usuarios", $user);

    if($create->getResult()) {
        $dados['usuario_id'] = $create->getResult();
        $up = new \Conn\Update();
        $up->exeUpdate("clientes", $dados, "WHERE id = :id", "id={$dados['id']}");
    }
}