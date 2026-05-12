<?php

declare(strict_types=1);

namespace Renderers\HtmlRenderers\Nav;

class BreadcrumbRenderer
{
    /** @var array<int, array{label: string, url: ?string}> */
    private array $items = [];

    public function add(string $label, ?string $url = null): self
    {
        $this->items[] = ['label' => $label, 'url' => $url];

        return $this;
    }

    public function render(): string
    {
        if ($this->items === []) {
            return '';
        }

        $html = '<nav aria-label="breadcrumb"><ol class="breadcrumb">';

        $last = array_key_last($this->items);

        foreach ($this->items as $index => $item) {
            $active = $index === $last;

            if ($active) {
                $html .= sprintf(
                    '<li class="breadcrumb-item active" aria-current="page">%s</li>',
                    htmlspecialchars($item['label']),
                );
            } elseif ($item['url'] !== null) {
                $html .= sprintf(
                    '<li class="breadcrumb-item"><a href="%s">%s</a></li>',
                    htmlspecialchars($item['url'], ENT_QUOTES),
                    htmlspecialchars($item['label']),
                );
            } else {
                $html .= sprintf(
                    '<li class="breadcrumb-item">%s</li>',
                    htmlspecialchars($item['label']),
                );
            }
        }

        $html .= '</ol></nav>';

        return $html;
    }
}
