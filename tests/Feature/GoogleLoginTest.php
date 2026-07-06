<?php

it('shows a google login button on the login page', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
    $response->assertSee('Masuk dengan Google');
});
