<?php

namespace DigraphCMS_Plugins\byjoby\hackery;

use DigraphCMS\CodeMirror\CodeMirrorField;
use DigraphCMS\FS;
use DigraphCMS\HTML\Forms\Field;
use DigraphCMS\HTML\Forms\FormWrapper;
use DigraphCMS\HTML\Forms\SELECT;
use DigraphCMS\Media\CSS;
use DigraphCMS\Media\DeferredFile;
use DigraphCMS\RichMedia\Types\AbstractRichMedia;
use DigraphCMS\UI\Notifications;
use DigraphCMS\UI\Theme;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class ScssRichMedia extends AbstractRichMedia
{
    protected $addedToTheme = false;

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

        // mode
        $mode = (new Field('Embed mode', new SELECT([
            'async' => 'Asynchronous',
            'blocking' => 'Blocking'
        ])))
            ->setDefault($this['mode'] ?? 'async')
            ->addForm($form);

        // scope
        $scope = (new Field('Automatic scope', $scopeInput = new SELECT([
            'none' => 'None - compile as written',
            'parent' => 'Parent-specific wrapper',
            'article' => 'Any article wrapper',
        ])))
            ->setDefault($this['scope'] ?? 'page')
            ->addForm($form);

        // handler
        $form->addCallback(function () use ($name, $script, $mode, $scope) {
            $this->name($name->value());
            $this['script'] = $script->value();
            $this['mode'] = $mode->value();
            $this['scope'] = $scope->value();
        });
    }

    function script(): string
    {
        $script = $this['script'];
        // decide on scope wrapper
        $scope = null;
        if ($this['scope'] == 'article') $scope = '#article';
        elseif ($this['scope'] == 'parent') $scope = '.page--' . $this->parent();
        // apply scope wrapper if specified
        if ($scope) $script = implode(PHP_EOL, ["$scope {", $script, "}"]);
        // return
        return $script;
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
                        CSS::scss($this->script())
                    );
                },
                [$this->uuid(), $this->updated()->getTimestamp()]
            );
            if (!$this->addedToTheme) {
                $this->addedToTheme = true;
                if ($this['mode'] == 'blocking') Theme::addBlockingPageCss($file);
                else Theme::addInternalPageCss($file);
                echo '<!-- added scss ' . $this->uuid() . ' "' . $this->name() . '" to the rendering pipeline -->';
            } else {
                echo '<!-- already added scss ' . $this->uuid() . ' "' . $this->name() . '" to the rendering pipeline -->';
            }
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
