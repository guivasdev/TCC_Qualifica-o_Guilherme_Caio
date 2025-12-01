-- Migration: move integrante_id fields into join tables (documento_integrante, predefinicao_integrante)
-- Steps:
-- 1) create join tables if not exist
-- 2) if documento.integrante_id exists, copy values to documento_integrante
-- 3) if predefinicoes.integrante_id exists, copy to predefinicao_integrante
-- 4) drop FK constraints & columns from documento and predefinicoes
-- 5) add FK constraints on new join tables

START TRANSACTION;

-- 1) create join tables
CREATE TABLE IF NOT EXISTS documento_integrante (
  documento_id INT UNSIGNED NOT NULL,
  integrante_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (documento_id, integrante_id),
  CONSTRAINT fk_docint_documento FOREIGN KEY (documento_id) REFERENCES documento(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_docint_integrante FOREIGN KEY (integrante_id) REFERENCES integrante(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS predefinicao_integrante (
  predefinicao_id INT UNSIGNED NOT NULL,
  integrante_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (predefinicao_id, integrante_id),
  CONSTRAINT fk_predefint_predef FOREIGN KEY (predefinicao_id) REFERENCES predefinicoes(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_predefint_integrante FOREIGN KEY (integrante_id) REFERENCES integrante(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2) copy existing documento.integrante_id into join table (if column exists)
SET @has_doc_col := (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'documento' AND column_name = 'integrante_id');
SET @s1 = IF(@has_doc_col > 0, 'INSERT INTO documento_integrante (documento_id, integrante_id) SELECT id, integrante_id FROM documento WHERE integrante_id IS NOT NULL', 'SELECT 1');
PREPARE st1 FROM @s1; EXECUTE st1; DEALLOCATE PREPARE st1;

-- 3) copy existing predefinicoes.integrante_id into join table
SET @has_pre_col := (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'predefinicoes' AND column_name = 'integrante_id');
SET @s2 = IF(@has_pre_col > 0, 'INSERT INTO predefinicao_integrante (predefinicao_id, integrante_id) SELECT id, integrante_id FROM predefinicoes WHERE integrante_id IS NOT NULL', 'SELECT 1');
PREPARE st2 FROM @s2; EXECUTE st2; DEALLOCATE PREPARE st2;

-- 4) drop FK constraints & columns (if exists)
SET @docfk = (SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'documento' AND COLUMN_NAME = 'integrante_id' LIMIT 1);
SET @dropdocfk = IF(@docfk IS NOT NULL, CONCAT('ALTER TABLE documento DROP FOREIGN KEY `', @docfk, '`'), 'SELECT 1');
PREPARE st3 FROM @dropdocfk; EXECUTE st3; DEALLOCATE PREPARE st3;

SET @predefk = (SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'predefinicoes' AND COLUMN_NAME = 'integrante_id' LIMIT 1);
SET @droppredefk = IF(@predefk IS NOT NULL, CONCAT('ALTER TABLE predefinicoes DROP FOREIGN KEY `', @predefk, '`'), 'SELECT 1');
PREPARE st4 FROM @droppredefk; EXECUTE st4; DEALLOCATE PREPARE st4;

-- drop columns if they exist
SET @dropdoccol = IF(@has_doc_col > 0, 'ALTER TABLE documento DROP COLUMN integrante_id', 'SELECT 1');
PREPARE st5 FROM @dropdoccol; EXECUTE st5; DEALLOCATE PREPARE st5;

SET @dropprecol = IF(@has_pre_col > 0, 'ALTER TABLE predefinicoes DROP COLUMN integrante_id', 'SELECT 1');
PREPARE st6 FROM @dropprecol; EXECUTE st6; DEALLOCATE PREPARE st6;

COMMIT;

-- Migration ends
