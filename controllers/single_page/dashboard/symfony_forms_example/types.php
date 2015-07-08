<?php
namespace Concrete\Package\SymfonyFormsExample\Controller\SinglePage\Dashboard\SymfonyFormsExample;

defined('C5_EXECUTE') or die("Access Denied.");

use Core;
use FileList;
use Package;
use Page;
use User;
use \Mainio\C5\Twig\Page\Controller\DashboardPageController;

class Types extends DashboardPageController
{

    use \Mainio\C5\SymfonyForms\Controller\Extension\SymfonyFormsExtension;

    public function view()
    {
        $fl = new FileList();
        $file = array_shift($fl->get(1));
        // There is no Entity definitions for the Page class yet in the core.
        //$page = Page::getByID(HOME_CID);
        $page = HOME_CID;
        // There is no Entity definitions for the User class yet in the core.
        $user = new User();
        $user = $user->getUserID();

        $obj = array(
            'textValue' => '',
            'textareaValue' => '',
            'emailValue' => '',
            'integerValue' => 12,
            'moneyValue' => 0,
            'numberValue' => 0,
            'passwordValue' => '',
            'percentValue' => 0,
            'urlValue' => 'http://www.concrete5.org',
            'checkboxesValue' => array('first', 'third'),
            'radiosValue' => 'second',
            'selectValue' => 'third',
            'countryValue' => 'FI',
            'languageValue' => 'fi',
            'localeValue' => 'fi_FI',
            'timezoneValue' => 'Europe/Helsinki',
            'currencyValue' => 'EUR',
            'cID' => $page,
            'fID' => $file,
            'uID' => $user,
        );
        $form = $this->buildForm($obj);
        $this->set('form', $form->createView());
    }

    protected function buildForm($object, $options = array())
    {
        $this->set('new_record', $newRecord);

        $em =  Package::getByID($this->c->getPackageID())->getEntityManager();
        $formFactory = $this->getFormFactory();
        $builder = $formFactory->createBuilder('form', $object, array_merge(array(
            'action' => $action,
        ), $options))
            // See: http://symfony.com/doc/current/reference/forms/types.html
            // Text Fields
            ->add('textValue', 'text', array(
                'label' => t('Text'),
            ))
            ->add('textareaValue', 'textarea', array(
                'label' => t('Textarea'),
            ))
            ->add('emailValue', 'email', array(
                'label' => t('Email'),
            ))
            ->add('integerValue', 'integer', array(
                'label' => t('Integer'),
            ))
            ->add('moneyValue', 'money', array(
                'label' => t('Money'),
            ))
            ->add('numberValue', 'number', array(
                'label' => t('Number'),
            ))
            ->add('passwordValue', 'password', array(
                'label' => t('Password'),
            ))
            ->add('percentValue', 'percent', array(
                'label' => t('Percent'),
            ))
            ->add('urlValue', 'url', array(
                'label' => t('URL'),
            ))
            // Choise Fields
            ->add('checkboxesValue', 'choice', array(
                'label' => t('Multiple value selection'),
                'expanded' => true,
                'multiple'  => true,
                'choices'   => array(
                    'first'  => 'First',
                    'second' => 'Second',
                    'third'  => 'Third',
                ),
                'required' => false,
            ))
            ->add('radiosValue', 'choice', array(
                'label' => t('Single value selection, radio'),
                'expanded' => true,
                'empty_value' => false,
                'choices'   => array(
                    'first'  => 'First',
                    'second' => 'Second',
                    'third'  => 'Third',
                ),
                'required' => false,
            ))
            ->add('selectValue', 'choice', array(
                'label' => t('Single value selection, select'),
                'empty_value' => false,
                'choices'   => array(
                    'first'  => 'First',
                    'second' => 'Second',
                    'third'  => 'Third',
                ),
                'required' => false,
            ))
            ->add('countryValue', 'country', array(
                'label' => t('Country'),
                'required' => false,
            ))
            ->add('languageValue', 'language', array(
                'label' => t('Language'),
                'required' => false,
            ))
            ->add('localeValue', 'locale', array(
                'label' => t('Locale'),
                'required' => false,
            ))
            ->add('timezoneValue', 'timezone', array(
                'label' => t('Timezone'),
                'required' => false,
            ))
            ->add('currencyValue', 'currency', array(
                'label' => t('Currency'),
                'required' => false,
            ))
            // Date and Time Fields
            ->add('datePlainValue', 'date', array(
                'label' => t('Plain Date'),
                'required' => false,
            ))
            ->add('datetimePlainValue', 'datetime', array(
                'label' => t('Plain Date & Time'),
                'required' => false,
            ))
            ->add('timeValue', 'time', array(
                'label' => t('Time'),
                'required' => false,
            ))
            ->add('birthdayValue', 'birthday', array(
                'label' => t('Birthday'),
                'required' => false,
            ))
            // Other Fields
            ->add('checkboxValue', 'checkbox', array(
                'label' => t('Single Checkbox'),
                'required' => false,
            ))
            ->add('fileValue', 'file', array(
                'label' => t('Plain File'),
                'required' => false,
            ))
            // Custom Fields for concrete5
            ->add('dateValue', 'date_selector', array(
                'label' => t('Date'),
            ))
            ->add('dateTimeValue', 'date_time_selector', array(
                'label' => t('Date & Time'),
            ))
            ->add('cID', 'page_selector', array(
                'label' => t('Page'),
            ))
            ->add('fID', 'file_selector', array(
                'label' => t('File'),
                'required' => false,
                'entity_manager' => $em,
            ))
            ->add('uID', 'user_selector', array(
                'label' => t('User'),
                'required' => false,
            ));

        // Buttons
        $buttons = $builder->create('buttons', 'form_actions', array('label' => false))
            ->add('reset', 'reset', array('label' => t('Reset'), 'attr' => array('class' => 'pull-left')))
            ->add('save', 'submit', array('label' => t('Save'), 'attr' => array('class' => 'btn-primary pull-right')));
        $builder->add($buttons);

        return $builder->getForm();
    }


}
