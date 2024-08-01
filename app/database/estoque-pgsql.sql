CREATE TABLE categoria_produto( 
      id  SERIAL    NOT NULL  , 
      nome text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE clientes( 
      id  SERIAL    NOT NULL  , 
      nome varchar  (30)   , 
      email varchar  (50)   , 
      telefone varchar  (50)   , 
      endereco varchar  (50)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE itens_vendas( 
      id  SERIAL    NOT NULL  , 
      descricao varchar  (50)   , 
      quantidade integer   , 
      preco_unitario integer   , 
      preco_total integer   , 
      vendas_id integer   NOT NULL  , 
      produto_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE movimentacao( 
      id  SERIAL    NOT NULL  , 
      produto_id integer   NOT NULL  , 
      quantidade integer   , 
      data_movimentacao timestamp   , 
      tipo_movimentacao_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE produto( 
      id  SERIAL    NOT NULL  , 
      categoria_produto_id integer   NOT NULL  , 
      nome text   , 
      total_estoque integer   , 
      valor float   , 
      imagem text   , 
      valor_atacado float   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_movimentacao( 
      id  SERIAL    NOT NULL  , 
      nome text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE vendas( 
      id  SERIAL    NOT NULL  , 
      data_venda timestamp   , 
      produto_id integer   NOT NULL  , 
      total_venda integer   , 
      forma_pagamento char  (50)   , 
      vendedor text   , 
      lucro integer   , 
      faturamento integer   , 
      valor float   , 
      nome_produto text   , 
      quantidade integer   , 
      clientes_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

 
  
 ALTER TABLE itens_vendas ADD CONSTRAINT fk_itens_vendas_1 FOREIGN KEY (vendas_id) references vendas(id); 
ALTER TABLE itens_vendas ADD CONSTRAINT fk_itens_vendas_2 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE movimentacao ADD CONSTRAINT fk_movimentacao_1 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE movimentacao ADD CONSTRAINT fk_movimentacao_2 FOREIGN KEY (tipo_movimentacao_id) references tipo_movimentacao(id); 
ALTER TABLE produto ADD CONSTRAINT fk_produto_1 FOREIGN KEY (categoria_produto_id) references categoria_produto(id); 
ALTER TABLE vendas ADD CONSTRAINT fk_vendas_1 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE vendas ADD CONSTRAINT fk_vendas_2 FOREIGN KEY (clientes_id) references clientes(id); 
 
 CREATE index idx_itens_vendas_vendas_id on itens_vendas(vendas_id); 
CREATE index idx_itens_vendas_produto_id on itens_vendas(produto_id); 
CREATE index idx_movimentacao_produto_id on movimentacao(produto_id); 
CREATE index idx_movimentacao_tipo_movimentacao_id on movimentacao(tipo_movimentacao_id); 
CREATE index idx_produto_categoria_produto_id on produto(categoria_produto_id); 
CREATE index idx_vendas_produto_id on vendas(produto_id); 
CREATE index idx_vendas_clientes_id on vendas(clientes_id); 
