<?php

namespace DigraphCMS_Plugins\byjoby\hackery;

use DigraphCMS\CodeMirror\CodeMirrorField;
use DigraphCMS\HTML\Forms\Field;
use DigraphCMS\HTML\Forms\FormWrapper;
use DigraphCMS\RichMedia\Types\AbstractRichMedia;
use DigraphCMS\UI\Notifications;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class PhpRichMedia extends AbstractRichMedia
{
    function prepareForm(FormWrapper $form, $create = false)
    {
        // name input
        $name = (new Field('Name'))
            ->setDefault($this->name())
            ->setRequired(true)
            ->addForm($form);

        // script editor
        $script = (new CodeMirrorField('PHP', 'php'))
            ->setDefault($this['script'])
            ->addForm($form);

        // handler
        $form->addCallback(function () use ($name, $script) {
            $this->name($name->value());
            $this['script'] = $script->value();
        });
    }

    function shortCode(ShortcodeInterface $code): ?string
    {
        ob_start();
        try {
            eval($this['script']);
        } catch (\Throwable $th) {
            Notifications::printError(implode('<br>', [
                '<strong>PHP Error</strong>',
                get_class($th),
                $th->getMessage()
            ]));
        }
        return ob_get_clean();
    }

    static function className(): string
    {
        return 'PHP script';
    }

    static function description(): string
    {
        return 'Execute arbitrary PHP code and render its output to the page.';
    }
}
