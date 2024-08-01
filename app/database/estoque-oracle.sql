CREATE TABLE categoria_produto( 
      id number(10)    NOT NULL , 
      nome varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE clientes( 
      id number(10)    NOT NULL , 
      nome varchar  (30)   , 
      email varchar  (50)   , 
      telefone varchar  (50)   , 
      endereco varchar  (50)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE itens_vendas( 
      id number(10)    NOT NULL , 
      descricao varchar  (50)   , 
      quantidade number(10)  (50)   , 
      preco_unitario number(10)  (50)   , 
      preco_total number(10)  (50)   , 
      vendas_id number(10)    NOT NULL , 
      produto_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE movimentacao( 
      id number(10)    NOT NULL , 
      produto_id number(10)    NOT NULL , 
      quantidade number(10)   , 
      data_movimentacao timestamp(0)   , 
      tipo_movimentacao_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE produto( 
      id number(10)    NOT NULL , 
      categoria_produto_id number(10)    NOT NULL , 
      nome varchar(3000)   , 
      total_estoque number(10)   , 
      valor binary_double   , 
      imagem varchar(3000)   , 
      valor_atacado binary_double  (20)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_movimentacao( 
      id number(10)    NOT NULL , 
      nome varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE vendas( 
      id number(10)    NOT NULL , 
      data_venda timestamp(0)   , 
      produto_id number(10)    NOT NULL , 
      total_venda number(10)   , 
      forma_pagamento char  (50)   , 
      vendedor varchar(3000)   , 
      lucro number(10)   , 
      faturamento number(10)   , 
      valor binary_double   , 
      nome_produto varchar(3000)   , 
      quantidade number(10)  (30)   , 
      clientes_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

 
  
 ALTER TABLE itens_vendas ADD CONSTRAINT fk_itens_vendas_1 FOREIGN KEY (vendas_id) references vendas(id); 
ALTER TABLE itens_vendas ADD CONSTRAINT fk_itens_vendas_2 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE movimentacao ADD CONSTRAINT fk_movimentacao_1 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE movimentacao ADD CONSTRAINT fk_movimentacao_2 FOREIGN KEY (tipo_movimentacao_id) references tipo_movimentacao(id); 
ALTER TABLE produto ADD CONSTRAINT fk_produto_1 FOREIGN KEY (categoria_produto_id) references categoria_produto(id); 
ALTER TABLE vendas ADD CONSTRAINT fk_vendas_1 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE vendas ADD CONSTRAINT fk_vendas_2 FOREIGN KEY (clientes_id) references clientes(id); 
 CREATE SEQUENCE categoria_produto_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER categoria_produto_id_seq_tr 

BEFORE INSERT ON categoria_produto FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT categoria_produto_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE clientes_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER clientes_id_seq_tr 

BEFORE INSERT ON clientes FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT clientes_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE itens_vendas_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER itens_vendas_id_seq_tr 

BEFORE INSERT ON itens_vendas FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT itens_vendas_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE movimentacao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER movimentacao_id_seq_tr 

BEFORE INSERT ON movimentacao FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT movimentacao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE produto_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER produto_id_seq_tr 

BEFORE INSERT ON produto FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT produto_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_movimentacao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_movimentacao_id_seq_tr 

BEFORE INSERT ON tipo_movimentacao FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT tipo_movimentacao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE vendas_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER vendas_id_seq_tr 

BEFORE INSERT ON vendas FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT vendas_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
 