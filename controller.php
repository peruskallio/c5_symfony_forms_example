<?php
namespace Concrete\Package\SymfonyFormsExample;

defined('C5_EXECUTE') or die("Access Denied.");

// Autoload needs to happen already here as we need the included libraries
// already in the package's extend statement. Too bad if we need different
// versions of the same library in multiple packages, the one that is loaded
// the first will always win. That's a widely acknowledged problem and there
// are some possible ways to solve it:

// Maybe some day built into composer:
// https://github.com/composer/composer/issues/183

// Drupal's way:
// https://www.drupal.org/project/composer_manager
// https://www.acquia.com/blog/using-composer-manager-get-island-now

// Hopefully we'll have some way of handling this in concrete5 as well at some point...
include(__DIR__ . '/vendor/autoload.php');

use \Mainio\C5\Twig\TwigServiceProvider;
use \Mainio\C5\Twig\Page\Single as SinglePage;
use Core;
use Package;
use \Concrete\Package\SymfonyFormsExample\Src\PackageRouteProvider;

class Controller extends Package
{

    protected $pkgHandle = 'symfony_forms_example';
    protected $appVersionRequired = '5.7.4';
    protected $pkgVersion = '0.0.1';

    public function getPackageName()
    {
        return t("Symfony Forms Example");
    }

    public function getPackageDescription()
    {
        return t("Example of using Symfony forms and validators within the concrete5 package context.");
    }

    public function install()
    {
        $pkg = parent::install();

        $this->installSinglePages($pkg);
    }

    public function on_start()
    {
        PackageRouteProvider::registerRoutes();

        // Register the twig services for the single pages
        $app = Core::getFacadeApplication();
        $spt = new TwigServiceProvider($app, $this);
        $spt->register();
    }

    protected function installSinglePages($pkg)
    {
        $sp = SinglePage::add('/dashboard/symfony_forms_example', $pkg);
        $sp = SinglePage::add('/dashboard/symfony_forms_example/types', $pkg);
        $sp = SinglePage::add('/dashboard/symfony_forms_example/entities', $pkg);
		$sp = SinglePage::add('/dashboard/symfony_forms_example/plain', $pkg);
    }

}
