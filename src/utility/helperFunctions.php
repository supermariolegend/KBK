<?php

/**
 * add namespace to the string, after exploding controller name from action
 *
 * examples:
 * input:   KBK, main/index
 * output:  KBK\MainController::indexAction
 *
 * @param $namespace
 * @param $shortName controller and action name separated by "/"
 * @return string namespace, controller class name plus :: plus action name
 */

function controller($namespace, $shortName)
{
    list($shortClass, $shortMethod) = explode('/', $shortName, 2);

    $shortClassCapitalise = ucfirst($shortClass);

    $namespaceClassAction = sprintf($namespace . '\\' . $shortClassCapitalise . 'Controller::' . $shortMethod . 'Action');

    return $namespaceClassAction;
}

