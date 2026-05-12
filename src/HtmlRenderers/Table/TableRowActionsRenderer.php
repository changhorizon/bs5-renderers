<?php

declare(strict_types=1);

namespace ChangHorizon\Bs5Renderers\HtmlRenderers\Table;

class TableRowActionsRenderer
{
    /** @var array<int, array{label: string, url: string, style: string, icon: string, confirm: string}> */
    private array $actions = [];

    public function add(string $label, string $url, string $style = 'primary', string $icon = '', string $confirm = ''): self
    {
        $this->actions[] = [
            'label'   => $label,
            'url'     => $url,
            'style'   => $style,
            'icon'    => $icon,
            'confirm' => $confirm,
        ];

        return $this;
    }

    public function render(): string
    {
        if ($this->actions === []) {
            return '<td></td>';
        }

        $html = '<td class="actions"><div class="btn-group btn-group-sm">';

        foreach ($this->actions as $action) {
            $onclick = $action['confirm'] !== ''
                ? sprintf(' onclick="return confirm(\'%s\')"', htmlspecialchars($action['confirm'], ENT_QUOTES))
                : '';

            $iconHtml = $action['icon'] !== ''
                ? sprintf('<i class="bi bi-%s"></i> ', htmlspecialchars($action['icon']))
                : '';

            $html .= sprintf(
                '<a href="%s" class="btn btn-%s"%s>%s%s</a>',
                htmlspecialchars($action['url'], ENT_QUOTES),
                htmlspecialchars($action['style']),
                $onclick,
                $iconHtml,
                htmlspecialchars($action['label']),
            );
        }

        $html .= '</div></td>';

        return $html;
    }
}
