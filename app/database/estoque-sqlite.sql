PRAGMA foreign_keys=OFF; 

CREATE TABLE categoria_produto( 
      id  INTEGER    NOT NULL  , 
      nome text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE clientes( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (30)   , 
      email varchar  (50)   , 
      telefone varchar  (50)   , 
      endereco varchar  (50)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE itens_vendas( 
      id  INTEGER    NOT NULL  , 
      descricao varchar  (50)   , 
      quantidade int  (50)   , 
      preco_unitario int  (50)   , 
      preco_total int  (50)   , 
      vendas_id int   NOT NULL  , 
      produto_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(vendas_id) REFERENCES vendas(id),
FOREIGN KEY(produto_id) REFERENCES produto(id)) ; 

CREATE TABLE movimentacao( 
      id  INTEGER    NOT NULL  , 
      produto_id int   NOT NULL  , 
      quantidade int   , 
      data_movimentacao datetime   , 
      tipo_movimentacao_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(produto_id) REFERENCES produto(id),
FOREIGN KEY(tipo_movimentacao_id) REFERENCES tipo_movimentacao(id)) ; 

CREATE TABLE produto( 
      id  INTEGER    NOT NULL  , 
      categoria_produto_id int   NOT NULL  , 
      nome text   , 
      total_estoque int   , 
      valor double   , 
      imagem text   , 
      valor_atacado double  (20)   , 
 PRIMARY KEY (id),
FOREIGN KEY(categoria_produto_id) REFERENCES categoria_produto(id)) ; 

CREATE TABLE tipo_movimentacao( 
      id  INTEGER    NOT NULL  , 
      nome text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE vendas( 
      id  INTEGER    NOT NULL  , 
      data_venda datetime   , 
      produto_id int   NOT NULL  , 
      total_venda int   , 
      forma_pagamento char  (50)   , 
      vendedor text   , 
      lucro int   , 
      faturamento int   , 
      valor double   , 
      nome_produto text   , 
      quantidade int  (30)   , 
      clientes_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(produto_id) REFERENCES produto(id),
FOREIGN KEY(clientes_id) REFERENCES clientes(id)) ; 

 
 