<?php
namespace AppBundle\Twig;

class Extension extends \Twig_Extension{
   public function getName(){
       return 'twig.extension';
   }
   public function getFunctions() {
       return [new \Twig_SimpleFunction('file_exists', 'file_exists')];
   }
}
