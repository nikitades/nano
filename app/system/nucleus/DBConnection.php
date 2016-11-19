<?php

namespace app\system\nucleus;

interface DBConnection
{
    function __construct(Array $params);
    function establish();
    function check();
    function query($query, $arguments);
    function select(Array $params);
    function update(Array $params);
    function insert(Array $params);
    function delete(Array $params);
    function id();
}