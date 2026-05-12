<?php

declare(strict_types=1);

namespace ChangHorizon\BS5Renderers\View;

use ChangHorizon\BS5Renderers\HtmlRenderers\Nav\BreadcrumbRenderer;
use ChangHorizon\BS5Renderers\HtmlRenderers\Table\DataListRenderer;

class LocaleRender
{
    private BreadcrumbRenderer $breadcrumb;

    private DataListRenderer $localeTable;

    private DataListRenderer $languageTable;

    private DataListRenderer $regionTable;

    private DataListRenderer $currencyTable;

    public function __construct()
    {
        $this->breadcrumb = new BreadcrumbRenderer();
        $this->localeTable = new DataListRenderer();
        $this->languageTable = new DataListRenderer();
        $this->regionTable = new DataListRenderer();
        $this->currencyTable = new DataListRenderer();
    }

    public function breadcrumb(): BreadcrumbRenderer
    {
        return $this->breadcrumb;
    }

    public function localeTable(): DataListRenderer
    {
        return $this->localeTable;
    }

    public function languageTable(): DataListRenderer
    {
        return $this->languageTable;
    }

    public function regionTable(): DataListRenderer
    {
        return $this->regionTable;
    }

    public function currencyTable(): DataListRenderer
    {
        return $this->currencyTable;
    }

    public function render(): string
    {
        $html = '<div class="container-fluid">';
        $html .= '<div class="row"><div class="col-12">';
        $html .= $this->breadcrumb->render();
        $html .= '</div></div>';

        $html .= '<div class="row"><div class="col-12">';
        $html .= '<div class="card"><div class="card-header"><h5 class="card-title mb-0">Locales</h5></div><div class="card-body">';
        $html .= $this->localeTable->render();
        $html .= '</div></div></div></div>';

        $html .= '<div class="row mt-3"><div class="col-6">';
        $html .= '<div class="card"><div class="card-header"><h5 class="card-title mb-0">Languages</h5></div><div class="card-body">';
        $html .= $this->languageTable->render();
        $html .= '</div></div></div>';

        $html .= '<div class="col-6">';
        $html .= '<div class="card"><div class="card-header"><h5 class="card-title mb-0">Regions</h5></div><div class="card-body">';
        $html .= $this->regionTable->render();
        $html .= '</div></div></div></div>';

        $html .= '<div class="row mt-3"><div class="col-12">';
        $html .= '<div class="card"><div class="card-header"><h5 class="card-title mb-0">Currencies</h5></div><div class="card-body">';
        $html .= $this->currencyTable->render();
        $html .= '</div></div></div></div>';

        $html .= '</div>';

        return $html;
    }
}
