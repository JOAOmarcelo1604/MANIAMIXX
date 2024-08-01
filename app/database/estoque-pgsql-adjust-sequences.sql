SELECT setval('categoria_produto_id_seq', coalesce(max(id),0) + 1, false) FROM categoria_produto;
SELECT setval('clientes_id_seq', coalesce(max(id),0) + 1, false) FROM clientes;
SELECT setval('itens_vendas_id_seq', coalesce(max(id),0) + 1, false) FROM itens_vendas;
SELECT setval('movimentacao_id_seq', coalesce(max(id),0) + 1, false) FROM movimentacao;
SELECT setval('produto_id_seq', coalesce(max(id),0) + 1, false) FROM produto;
SELECT setval('tipo_movimentacao_id_seq', coalesce(max(id),0) + 1, false) FROM tipo_movimentacao;
SELECT setval('vendas_id_seq', coalesce(max(id),0) + 1, false) FROM vendas;