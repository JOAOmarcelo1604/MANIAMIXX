SET IDENTITY_INSERT categoria_produto ON; 

INSERT INTO categoria_produto (id,nome) VALUES (1,'Eletronicos'); 

INSERT INTO categoria_produto (id,nome) VALUES (2,'Informática'); 

SET IDENTITY_INSERT categoria_produto OFF; 

SET IDENTITY_INSERT tipo_movimentacao ON; 

INSERT INTO tipo_movimentacao (id,nome) VALUES (1,'Entrada'); 

INSERT INTO tipo_movimentacao (id,nome) VALUES (2,'Saída'); 

SET IDENTITY_INSERT tipo_movimentacao OFF; 
