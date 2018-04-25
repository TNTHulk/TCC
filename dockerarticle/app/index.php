<?php
session_cache_limiter(false);
session_start();
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

//opções da view
$app->view->setTemplatesDirectory('./templates');

//opçoes de log
$app->log->setEnabled( true );
$app->log->setLevel( \Slim\Log::DEBUG );

//opções de exibição de erros
//$app->config('debug', true);

$app->get( '/:link',
    function( $link ) use( $app )
    {
        $app->redirect( './#/' . $link );
    }
);

$app->get( '/logout/',
    function() use($app)
    {
        getSession($app);
        $app->redirect( '/' );
    }
);

$app->get( '/',
    function() use( $app )
    {
        if( isset( $_SESSION ) &&
           array_key_exists( 'db_user_name', $_SESSION ) && 
           array_key_exists( 'db_user_pass', $_SESSION ) && 
           array_key_exists( 'db_user_role', $_SESSION ) )
        {
            $data[ 'usuario' ] = $_SESSION[ 'db_user_name' ];
            $data[ 'papel' ]   = $_SESSION[ 'db_user_role' ];
            $app->render( 'app.php', $data );
        }
        else
        {
            $app->redirect( 'logout/' );
        }
    }
);


//API GET

$app->get( '/api/predios',
    function() use( $app )
    {
        $sql = "SELECT * FROM predio ORDER BY nome;";
        try {
            $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->query($sql);  
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            //utf8_encode_deep($data);
            echo json_encode($data); 
            
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }
);

$app->get( '/api/salas',
    function() use( $app )
    {
        $sql = "SELECT  S.id, P.nome as predio, S.nome, S.predio as id_predio, S.capacidade FROM predio AS P INNER JOIN sala AS S ON (S.predio = P.id) ORDER BY P.nome, S.id;";
        try {
            $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->query($sql);  
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            //utf8_encode_deep($data);
            echo json_encode( $data); 
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }
);

$app->get( '/api/professores',
    function() use( $app )
    {
        $sql = "SELECT * FROM professor ORDER BY nome;";
        try {
            $db = getConnection( $_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->query( $sql );  
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            //utf8_encode_deep( $data );
            echo json_encode( $data ); 
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }
);

$app->get( '/api/disciplinas',
    function() use( $app )
    {
        $sql = "SELECT * FROM disciplina ORDER BY codigo_disciplina, nome;";
        try {
            $db = getConnection( $_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->query( $sql );  
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            //utf8_encode_deep( $data );
            echo json_encode( $data ); 
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }
);


$app->get( '/api/restricoesProfessores',
    function() use( $app )
    {
        $sql = "SELECT * FROM VP;";
        try {
            $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->query($sql);  
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            //utf8_encode_deep($data);
            echo json_encode( $data); 
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }
);

$app->get( '/api/restricoesSalas',
    function() use( $app )
    {
        $sql = "SELECT * FROM VS;";
        try {
            $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->query($sql);  
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            //utf8_encode_deep($data);
            echo json_encode( $data); 
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }
);

$app->get( '/api/alocacoes',
    function() use( $app )
    {
        $sql = "SELECT PR.nome as nome_predio,PR.id as id_predio,P.nome as nome_professor, P.id as id_professor, D.nome as nome_disciplina, D.codigo_disciplina as codigo_disciplina, S.nome as nome_sala, S.id as id_sala, A.id, A.periodo, A.ano, A.idRestricao,R.diaSemana,R.horaInicio,R.horaFim,R.descricao
        from alocacao A
            inner join professor P
                ON P.id = A.professor
            inner join disciplina D
                ON D.codigo_disciplina = A.disciplina
            inner join sala S
                ON S.id = A.sala
            inner join restricao R
                ON R.id = A.idRestricao
            inner join predio PR
                ON S.predio = PR.id
        ;";
        try {
            $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->query($sql);  
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            //utf8_encode_deep($data);
            echo json_encode( $data); 
            
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }
);

$app->get('/api/buscarProfessor/:id',
    function($id) use( $app )
    {
        $sql = "select R.diaSemana,S.nome as nomesala, PE.nome as nomepredio, R.horaInicio, R.horaFim,D.nome as nomedisciplina, P.nome as nomeprofessor
from alocacao A
    inner join professor P
        on P.id = A.professor
    inner join sala S
        on S.id = A.sala
    inner join Restricao R
        on A.idRestricao = R.id
    inner join disciplina D
        on D.codigo_disciplina = A.disciplina
    inner join predio PE
        on S.predio = PE.id
where P.id = '$id' order by R.horaInicio asc;
;";
        try {
            $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->query($sql);  
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            //utf8_encode_deep($data);
            echo json_encode( $data);
            
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }
);

$app->get('/api/gerarRelatorio/:idpredio/:idsala',
    function($idsala,$idpredio) use( $app )
    {
        $sql = "
        select R.diaSemana,S.nome as nomesala, PE.nome as nomepredio, R.horaInicio, R.horaFim,D.nome as nomedisciplina, P.nome as nomeprofessor
from alocacao A
    inner join professor P
        on P.id = A.professor
    inner join sala S
        on S.id = A.sala
    inner join Restricao R
        on A.idRestricao = R.id
    inner join disciplina D
        on D.codigo_disciplina = A.disciplina
    inner join predio PE
        on S.predio = PE.id
where S.id = '$idsala' and PE.id = '$idpredio' order by R.horaInicio asc ;  ";
        try {
            $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->query($sql);  
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            //utf8_encode_deep($data);
            echo json_encode( $data);
            
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }
);


$app->get('/api/buscarDisciplina/:id',
    function($id) use( $app )
    {
        $sql = "select R.diaSemana,S.nome as nomesala, PE.nome as nomepredio, R.horaInicio, R.horaFim,D.nome as nomedisciplina, P.nome as nomeprofessor
from alocacao A
    inner join professor P
        on P.id = A.professor
    inner join sala S
        on S.id = A.sala
    inner join Restricao R
        on A.idRestricao = R.id
    inner join disciplina D
        on D.codigo_disciplina = A.disciplina
    inner join predio PE
        on S.predio = PE.id
where D.codigo_disciplina = '$id';
;";
        try {
            $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->query($sql);  
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            //utf8_encode_deep($data);
            echo json_encode( $data);
            
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }
);

$app->get( '/api/restricoesProfessores',
    function() use( $app )
    {
        $sql = "SELECT * FROM VP;";
        try {
            $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->query($sql);  
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            //utf8_encode_deep($data);
            echo json_encode( $data); 
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }
);


//API DELETE

$app->delete( '/api/predios/:id',
    function($id) use( $app )
    {   
        $sql = "DELETE FROM predio WHERE id=$id;";
        try {
            $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $db = null;
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }
);

$app->delete( '/api/salas/:id',
    function($id) use( $app )
    {   
        $sql = "DELETE FROM sala WHERE id=$id;";
        try {
            $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $db = null;
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }
);

$app->delete( '/api/professores/:id',
    function($id) use( $app )
    {   
        $sql = "DELETE FROM professor WHERE id=$id;";
        try {
            $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $db = null;
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }
);

$app->delete( '/api/disciplinas/:codigo_disciplina',
    function($codigo_disciplina) use( $app )
    {   
        $sql = "DELETE FROM disciplina WHERE codigo_disciplina='$codigo_disciplina';";
        try {
            $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $db = null;
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }
);

$app->delete( '/api/restricoesProfessores/:id',
    function($id) use( $app )
    {   
        $sql = "DELETE FROM restricao WHERE id=$id;";
        try {
            $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $db = null;
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }
);

$app->delete( '/api/restricoesSalas/:id',
    function($id) use( $app )
    {   
        $sql = "DELETE FROM restricao WHERE id=$id;";
        try {
            $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $db = null;
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }
);
//----------------------------------------------------------------------------------------------------------------------------
$app->delete( '/api/alocacoes/:id',
    function($id) use( $app )
    {   
        $sql = "SET @idRestricao := (select idRestricao from alocacao where id = $id);
                DELETE FROM restricao WHERE id=@idRestricao;";
        try {
            $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $db = null;
        } 
        catch(PDOException $e) {
            $app->flash( 'error', $e->getMessage() );
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }
);

//POST

$app->post( '/login/',
    function() use( $app )
    {
        if( isset( $_POST ) )
        {
            $db_user_name = $app->request->post( 'user' );
            $db_user_pass = $app->request->post( 'password' );
            if ( getSession( $app, $db_user_name, $db_user_pass) )
            {
                $app->flash('sucess', "conectado como $db_user_name");
                $app->redirect('/');
            }
            $app->redirect('/login');
        }
    }
);

$app->post( '/api/predios/',
    function() use( $app )
    {
        if( isset( $_POST ) )
        {   
            $id = $app->request->post( 'id' );
            $nome = $app->request->post( 'nome' );
            $descricao = $app->request->post( 'descricao' );
            
            if ($id != null)
            {
                $sql = "UPDATE predio SET nome='$nome', descricao='$descricao' WHERE id='$id';";
            }
            else
            {
                $sql = "INSERT INTO predio (nome, descricao) VALUES ('$nome', '$descricao' );";
            }
            try {
                $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $db = null;
            } 
            catch(PDOException $e) {
                $app->flash( 'error', $e->getMessage() );
                echo '{"error":{"text":'. $e->getMessage() .'}}'; 
            }
            $app->redirect('/listarPredios');
        }
        else{
            $app->flash('error', "ERRO AO SALVAR ALTERAÇÕES");
            $app->redirect('/listarPredios');
        }
    }
);

$app->post( '/api/salas/',
    function() use( $app )
    {
        if( isset( $_POST ) )
        {   
            $id = $app->request->post( 'id' );
            $nome = $app->request->post( 'nome' );
            $predio = $app->request->post( 'predio' );
            $capacidade = $app->request->post('capacidade');
            
            if ($id != null)
            {
                $sql = "UPDATE sala SET nome='$nome', predio='$predio' capacidade='$capacidade' WHERE id='$id';";
            }
            else
            {
                $sql = "INSERT INTO sala (nome, predio,capacidade) VALUES ('$nome', '$predio', '$capacidade' );";
            }
            try {
                $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $db = null;
            } 
            catch(PDOException $e) {
                $app->flash( 'error', $e->getMessage() );
                echo '{"error":{"text":'. $e->getMessage() .'}}'; 
            }
            $app->redirect('/listarSalas');
        }
        else{
            $app->flash('error', "ERRO AO SALVAR ALTERAÇÕES");
            $app->redirect('/listarSalas');
        }
    }
);

$app->post( '/api/professores/',
    function() use( $app )
    {
        if( isset( $_POST ) )
        {   
            $id = $app->request->post( 'id' );
            $nome = $app->request->post( 'nome' );
            $email = $app->request->post( 'email' );
            
            if ($id != null)
            {
                $sql = "UPDATE professor SET nome='$nome', email='$email' WHERE id='$id';";
            }
            else
            {
                $sql = "INSERT INTO professor (nome, email) VALUES ('$nome', '$email' );";
            }
            try {
                $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $db = null;
            } 
            catch(PDOException $e) {
                $app->flash( 'error', $e->getMessage() );
                echo '{"error":{"text":'. $e->getMessage() .'}}'; 
            }
            $app->redirect('/listarProfessores');
        }
        else{
            $app->flash('error', "ERRO AO SALVAR ALTERAÇÕES");
            $app->redirect('/listarProfessores');
        }
    }
);

$app->post( '/api/disciplinas/',
    function() use( $app )
    {
        if( isset( $_POST ) )
        {   
            $codigo_disciplina = $app->request->post( 'codigo_disciplina' );
            $nome = $app->request->post( 'nome' );
            $carga_horaria_semanal = $app->request->post( 'carga_horaria_semanal' );
            $id_old = $app->request->post('id_old');
            
            if ($id_old != null)
            {
                $sql = "UPDATE disciplina SET codigo_disciplina='$codigo_disciplina', nome='$nome', carga_horaria_semanal='$carga_horaria_semanal'                       WHERE codigo_disciplina='$id_old';";
            }
            else
            {
                $sql = "INSERT INTO disciplina (codigo_disciplina,nome, carga_horaria_semanal) VALUES ('$codigo_disciplina','$nome', '$carga_horaria_semanal' );";
            }
            try {
                $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $db = null;
            } 
            catch(PDOException $e) {
                $app->flash( 'error', $e->getMessage() );
                echo '{"error":{"text":'. $e->getMessage() .'}}'; 
            }
           $app->redirect('/listarDisciplinas');
        }
        else{
            $app->flash('error', "ERRO AO SALVAR ALTERAÇÕES");
            $app->redirect('/listarDisciplinas');
        }
    }
);


// editei agora testanto a alocacao e as restricoes adicionadas para professor e para sala
$app->post( '/api/alocacoes/',
    function() use( $app )
    {
        if( isset( $_POST ) )
        {   
            
            $id = $app->request->post( 'id' );
            $idr = $app->request->post( 'idrestricao' );
            $ano = $app->request->post( 'ano' );
            $periodo = $app->request->post( 'periodo' );
            $diasemana = $app->request->post( 'diasemana' );
            $sala = $app->request->post('sala');
            $professor = $app->request->post( 'professor' );
            $disciplina = $app->request->post( 'disciplina' );
            $horainicio = $app->request->post( 'horainicio' );
            $horafim = $app->request->post( 'horafim' );
            $descricao = $app->request->post( 'descricao' );
            
            if ($id != null)
            {
                $sql = "UPDATE alocacao SET sala='$sala', disciplina='$disciplina', professor='$professor', periodo = '$periodo',
                    ano = '$ano', idRestricao = '$idr'  WHERE id='$id';
                UPDATE restricao SET descricao='$descricao', diaSemana='$diasemana', horaInicio='$horainicio', horaFim = '$horafim' 
                WHERE id='$idr';
                ";  
            }
            else
            {
                $sql = "INSERT INTO restricao (descricao, diaSemana, horainicio, horafim) VALUES ('$descricao','$diasemana','$horainicio','$horafim');
SET @maxid := (select max(id) from restricao);  
INSERT INTO restricaoProfessor (professor,restricao) VALUES ('$professor', @maxid);
INSERT INTO restricaoSala (sala,restricao) VALUES ('$sala', @maxid);
INSERT INTO alocacao(sala,disciplina,professor,periodo,ano,idRestricao) VALUES ('$sala','$disciplina', '$professor','$periodo','$ano',@maxid);";
            }
            try {
                $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $db = null;
            } 
            catch(PDOException $e) {
                $app->flash( 'error', $e->getMessage() );
                echo '{"error":{"text":'. $e->getMessage() .'}}'; 
            }
            $app->redirect('/listarAlocacoes');
        }
        else{
            $app->flash('error', "ERRO AO SALVAR ALTERAÇÕES");
            $app->redirect('/listarAlocacoes');
        }
           
        
    }
);



$app->post( '/api/restricoesSalas/',
    function() use( $app )
    {
        if( isset( $_POST ) )
        {   
            $id = $app->request->post('id');
            $sala = $app->request->post( 'sala' );
            $predio = $app->request->post( 'predio' );
            $descricao = $app->request->post('descricao');
            $diasemana = $app->request->post('diasemana');
            $horainicio = $app->request->post('horainicio');
            $horafim = $app->request->post('horafim');
            
            if ($id != null)
            {
                $sql = "UPDATE restricao set descricao='$descricao', diaSemana = '$diasemana', horainicio='$horainicio', horafim = '$horafim' where id = '$id';";
            }
            else
            {
                $sql ="INSERT INTO restricao (descricao,diaSemana,horainicio,horafim) VALUES ('$descricao','$diasemana','$horainicio','$horafim');
                SET @maxid := (select max(id) from restricao);                    
                INSERT INTO restricaoSala (sala,restricao) VALUES ('$sala',@maxid);
                ";
               
            }
            try {
                $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $db = null;
            } 
            catch(PDOException $e) {
                $app->flash( 'error', $e->getMessage() );
                echo '{"error":{"text":'. $e->getMessage() .'}}'; 
            }
           $app->redirect('/listarRestricoes');
        }
        else{
            $app->flash('error', "ERRO AO SALVAR ALTERAÇÕES");
            $app->redirect('/listarRestricoes/');
        }
    }
);

$app->post( '/api/restricoesProfessores/',
    function() use( $app )
    {
        if( isset( $_POST ) )
        {   
            $id = $app->request->post('id');
            $professor = $app->request->post( 'professor' );
            $descricao = $app->request->post('descricao');
            $diasemana = $app->request->post('diasemana');
            $horainicio = $app->request->post('horainicio');
            $horafim = $app->request->post('horafim');
            
            if ($id != null)
            {
                $sql = "UPDATE restricao set descricao='$descricao', diaSemana = '$diasemana', horainicio='$horainicio', horafim = '$horafim' where id = '$id';";
            }
            else
            {
                $sql ="INSERT INTO restricao (descricao,diaSemana,horainicio,horafim) VALUES ('$descricao','$diasemana','$horainicio','$horafim');
                SET @maxid := (select max(id) from restricao);                    
                INSERT INTO restricaoProfessor (professor,restricao) VALUES ('$professor',@maxid);
                ";
               
            }
            try {
                $db = getConnection($_SESSION[ 'db_user_name' ], $_SESSION[ 'db_user_pass' ]);
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $db = null;
            } 
            catch(PDOException $e) {
                $app->flash( 'error', $e->getMessage() );
                echo '{"error":{"text":'. $e->getMessage() .'}}'; 
            }
           $app->redirect('/listarRestricoes');
        }
        else{
            $app->flash('error', "ERRO AO SALVAR ALTERAÇÕES");
            $app->redirect('/listarRestricoes/');
        }
    }
);

$app->run();


//funções auxiliares

function getSession ( &$app, $db_user_name = 'default', $db_user_pass = '12345', $db_user_role = 'estudante' )
{
    if( getConnection( $db_user_name, $db_user_pass ) != null )
    {
        // cria uma nova sessão
        if( isset( $_SESSION ) )
        {
            // remove as variáveis da sessão
            session_unset(); 
            // destroi a sessão 
            session_destroy();
        }
        session_start();
        $_SESSION[ 'db_user_name' ] = $db_user_name;
        $_SESSION[ 'db_user_pass' ] = $db_user_pass;
        $_SESSION[ 'db_user_role' ] = $db_user_role;
        $app->flash('sucess', "conectado como $db_user_name");
        return true;
    }
    else{
        //flash mensagem informando erro ao logar
        $app->flash('error', "Impossível conectar como $db_user_name. Verifique seu nome de usuário e senha.");
    }
    return false;
}

function getConnection( $db_user_name = 'default', $db_user_pass = '12345' ) 
{
    $dbhost = "127.0.0.1";
    $dbuser = $db_user_name;
    $dbpass = $db_user_pass;
    $dbname = "sishppg";
    try
    {
        $conn = new PDO( "mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass );
        $conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
    }
    catch( PDOException $e )
    {
        $e->getMessage();
        $conn = null;
    }
    return $conn;
}

/*
function utf8_encode_deep(&$input) {
    if (is_string($input)) {
        $input = utf8_encode($input);
    } else if (is_array($input)) {
        foreach ($input as &$value) {
            //utf8_encode_deep($value);
        }

        unset($value);
    } else if (is_object($input)) {
        $vars = array_keys(get_object_vars($input));

        foreach ($vars as $var) {
            //utf8_encode_deep($input->$var);
        }
    }
}
*/
