<?php

declare(strict_types=1);

namespace ChangHorizon\BS5Renderers\View;

use ChangHorizon\BS5Renderers\HtmlRenderers\Button\LinkButtonRenderer;
use ChangHorizon\BS5Renderers\HtmlRenderers\Nav\BreadcrumbRenderer;
use ChangHorizon\BS5Renderers\HtmlRenderers\Table\DataTreeRenderer;

class PageRender
{
    private BreadcrumbRenderer $breadcrumb;

    private DataTreeRenderer $tree;

    private LinkButtonRenderer $addButton;

    public function __construct()
    {
        $this->breadcrumb = new BreadcrumbRenderer();
        $this->tree       = new DataTreeRenderer();
        $this->addButton  = new LinkButtonRenderer();
    }

    public function breadcrumb(): BreadcrumbRenderer
    {
        return $this->breadcrumb;
    }

    public function tree(): DataTreeRenderer
    {
        return $this->tree;
    }

    public function addButton(): LinkButtonRenderer
    {
        return $this->addButton;
    }

    public function render(): string
    {
        $html = '<div class="container-fluid">';
        $html .= '<div class="row"><div class="col-12">';
        $html .= $this->breadcrumb->render();
        $html .= '</div></div>';

        $html .= '<div class="row"><div class="col-12">';
        $html .= '<div class="card"><div class="card-header">';
        $html .= '<div class="d-flex justify-content-between align-items-center">';
        $html .= '<h5 class="card-title mb-0">Pages</h5>';
        $html .= $this->addButton->render();
        $html .= '</div></div><div class="card-body">';
        $html .= $this->tree->render();
        $html .= '</div></div></div></div>';
        $html .= '</div>';

        return $html;
    }
}
