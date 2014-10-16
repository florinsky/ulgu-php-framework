<?php

/**
 * This file contains some useful functions.
 * These are aliases to X::$app->methods.
 **/

/**
 * sl - alias of syslog (internal framework logging system) X::$app->log()
 **/
function sl($msg) {
    X::$app->log($msg);
}

/**
 * li - alias of X::$app->logger->info()
 **/
function li($msg) {
    X::$app->logger->info($msg);
}

/**
 * lie- alias of X::$app->logger->err()
 **/
function le($msg) {
    X::$app->logger->err($msg);
}

/**
 * d - alias of Dumper::dump()
 **/
function d($var) {
    echo \X\components\helpers\Dumper::dump($var);
}
