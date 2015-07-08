<?php
namespace Concrete\Package\SymfonyFormsExample\Controller\Backend\SymfonyFormsExample;

defined('C5_EXECUTE') or die("Access Denied.");

use Core;
use Request;
use \Mainio\C5\Twig\Controller\Controller;

class Example extends Controller
{

    protected $viewPath = '/backend/symfony_forms_example';

    public function on_start()
    {
        $this->view->setFormat(null);
    }

    public function view()
    {
        
    }

}
