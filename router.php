<?php

$app->get('/test/{id}', function ($params) {
    return ' asdfasdfasd ddd ' . $params[1];
});
