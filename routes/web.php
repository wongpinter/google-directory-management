<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('get', function (\App\Libraries\GoogleDirectory\Users $user, \Illuminate\Http\Request $request) use ($router) {
    return $user->get($request->get('email'));
});

$router->delete('delete', function (\App\Libraries\GoogleDirectory\Users $user, \Illuminate\Http\Request $request) use ($router) {
    return $user->delete($request->get('email'));
});

$router->patch('reset', function (\App\Libraries\GoogleDirectory\Users $user, \Illuminate\Http\Request $request) use ($router) {
    return $user->passwordReset($request->get('email'), $request->get('new_password'), $request->get('change'), $request->get('random'));
});

$router->post('store', function (\App\Libraries\GoogleDirectory\Users $user, \Illuminate\Http\Request $request) use ($router) {
    return $user->store($request->all());
});