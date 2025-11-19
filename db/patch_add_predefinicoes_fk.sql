-- Migração: adiciona FK entre predefinicoes.organizacao_id -> organizacao.id
-- e adiciona coluna documento.fk_predefinicao_id -> predefinicoes.id

-- 1) FK: predefinicoes -> organizacao
ALTER TABLE predefinicoes
  ADD CONSTRAINT `fk_predef_org`
    FOREIGN KEY (`organizacao_id`)
    REFERENCES `organizacao`(`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE;

-- 2) Adicionar coluna em documento para referenciar predefinição (template)
ALTER TABLE documento
  ADD COLUMN `predefinicao_id` INT UNSIGNED DEFAULT NULL,
  ADD INDEX `idx_documento_predef` (`predefinicao_id`);

-- 3) FK: documento -> predefinicoes
ALTER TABLE documento
  ADD CONSTRAINT `fk_documento_predefinicao`
    FOREIGN KEY (`predefinicao_id`)
    REFERENCES `predefinicoes`(`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE;

-- Observação: execute as instruções acima em ambiente de desenvolvimento com backup prévio.
