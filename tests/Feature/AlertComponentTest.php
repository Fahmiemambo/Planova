<?php

use Illuminate\Support\Facades\Blade;

it('renders alert component without blade syntax errors', function () {
    $html = Blade::render('<x-alert type="danger" message="Hello from alert" />');

    expect($html)->toContain('Hello from alert')
        ->and($html)->toContain('alert-p-danger');
});
