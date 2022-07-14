<h1>Edit post</h1>
<?php

use DigraphCMS\Context;
use DigraphCMS\HTML\Forms\Field;
use DigraphCMS\HTML\Forms\Fields\CheckboxField;
use DigraphCMS\HTML\Forms\Fields\DatetimeField;
use DigraphCMS\HTML\Forms\FormWrapper;
use DigraphCMS\HTTP\RedirectException;
use DigraphCMS\RichContent\RichContentField;
use DigraphCMS_Plugins\byjoby\blog\BlogPost;

/** @var BlogPost */
$post = Context::page();

$form = new FormWrapper('edit_' . Context::pageUUID());

$name = (new Field('Post name'))
    ->setDefault($post->name())
    ->setRequired(true)
    ->addTip('The name to be used when referring or linking to this post from elsewhere on the site.');
$form->addChild($name);

$content = (new RichContentField('Body content'))
    ->setDefault($post->richContent('body'))
    ->setPageUuid(Context::pageUUID())
    ->setRequired(true);
$form->addChild($content);

$sticky = (new CheckboxField('Make post sticky'))
    ->setDefault($post->sortWeight() == -1);
$form->addChild($sticky);

$time = (new DatetimeField('Manually set date'))
    ->setStep(60)
    ->setDefault($post->customTime())
    ->addTip('Leave blank to use the current time')
    ->addTip('Can be set to a future date to delay listing a post in public interfaces');
$form->addChild($time);

if ($form->ready()) {
    $post->name($name->value());
    $post->richContent('body', $content->value());
    if ($sticky->value()) $post->setSortWeight(-1);
    else $post->setSortWeight(0);
    $post->setTime($time->value());
    $post->update();
    throw new RedirectException($post->url());
}

echo $form;
