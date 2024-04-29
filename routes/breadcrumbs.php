<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('manage.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('manage.dashboard'));
});

Breadcrumbs::for('manage.people.admins.list', function (BreadcrumbTrail $trail) {
    $trail->parent('manage.dashboard');
    $trail->push('Admins', route('manage.people.admins.list'));
});

Breadcrumbs::for('manage.people.users.list', function (BreadcrumbTrail $trail) {
    $trail->parent('manage.dashboard');
    $trail->push('Users', route('manage.people.users.list'));
});


