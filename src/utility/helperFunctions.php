<?php
use Silex\Application;

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

// function to open a database connection
function open_database_connection()
{
    //DB parameters
    $username = 'fred';
    $password = 'smith';
    $host = 'localhost';
    $db = 'kbk';

    // try to connect to the database
    $connection = mysqli_connect($host, $username, $password, $db);

    //will check if connection was successful or redirect to error page
    if (mysqli_connect_errno())
    {
        $_SESSION['errorCategory'] = 'Database';
        $_SESSION['errorMessage'] = 'DB connection failed: '.mysqli_connect_error();
        header('Location: /error');
        exit();
    }
    return $connection;
}

//function used for closing database connection
function close_database_connection($connection)
{
    if (isset($connection)) {
        mysqli_close($connection);
        unset($connection);
    }
}

//function used in user authentication
/**
 * @param Application $app
 * @return null or string username
 */
function getAuthenticatedUsername(Application $app)
{
    //if user found with non null value in session
    $user = $app['session']->get('user');

    if (null != $user) {
        // return username inside 'user' array
        return $user['username'];
    } else {
        //return null as there was no user logged in
        return null;
    }
}

// function that validates if username and password are valid and accepted
function isValidUsernamePassword($username, $password)
{
    $connection = open_database_connection();

    // run query

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";

    if ($result = mysqli_query($connection, $query))
    {
        $numRows = $result ->num_rows;
    }

    //closing database connection
    close_database_connection($connection);

    //return if we found a username password or not:
    if($numRows > 0)
    {
        return true;
    }

    else
    {
        return false;
    }
}