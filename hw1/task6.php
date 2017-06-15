<?php
/**
 * Что выведет код на каждом шаге? Почему?
 */

class A {

  public function foo() {
    /* переменная $x будет проинициализирована только при первом вызове функции foo */
    static $x = 0;
    echo ++$x;
  }

}

class B extends A {
}

$a1 = new A();
$b1 = new B();

/* в данном случае получается, что мы вызываем один метод хоть и с одной реализацией,
   но с разными именами A::foo и B::foo, поэтому счетчики у них отдельные для
   объектов класса A и класса B. */
$a1->foo(); // 1
$b1->foo(); // 1
$a1->foo(); // 2
$b1->foo(); // 2