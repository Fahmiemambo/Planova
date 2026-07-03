<?php

it('shows home page', function () {
    $this->get('/home')->assertOk()->assertSee('Planova');
});

it('shows about page', function () {
    $this->get('/about')->assertOk()->assertSee('About');
});

it('shows developers page', function () {
    $this->get('/developers')->assertOk()->assertSee('Developers');
});
