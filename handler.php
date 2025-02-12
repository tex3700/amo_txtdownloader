<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'files/';
    $statusClass = 'error';
    $errorMessage = '';
    $targetPath = '';
    $result = [];

    // Создаем папку, если её нет
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Проверяем загрузку файла
    if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($_FILES['uploadedFile']['name']);
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);


        // Проверяем расширение файла
        if (strtolower($fileExt) === 'txt') {
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $targetPath)) {
                $statusClass = 'success';
            } else {
                $errorMessage = 'Ошибка при сохранении файла.';
            }
        } else {
            $errorMessage = 'Можно загружать только .txt файлы.';
        }
    } else {
        $errorMessage = 'Ошибка загрузки файла.';
    }

    $linesArr = [];
    // Обрабатываем файл при успешной загрузке
    if ($statusClass === 'success') {
        $delimiter = $_POST['delimiter'];
        $handle = fopen($targetPath, 'r');
        while (($line = fgets($handle)) !== false) {
            $line = rtrim($line);
            if ($line) {
                $linesArr[] =  $line . $delimiter;
            }
        }
        fclose($handle);
    }

    $result['statusClass'] = $statusClass;
    $result['errorMessage'] = $errorMessage;
    $result['linesArr'] = $linesArr;
}
