<?php

declare(strict_types=1);

namespace ChangHorizon\BS5Renderers\HtmlRenderers\Button;

class FormButtonRenderer
{
    private string $label = '';

    private string $style = 'primary';

    private string $size = '';

    private string $type = 'submit';

    private string $name = '';

    private string $value = '';

    private bool $disabled = false;

    /** @var array<string, string> */
    private array $extraAttributes = [];

    public function label(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function style(string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function size(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function value(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function disabled(bool $disabled = true): self
    {
        $this->disabled = $disabled;

        return $this;
    }

    public function attribute(string $name, string $value): self
    {
        $this->extraAttributes[$name] = $value;

        return $this;
    }

    public function render(): string
    {
        $classes = ['btn', "btn-{$this->style}"];

        if ($this->size !== '') {
            $classes[] = "btn-{$this->size}";
        }

        $attrs = [
            'type'  => $this->type,
            'class' => implode(' ', $classes),
        ];

        if ($this->name !== '') {
            $attrs['name'] = $this->name;
        }

        if ($this->value !== '') {
            $attrs['value'] = $this->value;
        }

        if ($this->disabled) {
            $attrs['disabled'] = 'disabled';
        }

        foreach ($this->extraAttributes as $name => $value) {
            $attrs[$name] = $value;
        }

        $parts = [];

        foreach ($attrs as $name => $value) {
            $parts[] = sprintf('%s="%s"', $name, htmlspecialchars($value, ENT_QUOTES));
        }
        $attrStr = implode(' ', $parts);

        return sprintf('<button %s>%s</button>', $attrStr, htmlspecialchars($this->label));
    }
}
