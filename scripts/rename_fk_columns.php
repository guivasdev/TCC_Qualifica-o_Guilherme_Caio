<?php
require_once __DIR__ . '/../model/MySql.php';

$pdo = MySql::connect();
$dbName = null;
$stmt = $pdo->query('SELECT DATABASE()');
$dbName = $stmt->fetchColumn();

$apply = in_array('--yes', $argv);

echo "Database: $dbName\n";

// find all columns with prefix fk_
$sql = "SELECT TABLE_NAME, COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT, COLUMN_KEY, EXTRA
        FROM information_schema.columns
        WHERE table_schema = :db AND COLUMN_NAME LIKE 'fk\\_%'";
$stm = $pdo->prepare($sql);
$stm->execute([':db' => $dbName]);
$cols = $stm->fetchAll(PDO::FETCH_ASSOC);

if (empty($cols)) {
    echo "Nenhuma coluna 'fk_' encontrada no banco de dados.\n";
    exit(0);
}

$changes = [];

foreach ($cols as $c) {
    $table = $c['TABLE_NAME'];
    $old = $c['COLUMN_NAME'];
    $new = preg_replace('/^fk_/', '', $old);
    $colType = $c['COLUMN_TYPE'];
    $isNullable = $c['IS_NULLABLE'] === 'YES';
    $default = $c['COLUMN_DEFAULT'];
    $extra = $c['EXTRA'];

    $changes[] = ['table' => $table, 'old' => $old, 'new' => $new, 'type' => $colType, 'nullable' => $isNullable, 'default' => $default, 'extra' => $extra];
}

// Show planned changes
echo "Planos detectados:\n";
foreach ($changes as $ch) {
    echo " - Table: {$ch['table']} | {$ch['old']} -> {$ch['new']} ({$ch['type']})\n";
}

if (!$apply) {
    echo "\nMODO DRY-RUN. Para aplicar as alterações, execute: php scripts/rename_fk_columns.php --yes\n";
    exit(0);
}

echo "\nAplicando alterações...\n";

foreach ($changes as $ch) {
    $table = $ch['table'];
    $old = $ch['old'];
    $new = $ch['new'];
    $colType = $ch['type'];
    $nullable = $ch['nullable'] ? 'NULL' : 'NOT NULL';
    $default = is_null($ch['default']) ? '' : "DEFAULT '" . addslashes($ch['default']) . "'";
    $extra = $ch['extra'];

    // 1) add new column if not exists
    $sqlAdd = "ALTER TABLE `$table` ADD COLUMN IF NOT EXISTS `$new` $colType $nullable $default $extra";
    echo "Executando: $sqlAdd\n";
    try {
        $pdo->exec($sqlAdd);
    } catch (Exception $e) {
        echo "Erro ao adicionar coluna $new: " . $e->getMessage() . "\n";
    }

    // 2) copy values
    $sqlCopy = "UPDATE `$table` SET `$new` = `$old` WHERE `$old` IS NOT NULL";
    echo "Executando: $sqlCopy\n";
    try {
        $pdo->exec($sqlCopy);
    } catch (Exception $e) {
        echo "Erro ao copiar valores para $new: " . $e->getMessage() . "\n";
    }

    // 3) check FK constraint referencing this column
    $qfk = $pdo->prepare("SELECT CONSTRAINT_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
        FROM information_schema.KEY_COLUMN_USAGE
        WHERE TABLE_SCHEMA = :db AND TABLE_NAME = :table AND COLUMN_NAME = :col AND REFERENCED_TABLE_NAME IS NOT NULL");
    $qfk->execute([':db' => $dbName, ':table' => $table, ':col' => $old]);
    $fk = $qfk->fetch(PDO::FETCH_ASSOC);

    if ($fk) {
        $constraint = $fk['CONSTRAINT_NAME'];
        $refTable = $fk['REFERENCED_TABLE_NAME'];
        $refCol = $fk['REFERENCED_COLUMN_NAME'];

        // drop old FK
        $sqlDropFk = "ALTER TABLE `$table` DROP FOREIGN KEY `$constraint`";
        echo "Executando: $sqlDropFk\n";
        try { $pdo->exec($sqlDropFk); } catch (Exception $e) { echo "Erro ao dropar FK $constraint: " . $e->getMessage() . "\n"; }

        // drop old column
        $sqlDropCol = "ALTER TABLE `$table` DROP COLUMN `$old`";
        echo "Executando: $sqlDropCol\n";
        try { $pdo->exec($sqlDropCol); } catch (Exception $e) { echo "Erro ao dropar coluna $old: " . $e->getMessage() . "\n"; }

        // add FK on new column
        $newConstraint = "fk_{$table}_{$new}";
        $sqlAddFk = "ALTER TABLE `$table` ADD CONSTRAINT `$newConstraint` FOREIGN KEY (`$new`) REFERENCES `$refTable`(`$refCol`) ON DELETE SET NULL ON UPDATE CASCADE";
        echo "Executando: $sqlAddFk\n";
        try { $pdo->exec($sqlAddFk); } catch (Exception $e) { echo "Erro ao adicionar FK $newConstraint: " . $e->getMessage() . "\n"; }
    } else {
        // no fk, just drop old column
        $sqlDropCol = "ALTER TABLE `$table` DROP COLUMN `$old`";
        echo "Executando: $sqlDropCol\n";
        try { $pdo->exec($sqlDropCol); } catch (Exception $e) { echo "Erro ao dropar coluna $old: " . $e->getMessage() . "\n"; }
    }

    // 4) update code files (.php) replacing occurrences
    $repoRoot = __DIR__ . '/../';
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($repoRoot));
    foreach ($it as $file) {
        if (!$file->isFile()) continue;
        $path = $file->getPathname();
        if (pathinfo($path, PATHINFO_EXTENSION) !== 'php') continue;
        $content = file_get_contents($path);
        if (strpos($content, $old) !== false) {
            $newContent = str_replace($old, $new, $content);
            file_put_contents($path, $newContent);
            echo "Atualizado arquivo: $path (replaced $old -> $new)\n";
        }
    }

}

echo "Concluído. Revise as alterações e execute testes.\n";
