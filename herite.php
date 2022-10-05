Quand utiliser self:: , $this , $objet et Class:: ?

avant tout je me pose les bonne questions pour savoir quoi utiliser :

est ce que je suis dans la class ?
            -Oui ($this ou self)
                -Est ce que l'elelment auqel je veux accéder est static ?
                    -Oui
                        - self::$element
                    -Non 
                        - $this->element   
            -Non ($objet ou Class)
                -Est ce que l'elelment auqel je veux accéder est static ?
                    -Oui 
                        - Class::$element
                    -Non
                        - $objet->element

/*
element : signifie une propriété ou une méthode
$objet : l'objet de la class que j'utilise
*/
<?php

class A
{
    private static $toto = 5;
    public static $tata = 10;
    public $titi = 20;
    protected $tutu = 30;

    public static function affiche()
    {
    return  $this->tutu;
    }



}

$a = new A();


A::afficher()


