<?php
namespace Concrete\Package\SymfonyFormsExample\Controller\SinglePage\Dashboard\SymfonyFormsExample;

defined('C5_EXECUTE') or die("Access Denied.");

use \Mainio\C5\Twig\Page\Controller\DashboardPageController;
use Package;
use View;
use Request;
use Session;
use Concrete\Package\SymfonyFormsExample\Src\Entity\Car;

class Entities extends DashboardPageController
{

    use \Mainio\C5\SymfonyForms\Controller\Extension\SymfonyFormsExtension;

    protected $form;

    public function view()
    {
        $rep = $this->getCarRepository();
        $this->set('cars', $rep->findAll());

        if (count($msg = $this->getFlash('successMessage')) > 0) {
            $this->set('success', implode(", ", $msg));
        }
    }

    public function add()
    {
        $car = new Car();
        $car->manufacturingDate = new \DateTime('now');
        $this->form = $this->buildForm($car);
        $this->set('form', $this->form->createView());
    }

    public function create()
    {
        $this->add();
        if ($this->save()) {
            $this->setFlash('successMessage', t("Successfully added new record."));
            $this->redirect('/dashboard/symfony_forms_example/entities');
        }
    }

    public function edit($carID)
    {
        $car = $this->getCarRepository()->find($carID);
        if (!is_object($car)) {
            $this->redirect('/dashboard/symfony_forms_example/entities');
        }
        $this->form = $this->buildForm($car);
        $this->set('form', $this->form->createView());
    }

    public function update($carID)
    {
        $this->edit($carID);
        if ($this->save()) {
            $this->setFlash('successMessage', t("Successfully saved the record."));
            $this->redirect('/dashboard/symfony_forms_example/entities');
        }
    }

    protected function save()
    {
        $request = Request::getInstance();
        $this->form->handleRequest($request);
        if ($this->form->isValid()) {
            $car = $this->form->getData();

            $em = $this->em();
            $em->persist($car);
            $em->flush();

            return true;
        }
        // The view needs to be regenerated in order to display the errors.
        // Also, to have the request values on the displayed form, this is
        // necessary.
        $this->set('form', $this->form->createView());
        return false;
    }

    protected function buildForm($object, $options = array())
    {
        $em = $this->em();
        $formFactory = $this->getFormFactory();
        $builder = $formFactory->createBuilder('form', $object, array_merge(array(
            'action' => $object->carID > 0 ?
                View::url('/dashboard/symfony_forms_example/entities/update', $object->carID)
                :
                View::url('/dashboard/symfony_forms_example/entities/create'),
        ), $options))
            ->add('name', 'text', array(
                'required' => true
            ))
            ->add('manufacturingDate', 'date_selector', array(
                'label' => t('Manufacturing Date'),
            ))
            ->add('type', 'choice', array(
                'empty_value' => false,
                'choices'  => Car::getTypes(),
            ))
            ->add('numberOfDoors', 'text')
            ->add('retailPrice', 'money', array(
                'label' => t('Retail Price'),
                'currency' => 'USD'
            ))
            ->add('image', 'file_selector', array(
                'required' => false,
                'entity_manager' => $em
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

    protected function getCarRepository()
    {
        return $this->em()->getRepository('Concrete\Package\SymfonyFormsExample\Src\Entity\Car');
    }

    protected function em()
    {
        return Package::getByID($this->c->getPackageID())->getEntityManager();
    }

}
