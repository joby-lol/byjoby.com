<?php

namespace DigraphCMS_Plugins\byjoby\hackery;

use DigraphCMS\CodeMirror\CodeMirrorField;
use DigraphCMS\FS;
use DigraphCMS\HTML\Forms\Field;
use DigraphCMS\HTML\Forms\FormWrapper;
use DigraphCMS\Media\CSS;
use DigraphCMS\Media\DeferredFile;
use DigraphCMS\RichMedia\Types\AbstractRichMedia;
use DigraphCMS\UI\Notifications;
use DigraphCMS\UI\Theme;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class ScssRichMedia extends AbstractRichMedia
{
    function prepareForm(FormWrapper $form, $create = false)
    {
        // name input
        $name = (new Field('Name'))
            ->setDefault($this->name())
            ->setRequired(true)
            ->addForm($form);

        // script editor
        $script = (new CodeMirrorField('SCSS', 'sass'))
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
            $file = new DeferredFile(
                $this->uuid() . '.css',
                function (DeferredFile $file) {
                    FS::touch($file->path());
                    file_put_contents(
                        $file->path(),
                        CSS::scss($this['script'])
                    );
                },
                [$this->uuid(), $this->updated()->getTimestamp()]
            );
            if ($this['mode'] == 'blocking') Theme::addBlockingPageCss($file);
            else Theme::addInternalPageCss($file);
            echo '<!-- added scss ' . $this->uuid() . ' "' . $this->name() . '" to the rendering pipeline -->';
        } catch (\Throwable $th) {
            Notifications::printError(implode('<br>', [
                '<strong>Javascript Error</strong>',
                get_class($th),
                $th->getMessage()
            ]));
        }
        return ob_get_clean();
    }

    static function className(): string
    {
        return 'SCSS file';
    }

    static function description(): string
    {
        return 'Enter arbitrary SCSS to be compiled and loaded on pages where this media is placed.';
    }
}
