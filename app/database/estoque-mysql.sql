CREATE TABLE categoria_produto( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE clientes( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` varchar  (30)   , 
      `email` varchar  (50)   , 
      `telefone` varchar  (50)   , 
      `endereco` varchar  (50)   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE itens_vendas( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `descricao` varchar  (50)   , 
      `quantidade` int   , 
      `preco_unitario` int   , 
      `preco_total` int   , 
      `vendas_id` int   NOT NULL  , 
      `produto_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE movimentacao( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `produto_id` int   NOT NULL  , 
      `quantidade` int   , 
      `data_movimentacao` datetime   , 
      `tipo_movimentacao_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE produto( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `categoria_produto_id` int   NOT NULL  , 
      `nome` text   , 
      `total_estoque` int   , 
      `valor` double   , 
      `imagem` text   , 
      `valor_atacado` double   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE tipo_movimentacao( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE vendas( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `data_venda` datetime   , 
      `produto_id` int   NOT NULL  , 
      `total_venda` int   , 
      `forma_pagamento` char  (50)   , 
      `vendedor` text   , 
      `lucro` int   , 
      `faturamento` int   , 
      `valor` double   , 
      `nome_produto` text   , 
      `quantidade` int   , 
      `clientes_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

 
  
 ALTER TABLE itens_vendas ADD CONSTRAINT fk_itens_vendas_1 FOREIGN KEY (vendas_id) references vendas(id); 
ALTER TABLE itens_vendas ADD CONSTRAINT fk_itens_vendas_2 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE movimentacao ADD CONSTRAINT fk_movimentacao_1 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE movimentacao ADD CONSTRAINT fk_movimentacao_2 FOREIGN KEY (tipo_movimentacao_id) references tipo_movimentacao(id); 
ALTER TABLE produto ADD CONSTRAINT fk_produto_1 FOREIGN KEY (categoria_produto_id) references categoria_produto(id); 
ALTER TABLE vendas ADD CONSTRAINT fk_vendas_1 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE vendas ADD CONSTRAINT fk_vendas_2 FOREIGN KEY (clientes_id) references clientes(id); 
