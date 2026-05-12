<?php

declare(strict_types=1);

namespace ChangHorizon\BS5Renderers\HtmlRenderers\Table;

class TableHeadRenderer
{
    /** @var array<int, array{label: string, sortable: bool, sortKey: string, width: string}> */
    private array $columns = [];

    private string $sortColumn = '';

    private string $sortDirection = 'asc';

    public function addColumn(string $label, bool $sortable = false, string $sortKey = '', string $width = ''): self
    {
        $this->columns[] = [
            'label'    => $label,
            'sortable' => $sortable,
            'sortKey'  => $sortKey ?: $label,
            'width'    => $width,
        ];

        return $this;
    }

    public function sortBy(string $column, string $direction = 'asc'): self
    {
        $this->sortColumn = $column;
        $this->sortDirection = $direction;

        return $this;
    }

    public function count(): int
    {
        return count($this->columns);
    }

    public function render(): string
    {
        if ($this->columns === []) {
            return '';
        }

        $html = '<thead><tr>';

        foreach ($this->columns as $col) {
            $style = $col['width'] !== '' ? sprintf(' style="width:%s"', htmlspecialchars($col['width'])) : '';

            if ($col['sortable']) {
                $isActive = $this->sortColumn === $col['sortKey'];
                $dir = $isActive && $this->sortDirection === 'asc' ? 'desc' : 'asc';
                $arrow = $isActive ? ($this->sortDirection === 'asc' ? ' &#9650;' : ' &#9660;') : '';

                $html .= sprintf(
                    '<th%s><a href="?sort=%s&amp;dir=%s" class="sort-link">%s%s</a></th>',
                    $style,
                    htmlspecialchars($col['sortKey'], ENT_QUOTES),
                    htmlspecialchars($dir, ENT_QUOTES),
                    htmlspecialchars($col['label']),
                    $arrow,
                );
            } else {
                $html .= sprintf('<th%s>%s</th>', $style, htmlspecialchars($col['label']));
            }
        }

        $html .= '</tr></thead>';

        return $html;
    }
}
