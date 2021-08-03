<?php

namespace Core;
use \App\Controllers\DisplayChars;

/**
 * View
 *
 * PHP version 5.4
 */
class View
{

    /**
     * Render a view file
     *
     * @param string $view  The view file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view";  // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    /**
     * Render a view template using Twig
     *
     * @param string $template  The template file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem('../App/Views');
            $twig = new \Twig_Environment($loader);
			$twig->addGlobal('server', $_SERVER['HTTP_HOST']);
			//$twig->addGlobal('session', $_SESSION); 
			$twig->addGlobal('is_logged_in', \App\Auth::isLoggedIn());
			$twig->addGlobal('user', \App\Auth::getUser());   //dzieki temu bedziemy mogli odwolywac sie do plikow html do wszystkih danych uzytkownika zalogowanego
			$twig->addGlobal('flash_message', \App\Flash::getMessage());
			if(isset($_SESSION['user_id'])){
				$twig->addGlobal('piechar', DisplayChars::pieChar($_SESSION['user_id']));
				$twig->addGlobal('NumberAsigned', DisplayChars::NumberOfCategoriesAsigned($_SESSION['user_id']));
				$twig->addGlobal('topused', DisplayChars::topUsedExpenseName($_SESSION['user_id']));
				$twig->addGlobal('incomeTop', DisplayChars::topUsedIncomeName($_SESSION['user_id']));
				
			}
			/*
			if(isset($_SESSION['user_id'])){
				$twig->addGlobal('user_id', $_SESSION['user_id']);
				$twig->addGlobal('asignedIncomes', \App\Controllers\Income::displayIncomes($_SESSION['user_id']));
			}
			*/
			
        }

        echo $twig->render($template, $args);
    }
}
