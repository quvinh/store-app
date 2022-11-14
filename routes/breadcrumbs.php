<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Illuminate\Support\Facades\Lang;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push(Lang::get('breadcrumb.dashboard'), route('dashboard.index'));
});

// Dashboard > Calendar
Breadcrumbs::for('calendar', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(Lang::get('breadcrumb.calendar'), route('calendar.index'));
});

// Dashboard > Warehouse
Breadcrumbs::for('warehouse', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(Lang::get('breadcrumb.warehouse.warehouse'), route('warehouse.warehouse-by-id'));
});

// Dashboard > ExIm
Breadcrumbs::for('ex_import', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(Lang::get('breadcrumb.ex_import.ex_import'), route('ex_import.index'));
});

// Dashboard > ExIm > Import
Breadcrumbs::for('import', function (BreadcrumbTrail $trail) {
    $trail->parent('ex_import');
    $trail->push(Lang::get('breadcrumb.import.import'), route('import.index'));
});

// Dashboard > ExIm > Import > Confirm
Breadcrumbs::for('importconfirm', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('ex_import');
    $trail->push(Lang::get('breadcrumb.import.importconfirm'), route('import.confirm', $id));
});

// Dashboard > ExIm > Import > Edit
Breadcrumbs::for('importedit', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('ex_import');
    $trail->push(Lang::get('breadcrumb.import.importedit'), route('import.edit', $id));
});

// Dashboard > ExIm > Export
Breadcrumbs::for('export', function (BreadcrumbTrail $trail) {
    $trail->parent('ex_import');
    $trail->push(Lang::get('breadcrumb.export.export'), route('export.index'));
});

// Dashboard > ExIm > Export > Confirm
Breadcrumbs::for('exportconfirm', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('ex_import');
    $trail->push(Lang::get('breadcrumb.export.exportconfirm'), route('export.confirm', $id));
});

// Dashboard > ExIm > Export > Edit
Breadcrumbs::for('exportedit', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('ex_import');
    $trail->push(Lang::get('breadcrumb.export.exportedit'), route('export.edit', $id));
});

// Dashboard > Transfer
Breadcrumbs::for('transfer', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(Lang::get('breadcrumb.transfer.transfer'), route('transfer.index'));
});

// Dashboard > Inventory
Breadcrumbs::for('inventory-item', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(Lang::get('breadcrumb.inventory.inventory'), route('inventory-item.index'));
});

// Dashboard > AdjustItem
Breadcrumbs::for('inventory', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(Lang::get('breadcrumb.adjust.adjust'), route('inventory.index'));
});

// Dashboard > AdjustItem > Add
Breadcrumbs::for('adjust-device', function (BreadcrumbTrail $trail) {
    $trail->parent('inventory');
    $trail->push(Lang::get('breadcrumb.adjust.create'), route('inventory.create'));
});

// Dashboard > AdjustItem > edit
Breadcrumbs::for('inventoryconfirm', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('inventory');
    $trail->push(Lang::get('breadcrumb.adjust.edit'), route('inventory.edit', $id));
});

// Dashboard > Item
Breadcrumbs::for('item', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(Lang::get('breadcrumb.item.item'), route('item.index'));
});

// Dashboard > Item > Add
Breadcrumbs::for('itemcreate', function (BreadcrumbTrail $trail) {
    $trail->parent('item');
    $trail->push(Lang::get('breadcrumb.item.create'), route('item.create'));
});

// Dashboard > Item > edit
Breadcrumbs::for('itemedit', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('item');
    $trail->push(Lang::get('breadcrumb.item.edit'), route('item.edit', $id));
});

// Dashboard > Category
Breadcrumbs::for('category', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(Lang::get('breadcrumb.category.category'), route('category.index'));
});

// Dashboard > Category > edit
Breadcrumbs::for('categoryedit', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('category');
    $trail->push(Lang::get('breadcrumb.category.edit'), route('category.edit', $id));
});

// Dashboard > Unit
Breadcrumbs::for('unit', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(Lang::get('breadcrumb.unit.unit'), route('unit.index'));
});

// Dashboard > Unit > edit
Breadcrumbs::for('unitedit', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('unit');
    $trail->push(Lang::get('breadcrumb.unit.edit'), route('unit.edit', $id));
});

// Dashboard > Supplier
Breadcrumbs::for('supplier', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(Lang::get('breadcrumb.supplier.supplier'), route('supplier.index'));
});

// Dashboard > Supplier > Add
Breadcrumbs::for('supplieradd', function (BreadcrumbTrail $trail) {
    $trail->parent('supplier');
    $trail->push(Lang::get('breadcrumb.supplier.create'), route('supplier.add'));
});

// Dashboard > Supplier > edit
Breadcrumbs::for('supplieredit', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('supplier');
    $trail->push(Lang::get('breadcrumb.supplier.edit'), route('supplier.edit', $id));
});

// Dashboard > Account
Breadcrumbs::for('account', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(Lang::get('breadcrumb.account.account'), route('account.index'));
});

// Dashboard > Account > Add
Breadcrumbs::for('accountcreate', function (BreadcrumbTrail $trail) {
    $trail->parent('account');
    $trail->push(Lang::get('breadcrumb.account.create'), route('account.create'));
});

// Dashboard > Account > edit
Breadcrumbs::for('accountshow', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('account');
    $trail->push(Lang::get('breadcrumb.account.show'), route('account.show', $id));
});

// Dashboard > Role
Breadcrumbs::for('role', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(Lang::get('breadcrumb.role.role'), route('admin.role'));
});

// Dashboard > Role > Edit > [ID]
Breadcrumbs::for('roleedit', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('role');
    $trail->push(Lang::get('breadcrumb.role.edit'), route('admin.role.edit', $id));
});
