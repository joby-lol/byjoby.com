<h1>New post</h1>
<?php

use DigraphCMS\Content\Pages;
use DigraphCMS\Context;
use DigraphCMS\HTML\Forms\Field;
use DigraphCMS\HTML\Forms\Fields\CheckboxField;
use DigraphCMS\HTML\Forms\Fields\DatetimeField;
use DigraphCMS\HTML\Forms\FormWrapper;
use DigraphCMS\HTTP\RedirectException;
use DigraphCMS\RichContent\RichContentField;
use DigraphCMS\UI\Breadcrumb;
use DigraphCMS_Plugins\byjoby\blog\BlogPost;

Context::ensureUUIDArg(Pages::class);

$parent = Pages::get(Context::arg('parent'));
if ($parent) Breadcrumb::parent($parent->url());

$form = new FormWrapper('add_' . Context::arg('uuid'));

$name = (new Field('Post name'))
    ->setRequired(true)
    ->addTip('The name to be used when referring or linking to this post from elsewhere on the site.');
$form->addChild($name);

$content = (new RichContentField('Body content'))
    ->setPageUuid(Context::arg('uuid'))
    ->setRequired(true);
$form->addChild($content);

$sticky = new CheckboxField('Make post sticky');
$form->addChild($sticky);

$time = (new DatetimeField('Manually set date'))
    ->setStep(60)
    ->addTip('Leave blank to use the current time')
    ->addTip('Can be set to a future date to delay listing a post in public interfaces');
$form->addChild($time);

if ($form->ready()) {
    $post = new BlogPost();
    $post->setUUID(Context::arg('uuid'));
    $post->name($name->value());
    $post->richContent('body', $content->value());
    if ($sticky->value()) $post->setSortWeight(-1);
    if ($time->value()) $post->setTime($time->value());
    $post->insert($parent ? $parent->uuid() : null);
    throw new RedirectException($post->url());
}

echo $form;
