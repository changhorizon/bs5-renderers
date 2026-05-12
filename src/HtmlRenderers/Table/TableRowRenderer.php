<?php

declare(strict_types=1);

namespace ChangHorizon\BS5Renderers\HtmlRenderers\Table;

class TableRowRenderer
{
    /** @var array<string, string> */
    private array $data = [];

    /** @var array<int, string> */
    private array $columnOrder = [];

    private string $rowClass = '';

    private string $id = '';

    /** @param array<string, string> $data */
    public function data(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /** @param array<int, string> $order */
    public function columns(array $order): self
    {
        $this->columnOrder = $order;

        return $this;
    }

    public function rowClass(string $class): self
    {
        $this->rowClass = $class;

        return $this;
    }

    public function id(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function render(): string
    {
        $attrs = sprintf('class="%s"', htmlspecialchars($this->rowClass));

        if ($this->id !== '') {
            $attrs .= sprintf(' id="%s"', htmlspecialchars($this->id));
        }

        $cols = $this->columnOrder !== [] ? $this->columnOrder : array_keys($this->data);

        $cells = array_map(fn (string $key): string => sprintf(
            '<td>%s</td>',
            $this->data[$key] ?? '',
        ), $cols);

        return sprintf('<tr %s>%s</tr>', $attrs, implode('', $cells));
    }
}
