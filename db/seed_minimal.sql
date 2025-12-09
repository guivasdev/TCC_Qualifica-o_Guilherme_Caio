
INSERT INTO organizacao (nome, sigla) VALUES ('Org Exemplo', 'OE');
INSERT INTO nucleo_institucional (nome, sigla) VALUES ('Núcleo Exemplo', 'NEX');
INSERT INTO curso (nome) VALUES ('Curso Exemplo');
INSERT INTO integrante (nome, cargo_id) VALUES ('Integrante Exemplo', NULL);
INSERT INTO localizacao (nome) VALUES ('Sala 100');

INSERT INTO predefinicoes (nome, organizacao_id, dia, hora, prefacio, introducao, assunto, encerramento) VALUES ('Template Padrão', 1, CURDATE(), '09:00:00', 'Prefácio', 'Introdução', 'Assuntos', 'Encerramento');

-- documento de exemplo (com `predefinicao_id` referenciando a predefinicao criada)
INSERT INTO documento (titulo, data, hora_inicio, hora_final, prefacio, introducao, assunto, encerramento, organizacao_id, nucleo_id, curso_id, local_id, conteudo, predefinicao_id) VALUES ('ATA Exemplo', CURDATE(), '09:00:00', '10:00:00', 'Prefácio ATA', 'Introdução ATA', 'Assuntos ATA', 'Encerramento ATA', 1, 1, 1, 1, 'Conteúdo de teste', 1);

-- associar integrante(s) ao documento na join table
INSERT INTO documento_integrante (documento_id, integrante_id) VALUES (LAST_INSERT_ID(), 1);
