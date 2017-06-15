<?php

/* заглушка для базы данных. библиотека статических функций */
class DB {

  public static function get_user_id($id) {
    return $id;
  }

  public static function get_user_role($id) {
    $roles = ['admin', 'customer', 'manager'];
    $userRole = [1 => 0, 2 => 1];
    return $roles[$userRole[$id]];
  }

  public static function get_name($id) {
    $userName = [1 => 'admin', 2 => 'Vasya'];
    return $userName[$id];
  }
}

/* Класс User задает общие свойства и поведение для пользователей приложения */
class User {

  const API_VERSION = 'beta';

  protected $id;
  protected $role;

  public function __construct($id) {
    $this->id = DB::get_user_id($id);
    $this->role = DB::get_user_role($this->id);
  }

  public function login() {
    return 'success';
  }

  public function show_name() {
    $name = DB::get_name($this->id);
    echo 'Привет, <strong>' . $name . '</strong>!<br>';
  }

}

/**
 *  класс UserAdmin описывает пользователей-администраторов магазина
 *  данные пользователи имеют дополнительные возможности по работе
 *  с магазином.
 */
class UserAdmin extends User {

  private $root = true;

  public function turn_site_off() {
    echo 'site in offline mode.<br>';
  }

}

/**
 *  класс UserManager описывает пользователей-менеджеров магазина
 *  данные пользователи имеют дополнительные возможности по работе
 *  с заказами.
 */
class UserManager extends User {

  public function show_all_orders() {
    echo 'orders list<br>';
  }

}

/* полиморфизм */
$user = new User(2);
$admin = new UserAdmin(1);

$users = [$user, $admin];

foreach ($users as $u) {
  $u->show_name();
}
