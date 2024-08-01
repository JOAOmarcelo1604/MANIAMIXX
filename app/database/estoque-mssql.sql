CREATE TABLE categoria_produto( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE clientes( 
      id  INT IDENTITY    NOT NULL  , 
      nome varchar  (30)   , 
      email varchar  (50)   , 
      telefone varchar  (50)   , 
      endereco varchar  (50)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE itens_vendas( 
      id  INT IDENTITY    NOT NULL  , 
      descricao varchar  (50)   , 
      quantidade int  (50)   , 
      preco_unitario int  (50)   , 
      preco_total int  (50)   , 
      vendas_id int   NOT NULL  , 
      produto_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE movimentacao( 
      id  INT IDENTITY    NOT NULL  , 
      produto_id int   NOT NULL  , 
      quantidade int   , 
      data_movimentacao datetime2   , 
      tipo_movimentacao_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE produto( 
      id  INT IDENTITY    NOT NULL  , 
      categoria_produto_id int   NOT NULL  , 
      nome nvarchar(max)   , 
      total_estoque int   , 
      valor float   , 
      imagem nvarchar(max)   , 
      valor_atacado float  (20)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_movimentacao( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE vendas( 
      id  INT IDENTITY    NOT NULL  , 
      data_venda datetime2   , 
      produto_id int   NOT NULL  , 
      total_venda int   , 
      forma_pagamento char  (50)   , 
      vendedor nvarchar(max)   , 
      lucro int   , 
      faturamento int   , 
      valor float   , 
      nome_produto nvarchar(max)   , 
      quantidade int  (30)   , 
      clientes_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

 
  
 ALTER TABLE itens_vendas ADD CONSTRAINT fk_itens_vendas_1 FOREIGN KEY (vendas_id) references vendas(id); 
ALTER TABLE itens_vendas ADD CONSTRAINT fk_itens_vendas_2 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE movimentacao ADD CONSTRAINT fk_movimentacao_1 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE movimentacao ADD CONSTRAINT fk_movimentacao_2 FOREIGN KEY (tipo_movimentacao_id) references tipo_movimentacao(id); 
ALTER TABLE produto ADD CONSTRAINT fk_produto_1 FOREIGN KEY (categoria_produto_id) references categoria_produto(id); 
ALTER TABLE vendas ADD CONSTRAINT fk_vendas_1 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE vendas ADD CONSTRAINT fk_vendas_2 FOREIGN KEY (clientes_id) references clientes(id); 
