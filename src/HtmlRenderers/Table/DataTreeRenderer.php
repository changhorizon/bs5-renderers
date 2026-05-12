<?php

declare(strict_types=1);

namespace ChangHorizon\BS5Renderers\HtmlRenderers\Table;

class DataTreeRenderer
{
    private TableHeadRenderer $headRenderer;

    /** @var array */
    private array $tree = [];

    private string $idKey = 'id';

    private string $labelKey = 'label';

    private string $childrenKey = 'children';

    private string $tableClass = 'table table-tree';

    private int $depth = 0;

    public function __construct()
    {
        $this->headRenderer = new TableHeadRenderer();
    }

    public function head(): TableHeadRenderer
    {
        return $this->headRenderer;
    }

    public function tree(array $tree): self
    {
        $this->tree = $tree;

        return $this;
    }

    public function idKey(string $key): self
    {
        $this->idKey = $key;

        return $this;
    }

    public function labelKey(string $key): self
    {
        $this->labelKey = $key;

        return $this;
    }

    public function childrenKey(string $key): self
    {
        $this->childrenKey = $key;

        return $this;
    }

    public function tableClass(string $class): self
    {
        $this->tableClass = $class;

        return $this;
    }

    public function render(): string
    {
        $html = sprintf('<table class="%s">', htmlspecialchars($this->tableClass));
        $html .= $this->headRenderer->render();
        $html .= '<tbody>';
        $this->depth = 0;
        $html .= $this->renderNodes($this->tree);
        $html .= '</tbody></table>';

        return $html;
    }

    private function renderNodes(array $nodes): string
    {
        $html = '';

        foreach ($nodes as $node) {
            $hasChildren = isset($node[$this->childrenKey]) && $node[$this->childrenKey] !== [];
            $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $this->depth);
            $nodeId = htmlspecialchars((string) ($node[$this->idKey] ?? ''));
            $toggle = $hasChildren
                ? sprintf(
                    '<span class="tree-toggle" data-toggle="collapse" data-target="#children-%s">&#9660;</span> ',
                    $nodeId,
                )
                : '<span class="tree-toggle-placeholder">&nbsp;&nbsp;&nbsp;</span> ';

            $label = htmlspecialchars((string) ($node[$this->labelKey] ?? ''));
            $html .= sprintf('<tr id="row-%s"><td>%s%s%s</td>', $nodeId, $indent, $toggle, $label);

            $data = $node['data'] ?? [];
            foreach ($data as $value) {
                $html .= sprintf('<td>%s</td>', htmlspecialchars((string) $value));
            }
            $html .= '</tr>';

            if ($hasChildren) {
                $show = $this->depth === 0 ? ' show' : '';
                $html .= sprintf(
                    '<tbody id="children-%s" class="collapse%s">',
                    $nodeId,
                    $show,
                );
                $this->depth++;
                $html .= $this->renderNodes($node[$this->childrenKey]);
                $this->depth--;
                $html .= '</tbody>';
            }
        }

        return $html;
    }
}
