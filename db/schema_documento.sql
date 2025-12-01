-- Schema completo para o projeto: tabelas de apoio + tabela `documento` usada para ATAs
-- Ajuste o nome do banco conforme seu ambiente (ex.: `testetcc`).
-- Executar em ambiente de desenvolvimento; revise antes de aplicar em produção.

-- Recomendações: faça backup antes de rodar ou use migrations.

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS organizacao_curso;
DROP TABLE IF EXISTS organizacao_integrante;
DROP TABLE IF EXISTS nucleo_integrante;
DROP TABLE IF EXISTS documento;
DROP TABLE IF EXISTS integrante;
DROP TABLE IF EXISTS organizacao;
DROP TABLE IF EXISTS nucleo_institucional;
DROP TABLE IF EXISTS localizacao;
DROP TABLE IF EXISTS curso;
DROP TABLE IF EXISTS cargo;

SET FOREIGN_KEY_CHECKS = 1;

-- Tabela: cargo
CREATE TABLE IF NOT EXISTS `cargo` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(150) NOT NULL,
  `sigla` VARCHAR(32) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: curso
CREATE TABLE IF NOT EXISTS `curso` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(200) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: localizacao
CREATE TABLE IF NOT EXISTS `localizacao` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(200) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: organizacao
CREATE TABLE IF NOT EXISTS `organizacao` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(200) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: nucleo_institucional
CREATE TABLE IF NOT EXISTS `nucleo_institucional` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(200) NOT NULL,
  `sigla` VARCHAR(64) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: integrante
CREATE TABLE IF NOT EXISTS `integrante` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(200) NOT NULL,
  `cargo_id` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT NULL,
  CONSTRAINT `fk_integrante_cargo` FOREIGN KEY (`cargo_id`) REFERENCES `cargo`(`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabelas de junção sugeridas
CREATE TABLE IF NOT EXISTS `organizacao_integrante` (
  `organizacao_id` INT UNSIGNED NOT NULL,
  `integrante_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`organizacao_id`,`integrante_id`),
  CONSTRAINT `fk_orgint_organizacao` FOREIGN KEY (`organizacao_id`) REFERENCES `organizacao`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_orgint_integrante` FOREIGN KEY (`integrante_id`) REFERENCES `integrante`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `nucleo_integrante` (
  `nucleo_id` INT UNSIGNED NOT NULL,
  `integrante_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`nucleo_id`,`integrante_id`),
  CONSTRAINT `fk_nucint_nucleo` FOREIGN KEY (`nucleo_id`) REFERENCES `nucleo_institucional`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_nucint_integrante` FOREIGN KEY (`integrante_id`) REFERENCES `integrante`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `organizacao_curso` (
  `organizacao_id` INT UNSIGNED NOT NULL,
  `curso_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`organizacao_id`,`curso_id`),
  CONSTRAINT `fk_orgcurso_organizacao` FOREIGN KEY (`organizacao_id`) REFERENCES `organizacao`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_orgcurso_curso` FOREIGN KEY (`curso_id`) REFERENCES `curso`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Join table: organizacao <-> nucleo (opcional - facilita relações N:N)
CREATE TABLE IF NOT EXISTS `organizacao_nucleo` (
  `organizacao_id` INT UNSIGNED NOT NULL,
  `nucleo_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`organizacao_id`,`nucleo_id`),
  CONSTRAINT `fk_orgnuc_organizacao` FOREIGN KEY (`organizacao_id`) REFERENCES `organizacao`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_orgnuc_nucleo` FOREIGN KEY (`nucleo_id`) REFERENCES `nucleo_institucional`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Join table: organizacao <-> localizacao (opcional)
CREATE TABLE IF NOT EXISTS `organizacao_local` (
  `organizacao_id` INT UNSIGNED NOT NULL,
  `local_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`organizacao_id`,`local_id`),
  CONSTRAINT `fk_orglocal_organizacao` FOREIGN KEY (`organizacao_id`) REFERENCES `organizacao`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_orglocal_local` FOREIGN KEY (`local_id`) REFERENCES `localizacao`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela principal: documento (armazenará as ATAs)
CREATE TABLE IF NOT EXISTS `documento` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(255) DEFAULT NULL,
  `titulo` VARCHAR(255) DEFAULT NULL,
  `data` DATE DEFAULT NULL,
  `hora_inicio` TIME DEFAULT NULL,
  `hora_final` TIME DEFAULT NULL,
  `conteudo` LONGTEXT DEFAULT NULL,
  `prefacio` TEXT DEFAULT NULL,
  `introducao` TEXT DEFAULT NULL,
  `assunto` TEXT DEFAULT NULL,
  `encerramento` TEXT DEFAULT NULL,
  `organizacao_id` INT UNSIGNED DEFAULT NULL,
  `nucleo_id` INT UNSIGNED DEFAULT NULL,
  `curso_id` INT UNSIGNED DEFAULT NULL,
  `local_id` INT UNSIGNED DEFAULT NULL,
  -- integrante_id was deprecated; use join table documento_integrante
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT NULL,
  INDEX `idx_documento_titulo` (`titulo`),
  INDEX `idx_documento_data` (`data`),
  CONSTRAINT `fk_documento_organizacao` FOREIGN KEY (`organizacao_id`) REFERENCES `organizacao`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_documento_nucleo` FOREIGN KEY (`nucleo_id`) REFERENCES `nucleo_institucional`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_documento_curso` FOREIGN KEY (`curso_id`) REFERENCES `curso`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_documento_local` FOREIGN KEY (`local_id`) REFERENCES `localizacao`(`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Opcional: ative a FK para integrante como autor, se desejar
-- ALTER TABLE documento ADD CONSTRAINT fk_documento_integrante FOREIGN KEY (fk_integrantes_id) REFERENCES integrante(id) ON DELETE SET NULL;

-- Fim do schema

-- Tabela: predefinicoes (opcional - usada por classes de predefinição)
CREATE TABLE IF NOT EXISTS `predefinicoes` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(255) DEFAULT NULL,
  `dia` DATE DEFAULT NULL,
  `hora` TIME DEFAULT NULL,
  `prefacio` TEXT DEFAULT NULL,
  `introducao` TEXT DEFAULT NULL,
  `assunto` TEXT DEFAULT NULL,
  `encerramento` TEXT DEFAULT NULL,
  `organizacao_id` INT UNSIGNED DEFAULT NULL,
  `nucleo_id` INT UNSIGNED DEFAULT NULL,
  `curso_id` INT UNSIGNED DEFAULT NULL,
  `local_id` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT NULL,
  INDEX `idx_predef_nome` (`nome`),
  INDEX `idx_predef_dia` (`dia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- (Opcional) chaves estrangeiras podem ser adicionadas se desejar ligação com tabelas existentes
-- Conexões adicionais (ativadas): ligar `predefinicoes` com `organizacao` e `documento`
-- 1) Garante referência à organização na predefinição
ALTER TABLE predefinicoes
  ADD CONSTRAINT `fk_predef_org` FOREIGN KEY (`organizacao_id`) REFERENCES `organizacao`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- 2) Adiciona coluna em `documento` para referenciar a predefinição (template) usada
ALTER TABLE documento
  ADD COLUMN `predefinicao_id` INT UNSIGNED DEFAULT NULL,
  ADD INDEX `idx_documento_predef` (`predefinicao_id`);

ALTER TABLE documento
  ADD CONSTRAINT `fk_documento_predefinicao` FOREIGN KEY (`predefinicao_id`) REFERENCES `predefinicoes`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- Observação: coluna `predefinicao_id` é a recomendada (substitui o antigo `fk_predefinicao_id`).

-- Create join table: documento <-> integrante (N:N)
CREATE TABLE IF NOT EXISTS `documento_integrante` (
  `documento_id` INT UNSIGNED NOT NULL,
  `integrante_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`documento_id`,`integrante_id`),
  CONSTRAINT `fk_docint_documento` FOREIGN KEY (`documento_id`) REFERENCES `documento`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_docint_integrante` FOREIGN KEY (`integrante_id`) REFERENCES `integrante`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create join table: predefinicoes <-> integrante (N:N)
CREATE TABLE IF NOT EXISTS `predefinicao_integrante` (
  `predefinicao_id` INT UNSIGNED NOT NULL,
  `integrante_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`predefinicao_id`,`integrante_id`),
  CONSTRAINT `fk_predefint_predef` FOREIGN KEY (`predefinicao_id`) REFERENCES `predefinicoes`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_predefint_integrante` FOREIGN KEY (`integrante_id`) REFERENCES `integrante`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
