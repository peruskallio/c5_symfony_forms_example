<?php
namespace Concrete\Package\SymfonyFormsExample\Controller\SinglePage\Dashboard\SymfonyFormsExample;

defined('C5_EXECUTE') or die("Access Denied.");

use \Mainio\C5\Twig\Page\Controller\DashboardPageController;
use View;
use Request;
use Package;
use Session;

class Plain extends DashboardPageController
{

    use \Mainio\C5\SymfonyForms\Controller\Extension\SymfonyFormsExtension;

    protected $form;

    public function view()
    {
        $config = $this->getConfig();

        $obj = array(
            'name' => $config->get('settings.name'),
            'selection' => $config->get('settings.selection'),
            'checkboxList' => explode(',', $config->get('settings.checkboxList')),
            'uID' => $config->get('settings.uID'),
            'fID' => $config->get('settings.fID'),
            'checkbox' => (bool)$config->get('settings.checkbox'),
        );
        $this->form = $this->buildForm($obj);
        $this->set('form', $this->form->createView());

        if (count($msg = $this->getFlash('successMessage')) > 0) {
            $this->set('success', implode(", ", $msg));
        }
    }

    public function save()
    {
        $this->view();

        $request = Request::getInstance();
        $this->form->handleRequest($request);

        if ($this->form->isValid()) {
            $data = $this->form->getData();

            $config = $this->getConfig();
            $config->save('settings.name', $data['name']);
            $config->save('settings.selection', $data['selection']);
            $config->save('settings.checkboxList', implode(',', $data['checkboxList']));
            $config->save('settings.uID', $data['uID']);
            $config->save('settings.fID', $data['fID']);
            $config->save('settings.checkbox', $data['checkbox']);

            $this->setFlash('successMessage', t("Values successfully saved."));
            $this->redirect('/dashboard/symfony_forms_example/plain');
        }
    }

    protected function buildForm($object, $options = array())
    {
        $formFactory = $this->getFormFactory();
        $builder = $formFactory->createBuilder('form', $object, array_merge(array(
            'action' => View::url('/dashboard/symfony_forms_example/plain/save'),
        ), $options))
            ->add('name', 'text')
            ->add('selection', 'choice', array(
                'empty_value' => false,
                'choices'  => array(
                    1 => t("One"),
                    2 => t("Two"),
                ),
            ))
            ->add('checkboxList', 'choice', array(
                'label' => t('Multiple value selection'),
                'expanded' => true,
                'multiple'  => true,
                'choices'   => array(
                    'first'  => 'First',
                    'second'  => 'Second',
                ),
                'required' => false,
            ))
            ->add('uID', 'user_selector', array(
                'label' => t('User'),
                'required' => false,
            ))
            ->add('fID', 'file_selector', array(
                'label' => t('File'),
                'required' => false,
            ))
            ->add('checkbox', 'checkbox', array(
                'label' => t('Check this checkbox'),
                'required' => false,
            ));

        // Buttons
        $buttons = $builder->create('buttons', 'form_actions', array('label' => false))
            ->add('reset', 'reset', array('label' => t('Cancel'), 'attr' => array('class' => 'pull-left')))
            ->add('save', 'submit', array('label' => t('Save'), 'attr' => array('class' => 'btn-primary pull-right')));
        $builder->add($buttons);

        return $builder->getForm();
    }

    protected function setFlash($key, $value)
    {
        $flashbag = Session::getFlashBag();
        return $flashbag->set($key, $value);
    }

    protected function getFlash($key)
    {
        $flashbag = Session::getFlashBag();
        return $flashbag->get($key);
    }

    protected function getConfig()
    {
        $pkg = Package::getByID($this->c->getPackageID());
        return $pkg->getConfig();
    }

}
