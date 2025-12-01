-- Seed de exemplo para a tabela `documento` (ATA)
-- Ajuste os IDs de FK (curso_id, local_id, organizacao_id, nucleo_id) — participantes agora via `documento_integrante`
-- antes de aplicar em um banco já populado.

INSERT INTO `documento` (
  `titulo`, `data`, `hora_inicio`, `hora_fim`, `prefacio`, `introducao`, `assunto`, `encerramento`, `conteudo`,
  `curso_id`, `local_id`, `organizacao_id`, `nucleo_id`
) VALUES (
  'Ata de Reunião Exemplo',
  CURDATE(),
  '14:00:00',
  '15:30:00',
  'Prefácio de exemplo: abertura dos trabalhos.',
  'Introdução de exemplo: pauta e objetivos.',
  'Assuntos tratados: ponto A; ponto B; decisão C.',
  'Encerramento: agradecimentos e próximos passos.',
  'Conteúdo extenso da ata: registro detalhado das deliberações e participações.',
  NULL, NULL, NULL, NULL, NULL
);

-- Outra linha de exemplo com algumas FKs preenchidas (ajuste IDs conforme seu DB):
-- INSERT INTO `documento` (`titulo`,`data`,`hora_inicio`,`hora_fim`,`prefacio`,`introducao`,`assunto`,`encerramento`,`conteudo`,`curso_id`,`local_id`,`organizacao_id`,`nucleo_id`) VALUES ('Ata Exemplo 2', CURDATE(), '09:00:00','10:00:00','Prefácio 2','Introdução 2','Assunto X','Encerramento 2','Conteúdo 2', 1, 1, 1, 1);
-- Em seguida associe participantes via: INSERT INTO documento_integrante (documento_id, integrante_id) VALUES (<doc_id>, <integ_id>);
