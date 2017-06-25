<?php

error_reporting(E_ALL);
define('APP_ROOT', __DIR__);

require APP_ROOT . '/vendor/autoload.php';
$conf = require APP_ROOT . '/conf.php';

use App\Db\Connection;
use App\Html\View;

$db = Connection::getConnection($conf['db']);
$view = new View($conf['view']);

$tmpl = 'index.phtml';

$imgid = filter_input(INPUT_GET, 'imgid', FILTER_VALIDATE_INT);

if (is_null($imgid)) {
  $tplVars['header'] = 'Все изображения из БД';
  $result = $db->query('SELECT * FROM `images` ORDER BY `gorder`');
} else {
  $tmpl = 'single.phtml';
  $tplVars['header'] = 'Изображение #' . $imgid;
  $result = $db->query('SELECT * FROM images WHERE id = ?', $imgid);
}

$all = $result->fetchAll();

if (empty($all)) {
  $tmpl = '404.phtml';
  $tplVars['header'] = 'Что-то пошло не так =(';
} else {
  $tplVars['raws'] = $all;
}

echo $view->render($tmpl, $tplVars);
