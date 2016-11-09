<?php

/*
  Uploadify
  Copyright (c) 2012 Reactive Apps, Ronnie Garcia
  Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
 */
include_once 'libray/config.php';
if (!empty($_FILES) && $_POST) {
    if ($_POST['token'] == API_TOKEN) {
        $targetFile = $_FILES['file']['tmp_name'];
        $getFileName = $_FILES['file']['name'];
        $path = $_POST["path"];
        $file_name = $_POST["filename"];
        $destination = $_SERVER['DOCUMENT_ROOT'] . 'uploads/html_file/' . $path;
        @mkdir($destination, 0777, true);
        //$file_name = iconv("UTF-8", "gbk", $file_name);
        //$extension = getExtension($getFileName);
        $destination.="/" . $file_name;
        if (move_uploaded_file($targetFile, $destination)) {
            echo json_encode(['success' => true]);
            exit;
        }
    }
    echo json_encode(['success' => false]);
    exit;
} else {
    echo json_encode(['success' => false]);
    exit;
}

/**
 * 获取文件后缀
 * @param type $files
 * @return type
 */
function getExtension($files) {
    return pathinfo($files, PATHINFO_EXTENSION);
}

/**
 * 获取 文件名称 不带后缀
 * @param type $files
 * @return type
 */
function getFileName($files) {
    $basename = ltrim(substr($files, strrpos($files, '/')), "/");
    $filename = ltrim(substr($basename, 0, strrpos($basename, '.')), "/");
    return $filename;
}

/**
 * 判断目录是否存在,不存在则创建
 * @param type $file
 */
function mkdirFile($filename) {
    if (!is_dir($filename)) {
        return mkdir($filename, 0777, true) or false;
    }
    return true;
}

/**
 * 获取毫秒
 * @return type
 */
function getMillisecond() {
    list($t1, $t2) = explode(' ', microtime());
    return (float) sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
}

?>