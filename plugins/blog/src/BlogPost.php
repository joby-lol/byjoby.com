<?php

namespace DigraphCMS_Plugins\byjoby\blog;

use DateTime;
use DigraphCMS\Content\Page;
use DigraphCMS\HTML\DIV;
use DigraphCMS\UI\Format;
use DigraphCMS\URL\URL;
use Urodoz\Truncate\TruncateService;

class BlogPost extends Page
{
    const DEFAULT_SLUG = '[blogprefix][name]';
    protected $card;

    public function summaryCard(): DIV
    {
        if (!$this->card) {
            $this->card = new DIV;
            $this->card->addClass('blog-summary-card');
            $this->card->addClass('page--' . $this->uuid());
            $this->card->addChild(sprintf('<h1><a href="%s">%s</a></h1>', $this->url(), $this->postTitle()));
            $this->card->addChild(sprintf('<p class="blog-meta">%s by %s</p>', Format::datetime($this->time()), $this->createdBy()));
            $this->card->addChild($this->blurb());
        }
        return $this->card;
    }

    public function postTitle(): string
    {
        if (preg_match("@<h1[^>]*>(.+?)</h1>@i", $this->richContent('body'), $matches)) {
            return trim(strip_tags($matches[1]));
        } else return $this->name();
    }

    public function blurb(): string
    {
        $blurb = trim(preg_replace('@<h1[^>]*>(.+?)</h1>@i', '', $this->richContent('body'), 1));
        return Format::truncateHTML(
            $blurb,
            500,
            sprintf(PHP_EOL . '<p class="blog-readmore"><a href="%s">read more</a></p>', $this->url())
        );
    }

    public function time(): DateTime
    {
        if ($this['time']) return (new DateTime())->setTimestamp($this['time']);
        else return $this->created();
    }

    public function customTime(): ?DateTime
    {
        if ($this['time']) return (new DateTime())->setTimestamp($this['time']);
        else return null;
    }

    public function slugVariable(string $name): ?string
    {
        switch ($name) {
            case 'blogprefix':
                return $this->parentPage() ? '' : '/blog/';
            default:
                return parent::slugVariable($name);
        }
    }

    public function parent(?URL $url = null): ?URL
    {
        if ($this->parentPage()) return parent::parent($url);
        elseif ($url->action() == 'index') return new URL('/blog/');
        else return parent::parent($url);
    }

    public function setTime(?DateTime $time)
    {
        if ($time) $this['time'] = $time->getTimestamp();
        else unset($this['time']);
        return $this;
    }

    public function routeClasses(): array
    {
        return ['blog', '_any'];
    }
}
