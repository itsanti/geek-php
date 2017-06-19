<?php
/* абстрактный товар */
abstract class CommonGoods {

  /* локальное хранилище цен */
  protected static $prices = [1 => 1000, 2 => 250];

  protected $price; // цена товара
  protected $id;    // идентификатор товара

  public function getId() {
    return $this->id;
  }

  public function getPrice() {
    return $this->price;
  }

  protected function setPrice($id) {
    $this->price = self::$prices[$id];
  }

  /* финальная стоимость зависит от типа товара, поэтому
     сделаем данный метод абстрактным. */
  abstract public function countPrice();

}

/* товар на вес */
class WeightGoods extends CommonGoods {

  protected $weight; // общий вес товара с данным ИД в кг.

  function __construct($id, $weight = 1) {
    $this->id = $id;
    $this->weight = $weight;
    $this->setPrice($id);
  }

  public function getWeight() {
    return $this->weight;
  }

  public function countPrice() {
    return $this->getPrice() * $this->getWeight();
  }

}

/* штучный физический товар */
class PhysicalGoods extends CommonGoods {

  protected $count; // количество товара с данным ИД

  function __construct($id, $count = 1) {
    $this->id = $id;
    $this->count = $count;
    $this->setPrice($id);
  }

  public function getCount() {
    return $this->count;
  }

  public function countPrice() {
    return $this->getPrice() * $this->getCount();
  }

}

/* цифровой товар на основе данного штучного */
class DigitalGoods extends PhysicalGoods {

  /* доступен ли цифровой товар для данного ИД */
  private $isDigital = [1 => true, 2 => false];

  private function checkDigital() {
    return $this->isDigital[$this->id];
  }

  /* переопределим формирование цены для цифровых товаров */
  protected function setPrice($id) {

    if ($this->checkDigital()) {
      parent::setPrice($id);
      $this->price /= 2;
    } else {
      $this->price = NULL;
    }

  }

}

$pg = new PhysicalGoods(1);
$dg = new DigitalGoods(1, 4);
$wg = new WeightGoods(2, 2);
var_dump(
  $pg->countPrice(), // 1000
  $dg->countPrice(), // 2000
  $wg->countPrice()  // 500
);

/* доход с продаж */
$goods = [$pg, $dg, $wg];
$total = 0;
foreach ($goods as $good) {
  $total += $good->countPrice();
}
var_dump($total); // 3500
