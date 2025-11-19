-- Migration: rename column fk_predefinicao_id -> predefinicao_id (safe copy)
-- Steps:
-- 1) add new column `predefinicao_id`
-- 2) copy values from `fk_predefinicao_id` (if present)
-- 3) drop old foreign key constraint on `fk_predefinicao_id` (if any)
-- 4) drop old column `fk_predefinicao_id`
-- 5) add foreign key constraint on `predefinicao_id`

START TRANSACTION;

ALTER TABLE documento ADD COLUMN IF NOT EXISTS predefinicao_id INT NULL AFTER conteudo;

-- copy values (if column fk_predefinicao_id exists)
SET @has_col := (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'documento' AND column_name = 'fk_predefinicao_id');

SET @s1 = IF(@has_col > 0, 'UPDATE documento SET predefinicao_id = fk_predefinicao_id WHERE fk_predefinicao_id IS NOT NULL;', 'SELECT 1');
PREPARE stmt1 FROM @s1; EXECUTE stmt1; DEALLOCATE PREPARE stmt1;

-- drop foreign key constraint on fk_predefinicao_id if exists
SET @fkname := (SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'documento' AND COLUMN_NAME = 'fk_predefinicao_id' AND REFERENCED_TABLE_NAME = 'predefinicoes' LIMIT 1);
SET @drop = IF(@fkname IS NOT NULL, CONCAT('ALTER TABLE documento DROP FOREIGN KEY ', @fkname), 'SELECT 1');
PREPARE stmt2 FROM @drop; EXECUTE stmt2; DEALLOCATE PREPARE stmt2;

-- now drop the old column if it exists
SET @dropcol = IF(@has_col > 0, 'ALTER TABLE documento DROP COLUMN fk_predefinicao_id;', 'SELECT 1');
PREPARE stmt3 FROM @dropcol; EXECUTE stmt3; DEALLOCATE PREPARE stmt3;

-- add FK on new column
ALTER TABLE documento ADD CONSTRAINT fk_documento_predefinicao FOREIGN KEY (predefinicao_id) REFERENCES predefinicoes(id) ON DELETE SET NULL ON UPDATE CASCADE;

COMMIT;
