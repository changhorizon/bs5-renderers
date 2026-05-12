# BS5 Renderers

> Bootstrap 5 HTML rendering components for admin panels

![License](https://img.shields.io/github/license/changhorizon/bs5-renderers?style=flat-square)
![Latest Version](https://img.shields.io/packagist/v/changhorizon/bs5-renderers?style=flat-square)
![PHP Version](https://img.shields.io/badge/php-8.2--8.4-blue?style=flat-square)
![Static Analysis](https://img.shields.io/badge/static_analysis-PHPStan-blue?style=flat-square)
![Tests](https://img.shields.io/badge/tests-PHPUnit-brightgreen?style=flat-square)
[![codecov](https://codecov.io/gh/changhorizon/bs5-renderers/branch/main/graph/badge.svg)](https://codecov.io/gh/changhorizon/bs5-renderers)
![CI](https://github.com/changhorizon/bs5-renderers/actions/workflows/ci.yml/badge.svg?style=flat-square)

## ✨ 特性

- 🔗 **Link button** — 可设 href、style、size、disabled 状态
- 🎛️ **Form button** — 支持 type（submit/reset/button）、name、value、disabled
- 🍞 **Breadcrumb** — 面包屑导航，自动标记最后一项为 active
- 📊 **Data list table** — 平面数据表，支持可排序列头、空数据提示、行操作按钮
- 🌲 **Data tree table** — 递归树形表，支持展开/折叠、层级缩进
- ⚡ **Row actions** — 行操作按钮组，支持确认弹窗、图标

## 📦 安装

```bash
composer require changhorizon/bs5-renderers
```

## 📂 目录结构

```txt
src/
├── HtmlRenderers/
│   ├── Button/
│   │   ├── LinkButtonRenderer.php      # <a> 风格按钮
│   │   └── FormButtonRenderer.php      # <button> 风格表单按钮
│   ├── Nav/
│   │   └── BreadcrumbRenderer.php      # 面包屑导航
│   └── Table/
│       ├── TableHeadRenderer.php       # 表头（可排序）
│       ├── TableRowRenderer.php        # 数据行
│       ├── TableRowActionsRenderer.php # 行操作按钮列
│       ├── DataListRenderer.php        # 平面数据表
│       └── DataTreeRenderer.php        # 递归树形表
└── View/
    ├── LocaleRender.php                # locale 管理页面
    └── PageRender.php                  # CMS 页面管理
```

## 🚀 用法示例

### Link Button

```php
use ChangHorizon\Bs5Renderers\HtmlChangHorizon\Bs5Renderers\Button\LinkButtonRenderer;

$btn = (new LinkButtonRenderer())
    ->href('/admin/users/create')
    ->label('Add User')
    ->style('success')
    ->size('sm');

echo $btn->render();
// <a href="/admin/users/create" class="btn btn-success btn-sm" role="button">Add User</a>
```

### Form Button

```php
use ChangHorizon\Bs5Renderers\HtmlChangHorizon\Bs5Renderers\Button\FormButtonRenderer;

$btn = (new FormButtonRenderer())
    ->label('Delete')
    ->style('danger')
    ->name('action')
    ->value('delete');

echo $btn->render();
// <button type="submit" class="btn btn-danger" name="action" value="delete">Delete</button>
```

### Breadcrumb

```php
use ChangHorizon\Bs5Renderers\HtmlChangHorizon\Bs5Renderers\Nav\BreadcrumbRenderer;

$bc = (new BreadcrumbRenderer())
    ->add('Home', '/')
    ->add('Users', '/users')
    ->add('Edit');

echo $bc->render();
// <nav aria-label="breadcrumb"><ol class="breadcrumb">...
```

### Data List Table

```php
use ChangHorizon\Bs5Renderers\HtmlChangHorizon\Bs5Renderers\Table\DataListRenderer;

$table = new DataListRenderer();
$table->head()
    ->addColumn('Name', true, 'name')
    ->addColumn('Email', true, 'email')
    ->addColumn('Role');
$table->actions()
    ->add('Edit', '/users/1/edit', 'primary', 'pencil')
    ->add('Delete', '/users/1/delete', 'danger', 'trash', 'Are you sure?');
$table->data([
    ['name' => 'Alice', 'email' => 'alice@example.com', 'role' => 'Admin'],
    ['name' => 'Bob', 'email' => 'bob@example.com', 'role' => 'Editor'],
]);

echo $table->render();
```

### Data Tree Table

```php
use ChangHorizon\Bs5Renderers\HtmlChangHorizon\Bs5Renderers\Table\DataTreeRenderer;

$tree = new DataTreeRenderer();
$tree->head()->addColumn('Category')->addColumn('Slug');
$tree->tree([
    ['id' => '1', 'label' => 'Root', 'data' => ['slug' => 'root'], 'children' => [
        ['id' => '2', 'label' => 'Child A', 'data' => ['slug' => 'child-a'], 'children' => []],
        ['id' => '3', 'label' => 'Child B', 'data' => ['slug' => 'child-b'], 'children' => []],
    ]],
]);

echo $tree->render();
```

### Page Render

```php
use ChangHorizon\Bs5Renderers\View\PageRender;

$page = new PageRender();
$page->breadcrumb()->add('Home', '/')->add('Pages');
$page->addButton()->href('/pages/create')->label('Add Page');
$page->tree()->head()->addColumn('Title')->addColumn('Status');
$page->tree()->tree([/* ... */]);

echo $page->render();
// 完整 Bootstrap 5 页面布局：面包屑 + 卡片 + 树形表格
```

## 📐 接口说明

所有 HtmlRenderer 类均使用流畅 setter 模式，链式调用后调用 `render()` 返回 HTML 字符串。

### LinkButtonRenderer

| 方法 | 说明 |
|------|------|
| `href(string)` | 链接地址 |
| `label(string)` | 按钮文字 |
| `style(string)` | Bootstrap 样式 (primary/success/danger/...) |
| `size(string)` | 尺寸 (sm/lg) |
| `disabled(bool)` | 禁用状态 |
| `attribute(name, value)` | 自定义 HTML 属性 |

### DataListRenderer

| 方法 | 说明 |
|------|------|
| `head(): TableHeadRenderer` | 配置表头列 |
| `row(): TableRowRenderer` | 配置行 |
| `actions(): TableRowActionsRenderer` | 启用并配置操作按钮列 |
| `data(array)` | 设置数据行 |
| `emptyMessage(string)` | 空数据提示文字 |
| `tableClass(string)` | 表格 CSS 类 |

### DataTreeRenderer

| 方法 | 说明 |
|------|------|
| `head(): TableHeadRenderer` | 配置表头列 |
| `tree(array)` | 设置树形数据 |
| `idKey(string)` | 节点 ID 字段名（默认 id） |
| `labelKey(string)` | 节点标签字段名（默认 label） |
| `childrenKey(string)` | 子节点字段名（默认 children） |

## 🔍 静态分析

```bash
composer stan
```

## 🎯 代码风格

```bash
composer cs:chk    # check
composer cs:fix    # auto-fix
```

## ✅ 单元测试

```bash
composer test
composer test:coverage
```

## 🤝 贡献指南

欢迎 Issue 与 PR，建议遵循以下流程：

1. Fork 仓库
2. 创建新分支进行开发
3. 提交 PR 前请确保测试通过、风格一致
4. 提交详细描述

## 📜 License

MIT License. See the [LICENSE](LICENSE) file for details.
