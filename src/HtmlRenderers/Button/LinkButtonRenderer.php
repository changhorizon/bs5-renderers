<?php

declare(strict_types=1);

namespace ChangHorizon\BS5Renderers\HtmlRenderers\Button;

class LinkButtonRenderer
{
    private string $href = '#';

    private string $label = '';

    private string $style = 'primary';

    private string $size = '';

    private bool $disabled = false;

    private array $extraAttributes = [];

    public function href(string $href): self
    {
        $this->href = $href;

        return $this;
    }

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

        if ($this->disabled) {
            $classes[] = 'disabled';
        }

        $attrs = [
            'href'  => $this->disabled ? '#' : $this->href,
            'class' => implode(' ', $classes),
            'role'  => 'button',
        ];

        if ($this->disabled) {
            $attrs['aria-disabled'] = 'true';
            $attrs['tabindex'] = '-1';
        }

        foreach ($this->extraAttributes as $name => $value) {
            $attrs[$name] = $value;
        }

        $attrStr = implode(' ', array_map(
            fn(string $name, string $value): string => sprintf('%s="%s"', $name, htmlspecialchars($value, ENT_QUOTES)),
            array_keys($attrs),
            $attrs,
        ));

        return sprintf('<a %s>%s</a>', $attrStr, htmlspecialchars($this->label));
    }
}
