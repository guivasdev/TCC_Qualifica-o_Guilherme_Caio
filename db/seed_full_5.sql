-- Full seed with 5 test rows for main tables + join tables + predefinicoes + documento
-- WARNING: Run only in dev/test environment and backup before applying in production

-- Order of execution matters due to FK constraints.

-- 1) cargos
INSERT INTO cargo (nome, sigla) VALUES
('Presidente', 'PRES'),
('Secretário', 'SEC'),
('Membro', 'MEM'),
('Convidado', 'CONV'),
('Suplente', 'SUP');

-- 2) cursos
INSERT INTO curso (nome) VALUES
('Engenharia de Software'),
('Ciência da Computação'),
('Design'),
('Administração'),
('Matemática Aplicada');

-- 3) locais (localizacao)
INSERT INTO localizacao (nome) VALUES
('Sala 101'),
('Sala 202'),
('Auditório Central'),
('Laboratório 3'),
('Sala Virtual - Zoom');

-- 4) organizacoes
INSERT INTO organizacao (nome) VALUES
('Diretoria Acadêmica'),
('Coordenação de Curso A'),
('Coordenação de Curso B'),
('Comissão de Pesquisa'),
('Centro Estudantil');

-- 5) núcleos institucionais
INSERT INTO nucleo_institucional (nome, sigla) VALUES
('Núcleo de Tecnologia', 'NT'),
('Núcleo de Pesquisa', 'NP'),
('Núcleo de Extensão', 'NE'),
('Núcleo de Ensino', 'NEE'),
('Núcleo de Inovação', 'NI');

-- 6) integrantes (associados a cargos)
INSERT INTO integrante (nome, cargo_id) VALUES
('Ana Silva', 1),
('Bruno Santos', 2),
('Carla Pereira', 3),
('Daniel Oliveira', 4),
('Eduarda Costa', 5);

-- 7) Join tables: organizar relações entre orgs/núcleos/cursos/integrantes/locais
-- organizacao_integrante (organização -> integrante)
INSERT INTO organizacao_integrante (organizacao_id, integrante_id) VALUES
(1,1),(1,2),(2,3),(3,4),(4,5);

-- nucleo_integrante (nucleo -> integrante)
INSERT INTO nucleo_integrante (nucleo_id, integrante_id) VALUES
(1,1),(2,2),(3,3),(4,4),(5,5);

-- organizacao_curso (org -> curso)
INSERT INTO organizacao_curso (organizacao_id, curso_id) VALUES
(1,1),(2,2),(2,3),(3,4),(4,5);

-- organizacao_nucleo (org -> nucleo)
INSERT INTO organizacao_nucleo (organizacao_id, nucleo_id) VALUES
(1,1),(1,2),(2,3),(3,4),(4,5);

-- organizacao_local (org -> localizacao)
INSERT INTO organizacao_local (organizacao_id, local_id) VALUES
(1,1),(2,2),(3,3),(4,4),(5,5);

-- 8) predefinicoes (templates) — ligar a organizacao / nucleo / curso / local; integrantes estão na join table
INSERT INTO predefinicoes (nome, organizacao_id, nucleo_id, curso_id, local_id, dia, hora, prefacio, introducao, assunto, encerramento) VALUES
('Template Geral - 1', 1, 1, 1, 1, CURDATE(), '09:00:00', 'Prefácio T1', 'Introdução T1', 'Assuntos T1', 'Encerramento T1'),
('Template Geral - 2', 2, 2, 2, 2, CURDATE(), '10:00:00', 'Prefácio T2', 'Introdução T2', 'Assuntos T2', 'Encerramento T2'),
('Template Geral - 3', 3, 3, 3, 3, CURDATE(), '11:00:00', 'Prefácio T3', 'Introdução T3', 'Assuntos T3', 'Encerramento T3'),
('Template Geral - 4', 4, 4, 4, 4, CURDATE(), '14:00:00', 'Prefácio T4', 'Introdução T4', 'Assuntos T4', 'Encerramento T4'),
('Template Geral - 5', 5, 5, 5, 5, CURDATE(), '15:00:00', 'Prefácio T5', 'Introdução T5', 'Assuntos T5', 'Encerramento T5');

-- 9) documento (ATAs) — usar os registros criados acima (assume IDs em ordem de inserção)
INSERT INTO documento (titulo, nome, data, hora_inicio, hora_final, prefacio, introducao, assunto, encerramento, organizacao_id, nucleo_id, curso_id, local_id, conteudo, predefinicao_id) VALUES
('ATA 2025-01', 'Reunião 01', CURDATE(), '09:00:00', '10:00:00', 'Prefacio A1', 'Intro A1', 'Assuntos A1', 'Encerramento A1', 1,1,1,1, 'Conteúdo teste A1', 1),
('ATA 2025-02', 'Reunião 02', CURDATE(), '10:00:00', '11:00:00', 'Prefacio A2', 'Intro A2', 'Assuntos A2', 'Encerramento A2', 2,2,2,2, 'Conteúdo teste A2', 2),
('ATA 2025-03', 'Reunião 03', CURDATE(), '11:00:00', '12:00:00', 'Prefacio A3', 'Intro A3', 'Assuntos A3', 'Encerramento A3', 3,3,3,3, 'Conteúdo teste A3', 3),
('ATA 2025-04', 'Reunião 04', CURDATE(), '14:00:00', '15:00:00', 'Prefacio A4', 'Intro A4', 'Assuntos A4', 'Encerramento A4', 4,4,4,4, 'Conteúdo teste A4', 4),
('ATA 2025-05', 'Reunião 05', CURDATE(), '15:00:00', '16:00:00', 'Prefacio A5', 'Intro A5', 'Assuntos A5', 'Encerramento A5', 5,5,5,5, 'Conteúdo teste A5', 5);

-- 10) documento_integrante (map documento -> integrantes)
INSERT INTO documento_integrante (documento_id, integrante_id) VALUES
(1,1),(1,2),(2,2),(2,3),(3,3);

-- 11) predefinicao_integrante (map predefinicoes -> integrantes)
INSERT INTO predefinicao_integrante (predefinicao_id, integrante_id) VALUES
(1,1),(2,2),(3,3),(4,4),(5,5);

-- Done

/* ============================
SELECT d.*,
       o.nome AS organizacao_nome,
       n.nome AS nucleo_nome,
       c.nome AS curso_nome,
       l.nome AS local_nome,
       p.nome AS predefinicao_nome,
       i.id   AS integrante_id,
       i.nome AS integrante_nome
FROM documento d
LEFT JOIN organizacao o ON d.organizacao_id = o.id
LEFT JOIN nucleo_institucional n ON d.nucleo_id = n.id
LEFT JOIN curso c ON d.curso_id = c.id
LEFT JOIN localizacao l ON d.local_id = l.id
LEFT JOIN predefinicoes p ON d.predefinicao_id = p.id
LEFT JOIN documento_integrante di ON di.documento_id = d.id
LEFT JOIN integrante i ON i.id = di.integrante_id
============================== */
