<?php  
namespace Concrete\Package\SymfonyFormsExample\Src;

defined('C5_EXECUTE') or die("Access Denied.");

use Page;
use Permissions;
use Route;
use User;

class PackageRouteProvider
{
    public static function registerRoutes()
    {
        // Admin routes
        Route::register('/ccm/symfony_forms_example', '\Concrete\Package\SymfonyFormsExample\Controller\Backend\SymfonyFormsExample\Example::view');
    }
}