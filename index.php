<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тестовое задание 1</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Загрузите текстовый файл (.txt)</h1>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="uploadedFile" accept=".txt" required>
    <input type="text" name="delimiter" placeholder="Введите разделитель" required  maxlength="1"
           oninput="validateDelimiter(this)" title="Допустимы только специальные символы">
    <button type="submit">Загрузить</button>
</form>

<?php
    require "handler.php";
    if (!empty($result['statusClass'])):
        // Выводим статус загрузки ?>
        <div class='status-circle <?= $result['statusClass'] ?>'></div>
        <?php if ($result['errorMessage']): ?>
            <p class='error'><?= $result['errorMessage'] ?></p>
        <?php endif;?>
    <?php endif;?>

    <div class='result'>
        <?php
            if (!empty($result['linesArr'])):
                // Выводим строки
            foreach ($result['linesArr'] as $line):
                preg_match_all('/\d/', $line, $matches);
                $digitCount = count($matches[0]); ?>
                <p> <?= htmlspecialchars($line) ?>  = <strong><?= $digitCount ?></strong></p>
        <?php
            endforeach;
            endif; ?>
    </div>

<script>
    function validateDelimiter(input) {
        const specialChars = /[!@#$%^&*()_+\-=\[\]{}|;:,.<>/\\"'?]/;
        if (!specialChars.test(input.value)) {
            input.setCustomValidity('Допустимы только специальные символы');
        } else {
            input.setCustomValidity('');
        }
    }
</script>
</body>
</html>
