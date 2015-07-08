<?php
namespace Concrete\Package\SymfonyFormsExample\Controller\SinglePage\Dashboard;

defined('C5_EXECUTE') or die("Access Denied.");

use \Mainio\C5\Twig\Page\Controller\DashboardPageController;

class SymfonyFormsExample extends DashboardPageController
{

    public function view()
    {
        $this->redirect('/dashboard/symfony_forms_example/types');
    }

}
