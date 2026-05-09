<?php

require 'vendor/autoload.php';

require_once 'RedisExample.php';
require_once 'ElasticExample.php';
require_once 'ClickhouseExample.php';

echo "<h1>Лабораторная работа №6: Соцсеть (Вариант 16)</h1>";

try {
    echo "<h3>1. Проверка Redis:</h3>";
    $redis = new RedisExample();
    $redis->setValue('framework', 'predis');
    echo "Данные из Redis: <b>" . $redis->getValue('framework') . "</b><br><hr>";

    echo "<h3>2. Elasticsearch (Поиск пользователей):</h3>";
    $elastic = new ElasticExample();

    $elastic->indexUser(1, [
        'name' => 'артем', 
        'bio' => 'php dev', 
        'tags' => 'backend, devops'
    ]);
    $elastic->indexUser(2, [
        'name' => 'Владислав', 
        'bio' => 'web designer', 
        'tags' => 'frontend, ui-ux'
    ]);

    echo "<b>Результат поиска по тегу 'backend':</b>";
    echo "<pre>" . $elastic->searchUser(['tags' => 'backend']) . "</pre><hr>";


    echo "<h3>3. Проверка ClickHouse:</h3>";
    $click = new ClickhouseExample();

    $click->query("CREATE TABLE IF NOT EXISTS user_logs (id UInt32, name String, age UInt8) ENGINE = MergeTree() ORDER BY id;");
    $click->query("INSERT INTO user_logs (id, name, age) VALUES (1, 'Ivan', 25), (2, 'Maria', 30);");
    
    echo "Данные из ClickHous:<br>";
    echo "<pre>";
    print_r($click->query("SELECT * from user_logs LIMIT 10"));
    echo "</pre>";

} catch (\Exception $e) {
    echo "<h2 style='color:red;'>Ошибка: " . $e->getMessage() . "</h2>";
}
