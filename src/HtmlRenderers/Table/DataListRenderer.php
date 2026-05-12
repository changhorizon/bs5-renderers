<?php

declare(strict_types=1);

namespace Renderers\HtmlRenderers\Table;

class DataListRenderer
{
    private TableHeadRenderer $headRenderer;

    private TableRowRenderer $rowRenderer;

    private TableRowActionsRenderer $actionsRenderer;

    /** @var array<int, array<string, string>> */
    private array $rows = [];

    private string $emptyMessage = 'No records found.';

    private bool $showActions = false;

    private string $tableClass = 'table table-striped table-hover';

    public function __construct()
    {
        $this->headRenderer = new TableHeadRenderer();
        $this->rowRenderer = new TableRowRenderer();
        $this->actionsRenderer = new TableRowActionsRenderer();
    }

    public function head(): TableHeadRenderer
    {
        return $this->headRenderer;
    }

    public function row(): TableRowRenderer
    {
        return $this->rowRenderer;
    }

    public function actions(): TableRowActionsRenderer
    {
        $this->showActions = true;

        return $this->actionsRenderer;
    }

    /** @param array<int, array<string, string>> $rows */
    public function data(array $rows): self
    {
        $this->rows = $rows;

        return $this;
    }

    public function emptyMessage(string $message): self
    {
        $this->emptyMessage = $message;

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

        if ($this->rows === []) {
            $colspan = $this->showActions ? $this->headRenderer->count() + 1 : $this->headRenderer->count();
            $colspan = max($colspan, 1);
            $html .= sprintf(
                '<tbody><tr><td colspan="%d" class="text-center text-muted">%s</td></tr></tbody>',
                $colspan,
                htmlspecialchars($this->emptyMessage),
            );
        } else {
            $html .= '<tbody>';
            foreach ($this->rows as $row) {
                $this->rowRenderer->data($row);
                $html .= $this->rowRenderer->render();
                if ($this->showActions) {
                    $html .= $this->actionsRenderer->render();
                }
                $html .= '</tr>';
            }
            $html .= '</tbody>';
        }

        $html .= '</table>';

        return $html;
    }
}
