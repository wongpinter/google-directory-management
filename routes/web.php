<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('get', function (\App\Libraries\GoogleDirectory\Users $user, \Illuminate\Http\Request $request) use ($router) {
    return $user->get($request->only('email'));
});

$router->delete('delete', function (\App\Libraries\GoogleDirectory\Users $user, \Illuminate\Http\Request $request) use ($router) {
    return $user->delete($request->only('email'));
});

$router->patch('reset', function (\App\Libraries\GoogleDirectory\Users $user, \Illuminate\Http\Request $request) use ($router) {
    return $user->passwordReset($request->only('email'), $request->only('new_password'), $request->only('change'), $request->only('random'));
});

$router->post('store', function (\App\Libraries\GoogleDirectory\Users $user, \Illuminate\Http\Request $request) use ($router) {
    return $user->store($request->all());
});