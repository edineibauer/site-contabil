if(!isEmpty(dados.senha)) {
    dbLocal.exeRead("usuarios", dados.id).then(d => {
        console.log(d);
        if(typeof d === "undefined") {
            let user = {
                "nome": dados.razao_social,
                "email": dados.email,
                "password": dados.senha,
                "setor": 2,
                "nivel": 1,
                "status": dados.ativo,
                "usuario_id": dados.id
            };

            db.exeCreate("usuarios", user);
        }
    })
}