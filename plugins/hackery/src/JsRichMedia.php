<?php

namespace DigraphCMS_Plugins\byjoby\hackery;

use DigraphCMS\CodeMirror\CodeMirrorField;
use DigraphCMS\FS;
use DigraphCMS\HTML\Forms\Field;
use DigraphCMS\HTML\Forms\FormWrapper;
use DigraphCMS\Media\DeferredFile;
use DigraphCMS\Media\JS;
use DigraphCMS\RichMedia\Types\AbstractRichMedia;
use DigraphCMS\UI\Notifications;
use DigraphCMS\UI\Theme;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class JsRichMedia extends AbstractRichMedia
{
    function prepareForm(FormWrapper $form, $create = false)
    {
        // name input
        $name = (new Field('Name'))
            ->setDefault($this->name())
            ->setRequired(true)
            ->addForm($form);

        // script editor
        $script = (new CodeMirrorField('Javascript', 'javascript'))
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
                $this->uuid() . '.js',
                function(DeferredFile $file){
                    FS::touch($file->path());
                    file_put_contents(
                        $file->path(),
                        JS::js($this['script'])
                    );
                },
                md5($this->uuid() . $this->updated()->getTimestamp())
            );
            if ($this['mode'] == 'blocking') Theme::addBlockingPageJs($file);
            elseif ($this['mode'] == 'async') Theme::addPageJs($file);
            else Theme::addInlinePageJs($file);
            echo '<!-- added js ' . $this->uuid() . ' "' . $this->name() . '" to the rendering pipeline -->';
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
        return 'Javascript file';
    }

    static function description(): string
    {
        return 'Enter arbitrary Javascript to be loaded on pages where this media is placed.';
    }
}
