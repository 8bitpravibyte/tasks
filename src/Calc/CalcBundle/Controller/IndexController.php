<?php

namespace App\Calc\CalcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{
  public function index()
  {
    return $this->render('calculator.html.twig', ['data' => '']);
  }

  public function calculate(Request $request)
  {

    /* User case 1: he types words - replace */
    $result = preg_replace("/[^0-9\/\*\+-]+/", "", $request->query->get('data'));

    /*
      User case 2:
      he types one of the four basic operators multiple times one after
      another like: **** , there should be a replace
    */

    /* Multiplication */
    $result = preg_replace("/\*+(?=[0-9]+)/", "*", $result);
    $result = preg_replace("/\*{2,}/", "", $result);

    /* Division */
    $result = preg_replace("/\/+(?=[0-9]+)/", "/", $result);
    $result = preg_replace("/\/{2,}/", "", $result);

    /* Addition */
    $result = preg_replace("/\+{1,}(?=[0-9]+)/", "+", $result);
    $result = preg_replace("/\+{2,}/", "", $result);

    /* Subtraction */
    $result = preg_replace("/-{1,}(?=[0-9]+)/", "-", $result);
    $result = preg_replace("/-{2,}/", "", $result);

    /* Safe eval */
    $result = eval("return $result;");
    return $this->render('calculator.html.twig', ['data' => $result]);
  }
}
