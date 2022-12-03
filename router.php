<?php

$router->get('/test/{id}', function ($params) {
    return ' asdfasdfasd ddd ' . $params[1];
});
