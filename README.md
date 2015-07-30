# Symfony forms example for concrete5

This is an example on how to use [Symfony forms](https://symfony.com/doc/current/book/forms.html) within concrete5.

This relies on the following composer package since this functionality is not
currently built in to concrete5:

[https://github.com/mainio/c5pkg_symfony_forms](https://github.com/mainio/c5pkg_symfony_forms)

## Why on Earth would I use something like this?

Well there is not much you actually have to do in this world but to die. Other than that, we are here to help.
Using Symfony forms will make your life easier and your development process quite a lot more straight forward
and faster than it has been until this point.

For more good reasons, please see the composer package readme page at:

[https://github.com/mainio/c5pkg_symfony_forms](https://github.com/mainio/c5pkg_symfony_forms)

## Can you show what is the advantage?

Sure can. In your controller, you build your forms like this:

```php

// $object contains the object you are managing with the form.
// This can be a doctrine entity for instance
$builder = $formFactory->createBuilder('form', $object, array(
    'action' => $object->primaryID > 0 ?
        View::url('/dashboard/your_package/view/update', $object->primaryID)
        :
        View::url('/dashboard/your_package/view/create'),
))
    ->add('name', 'text', array(
        'required' => true
    ))
    ->add('type', 'choice', array(
        'empty_value' => false,
        'choices'  => array(
            'cool' => t("Cool"),
            'uncool' => t("Uncool"),
        ),
    ));

// Buttons (optional)
$buttons = $builder->create('buttons', 'form_actions', array('label' => false))
    ->add('reset', 'reset', array('label' => t('Cancel'), 'attr' => array('class' => 'pull-left')))
    ->add('save', 'submit', array('label' => t('Save'), 'attr' => array('class' => 'btn-primary pull-right')));
$builder->add($buttons);

// The form object can be used further down the process when you actually print it out.
$builder->getForm();

```

Then, in your view, you print out the form like this (using twig templates):

```twig

{{ form(form) }}

```

Guess what? Now you do not have to care about ANYTHING else related to the form. All the validations,
request handing and mapping the values back to your object are handled for you automatically. If you
want some extra validations, just add your own validators. Pretty cool, huh?

Here is an example of how you would then save your mapped object:

```php

// Variable $em contains the Entity Manager related to these entities.
// Usually your package's entity manager (see the "Entities" example).
// Variable $form contains the form in question (see above how to 
// build it).

$request = Request::getInstance();
$form->handleRequest($request);
if ($form->isValid()) {
    $object = $form->getData();

    $em->persist($object);
    $em->flush();
}

```

For more information check the "Entities" example within this package.

## Good to know

When developing with the twig templates, by default it caches the templates to
your cache directory. When you make any changes to the templates they are not
automatically recompiled to the cache.

To avoid this during the development phase, add this to your `application/config/app.php`:

```php
return array(
    // ... some other configs ...
    'twig_debug' => true
    // ... some other configs ...
);
```

## Installation

1. Make sure you are running PHP 5.4 or newer. It is required for using the necessary
   traits to inject the necessary functionality into your controllers. 
2. Make sure you have [Composer](https://getcomposer.org/) installed on your computer.
3. Clone this repository into your concrete5 installations "packages" folder.
4. Rename the folder to `symfony_forms_example`.
5. Locate the folder from the console and run `composer install` within the folder.
6. Go to your installations Dashboard > Extend concrete5 section
7. Install the package visible in the list 

## License

Licensed under the MIT license. See LICENSE for more information.

Copyright (c) 2015 Mainio Tech Ltd.