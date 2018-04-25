DROP DATABASE IF EXISTS sishppg;
CREATE DATABASE sishppg;
USE sishppg;

CREATE USER  'aluno'@'localhost' IDENTIFIED BY '12345' ;
GRANT ALL PRIVILEGES ON sishppg.* TO 'aluno'@'localhost' WITH GRANT OPTION;
CREATE USER  'professor'@'localhost' IDENTIFIED BY '12345' ;
GRANT ALL PRIVILEGES ON sishppg.* TO 'professor'@'localhost' WITH GRANT OPTION;
CREATE USER  'coordenador'@'localhost' IDENTIFIED BY '12345' ;
GRANT ALL PRIVILEGES ON sishppg.* TO 'coordenador'@'localhost' WITH GRANT OPTION;
CREATE USER  'secretario'@'localhost' IDENTIFIED BY '12345' ;
GRANT ALL PRIVILEGES ON sishppg.* TO 'secretario'@'localhost' WITH GRANT OPTION;


CREATE TABLE predio(
    id INTEGER NOT NULL AUTO_INCREMENT,
    nome VARCHAR(45) NOT NULL,
    descricao VARCHAR(200) NOT NULL,
    PRIMARY KEY (id)
);



CREATE TABLE sala(
    id INTEGER NOT NULL AUTO_INCREMENT,
    nome VARCHAR(45) NOT NULL,
    predio INTEGER NOT NULL,
    PRIMARY KEY (id)
);



CREATE TABLE professor(
    id INTEGER NOT NULL AUTO_INCREMENT,
    nome VARCHAR(45) NOT NULL,
    email VARCHAR(45) NOT NULL,
    PRIMARY KEY (id)
);



CREATE TABLE disciplina(
    codigo_disciplina VARCHAR(10) NOT NULL,
    nome VARCHAR(45) NOT NULL,
    carga_horaria_semanal INTEGER NOT NULL,
    PRIMARY KEY (codigo_disciplina)
);




CREATE TABLE restricao(
    id INTEGER NOT NULL AUTO_INCREMENT,
    descricao VARCHAR(100) NOT NULL,
    diaSemana INTEGER NOT NULL,
    horaInicio TIME NOT NULL,
    horaFim TIME NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE restricaoSala(
    id INTEGER NOT NULL AUTO_INCREMENT,
    sala INTEGER NOT NULL,
    restricao INTEGER NOT NULL,
    PRIMARY KEY (id)
);


CREATE TABLE restricaoProfessor(
    id INTEGER NOT NULL AUTO_INCREMENT,
    professor INTEGER NOT NULL,
    restricao INTEGER NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE alocacao(
    id INTEGER NOT NULL AUTO_INCREMENT,
    sala INTEGER NOT NULL,
    disciplina VARCHAR(10) NOT NULL,
    professor INTEGER NOT NULL,
    periodo INTEGER NOT NULL,
    ano YEAR NOT NULL,
    idRestricao INTEGER NOT NULL,
    PRIMARY KEY(id)
);

ALTER TABLE alocacao ADD CONSTRAINT fk_grade_sala
    FOREIGN KEY (sala) REFERENCES sala (id) ON UPDATE CASCADE ON DELETE CASCADE,
    ADD CONSTRAINT fk_grade_professor_idx
    FOREIGN KEY (professor) REFERENCES professor (id) ON UPDATE CASCADE ON DELETE CASCADE,
    ADD CONSTRAINT fk_grade_disciplina_idx
    FOREIGN KEY (disciplina) REFERENCES disciplina (codigo_disciplina) ON UPDATE CASCADE ON DELETE CASCADE,
    ADD CONSTRAINT fk_restricao_p
        FOREIGN KEY (idRestricao) REFERENCES restricao(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER  TABLE restricaoProfessor ADD CONSTRAINT fk_professor_restricao
    FOREIGN KEY (professor) REFERENCES professor (id) ON UPDATE CASCADE ON DELETE CASCADE,
    ADD CONSTRAINT fk_restricao_professor
    FOREIGN KEY (professor) REFERENCES professor (id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE restricaoSala ADD CONSTRAINT fk_sala_restricao
    FOREIGN KEY (sala) REFERENCES sala (id) ON UPDATE CASCADE ON DELETE CASCADE,
    ADD CONSTRAINT fk_restricao_sala
    FOREIGN KEY (restricao) REFERENCES restricao (id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE sala  ADD CONSTRAINT fk_predio 
    FOREIGN KEY (predio) REFERENCES predio (id) ON UPDATE CASCADE ON DELETE CASCADE;

CREATE VIEW VS as 
SELECT R.id,S.id as idsala,P.nome as predio, S.nome as sala, R.descricao,R.diaSemana, R.horainicio, R.horafim from Predio P 
    inner join sala S
        on S.predio = P.id
    inner join restricaosala RS
        on RS.sala = S.id
    inner join restricao R
        on RS.restricao = R.id;


CREATE VIEW VP as 
SELECT R.id,P.id as idprofessor,P.nome as professor, R.descricao,R.diaSemana, R.horainicio, R.horafim from professor P 
    inner join restricaoProfessor RP
        on P.id = RP.professor
    inner join restricao R
        on RP.restricao = R.id;


INSERT INTO disciplina VALUES ('VET1234', 'Genética', 4 );
INSERT INTO disciplina VALUES ('COM0001', 'Redes', 4 );
INSERT INTO disciplina VALUES ('ENQ1000', 'Metodologia', 3 );
INSERT INTO professor (nome, email) VALUES ('José Carioca', 'jcarioca@ufes.br' );
INSERT INTO professor (nome, email) VALUES ('Maria Mercedes', 'mmercedes@ufes.br' );
INSERT INTO professor (nome, email) VALUES ('Maria do Bairro', 'from_morro@ufes.br' );
INSERT INTO predio (nome, descricao) VALUES ('Prédio Novo', 'Prédio Novo' );
INSERT INTO predio (nome, descricao) VALUES ('Prédio Central', 'Prédio Central' );
INSERT INTO predio (nome, descricao) VALUES ('REUNI', 'Prédio de laboratórios dos cursos do REUNI' );
INSERT INTO predio (nome, descricao) VALUES ('Geologia', 'Prédio da graduação em Geologia' );
INSERT INTO predio (nome, descricao) VALUES ('Nutrição', 'Prédio da graduação em Nutrição' );
INSERT INTO sala (nome, predio) VALUES ('Sala 1', 1 );
INSERT INTO sala (nome, predio) VALUES ('Sala 2', 1 );
INSERT INTO sala (nome, predio) VALUES ('Sala 3', 1 );
INSERT INTO sala (nome, predio) VALUES ('Sala 4', 1 );
INSERT INTO sala (nome, predio) VALUES ('Sala 5', 1 );
INSERT INTO sala (nome, predio) VALUES ('Sala 6', 1 );
INSERT INTO sala (nome, predio) VALUES ('Sala 7', 1 );
INSERT INTO sala (nome, predio) VALUES ('Sala 8', 1 );
INSERT INTO sala (nome, predio) VALUES ('Sala 9', 1 );
INSERT INTO sala (nome, predio) VALUES ('Sala 10', 1 );
INSERT INTO sala (nome, predio) VALUES ('Sala 11', 1 );
INSERT INTO sala (nome, predio) VALUES ('Sala 12', 1 );
insert into restricao values(1,'exemplo sala',7,'12:00','14:00');
insert into restricao values(2,'diarréia',7,'13:00','20:00');
insert into restricao values(3,'aula porno',2,'08:00','20:00');
insert into restricaoProfessor(professor,restricao) values (2,1);
insert into restricaoProfessor(professor,restricao) values (3,2);
insert into restricaoSala(sala,restricao) values (2,3);

UPDATE restricao set descricao="teste", diaSemana = 2, horainicio="9:00", horafim = "12:00" where id = 3;
INSERT INTO restricao (descricao,diaSemana,horainicio,horafim) VALUES ('teste2','3','10:00','11:00');
SET @maxid := (select max(id) from restricao);             
INSERT INTO restricaoSala (sala,restricao) VALUES ('2',@maxid);


INSERT INTO restricao (descricao,diaSemana,horainicio,horafim) VALUES ('testando alocacao Sala','2','20:00','21:00');
SET @maxid := (select max(id) from restricao);  
INSERT INTO restricaoProfessor (professor,restricao) VALUES ('1',@maxid);
INSERT INTO restricaoSala (sala,restricao) VALUES ('1',@maxid);
INSERT INTO alocacao(sala,disciplina,professor,periodo,ano,idRestricao) VALUES ('1','COM0001', '1','2','2010',@maxid); 





/*
Select distinct P.nome as nomep,D.nome as nomed,RR.horaInicio,RR.horaFim,RR.descricao,RR.diaSemana,A.ano,A.sala,A.periodo from  alocacao A
    inner join sala S
        on A.sala = S.id
    inner join disciplina D
        on A.disciplina = D.codigo_disciplina
    inner join professor P
        on A.professor = P.id
    inner join restricaoProfessor RP
        on RP.professor = P.id
    inner join restricaoSala RS
        on RS.sala = S.id 
    inner join restricao RR
        on RR.id = RS.restricao and RR.id = RP.restricao
    where RR.id not in (select id from restricaoSala) and  RR.id not in (select id from restricaoProfessor) ;
*/

select R.diaSemana,S.nome as nomesala, PE.nome as nomepredio, R.horaInicio, R.horaFim,D.nome as nomedisciplina, P.nome as nomeprofessor
from alocacao A
    inner join professor P
        on P.id = A.professor
    inner join sala S
        on S.id = A.sala
    inner join restricao R
        on A.idRestricao = R.id
    inner join disciplina D
        on D.codigo_disciplina = A.disciplina
    inner join predio PE
        on S.predio = PE.id
where P.id = '$professor';


/*SELECT PR.nome as nome_predio,P.nome as nome_professor, P.id as id_professor, D.nome as nome_disciplina, D.codigo_disciplina as codigo_disciplina, S.nome as nome_sala, S.id as id_sala, A.id, A.periodo, A.ano, A.idRestricao,R.diaSemana,R.horaInicio,R.horaFim,R.descricao
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
        ;
*/
