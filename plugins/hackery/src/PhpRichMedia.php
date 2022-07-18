<?php

namespace DigraphCMS_Plugins\byjoby\hackery;

use DigraphCMS\Cache\CacheNamespace;
use DigraphCMS\CodeMirror\CodeMirrorField;
use DigraphCMS\Context;
use DigraphCMS\HTML\Forms\Field;
use DigraphCMS\HTML\Forms\Fields\CheckboxField;
use DigraphCMS\HTML\Forms\FormWrapper;
use DigraphCMS\HTML\Forms\SELECT;
use DigraphCMS\HTML\Icon;
use DigraphCMS\RichMedia\Types\AbstractRichMedia;
use DigraphCMS\UI\Notifications;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class PhpRichMedia extends AbstractRichMedia
{

    public function icon()
    {
        return new Icon('code');
    }

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

        // cache settings
        $cache = (new Field('Cache output', new SELECT([
            60 => '1 minute',
            300 => '5 minutes',
            3600 => '1 hour',
            86400 => '24 hours',
            1 => 'Do not cache (actually 1 second)',
            -1 => 'Cache indefinitely'
        ])))
            ->setDefault($this['cache'] ?? 60)
            ->addForm($form);

        // context dependence toggle
        $context = (new CheckboxField('Context-dependent cache'))
            ->setDefault($this['context'] ?? true)
            ->addForm($form);

        // handler
        $form->addCallback(function () use ($name, $script, $cache, $context) {
            $this->name($name->value());
            $this['script'] = $script->value();
            $this['cache'] = $cache->value();
            $this['context'] = $context->value();
        });
    }

    function shortCode(ShortcodeInterface $code): ?string
    {
        $cache = $this['cache'] ? Context::cache('phprichmedia') : new CacheNamespace('phprichmedia');
        return $cache->get(
            $this->uuid() . $this->updated()->getTimestamp(),
            function () {
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
            },
            $this['cache'] ?? 60
        );
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
