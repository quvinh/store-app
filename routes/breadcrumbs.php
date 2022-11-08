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