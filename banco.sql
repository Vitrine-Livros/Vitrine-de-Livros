/* Tabela de usuários */
CREATE TABLE usuario ( 
  id_usuario int  NOT NULL AUTO_INCREMENT, 
  email varchar(100) NOT NULL,
  senha varchar(100) NOT NULL,
  nome varchar(70) NOT NULL,
  tipo ENUM('ADMINSTRADOR', 'LEITOR') NOT NULL,
  PRIMARY KEY (id_usuario) 
);
ALTER TABLE usuario ADD CONSTRAINT uk_usuario UNIQUE(email);

CREATE TABLE genero ( 
  id_genero  int  NOT NULL AUTO_INCREMENT,  
  nome varchar(45) NOT NULL, 
  PRIMARY KEY (id_genero) 
);

/* Inserir os gêneros */
INSERT INTO genero (nome) VALUES ('Ação');
INSERT INTO genero (nome) VALUES ('Aventura');
INSERT INTO genero (nome) VALUES ('Fantasia');
INSERT INTO genero (nome) VALUES ('Drama');
INSERT INTO genero (nome) VALUES ('Terror');
INSERT INTO genero (nome) VALUES ('Artes Marciais');
INSERT INTO genero (nome) VALUES ('Comedia');
INSERT INTO genero (nome) VALUES ('Comedia Romantica');
INSERT INTO genero (nome) VALUES ('Drama');
INSERT INTO genero (nome) VALUES ('Romance');
INSERT INTO genero (nome) VALUES ('Ficção Científica');

CREATE TABLE livro ( 
  id_livro int  NOT NULL AUTO_INCREMENT,
  nome varchar(100) NOT NULL, 
  autores varchar(200) NOT NULL, 
  ano_lancamento INT NOT NULL,
  editora varchar(45) NOT NULL,
  id_genero int NOT NULL,
  foto varchar(100) NOT NULL,
  link_compra varchar(200) NOT NULL,
  resumo TEXT,
  PRIMARY KEY (id_livro) 
);
ALTER TABLE livro ADD CONSTRAINT fk_livro_genero 
FOREIGN KEY (id_genero) REFERENCES genero (id_genero);

CREATE TABLE livro_curtido ( 
  id_livro_curtido int NOT NULL AUTO_INCREMENT, 
  id_livro int NOT NULL, 
  id_usuario int NOT NULL,
  data DATE NOT NULL,
  PRIMARY KEY (id_livro_curtido) 
);
ALTER TABLE livro_curtido ADD CONSTRAINT fk_livro_curtido_livro 
FOREIGN KEY (id_livro) REFERENCES livro (id_livro);
ALTER TABLE livro_curtido ADD CONSTRAINT fk_livro_curtido_usuario 
FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario);
ALTER TABLE livro_curtido ADD CONSTRAINT uk_livro_curtido
UNIQUE (id_livro, id_usuario);

CREATE TABLE livro_lido ( 
  id_livro_lido int AUTO_INCREMENT, 
  id_livro int NOT NULL, 
  id_usuario int NOT NULL,
  data_atualizacao DATE NOT NULL,
  comentarios TEXT,
  avaliacao INT,
  PRIMARY KEY (id_livro_lido) 
);
ALTER TABLE livro_lido ADD CONSTRAINT fk_livro_lido_livro 
FOREIGN KEY (id_livro) REFERENCES livro (id_livro);
ALTER TABLE livro_lido ADD CONSTRAINT fk_livro_lido_usuario 
FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario);
ALTER TABLE livro_lido ADD CONSTRAINT uk_livro_lido
UNIQUE (id_livro, id_usuario);



