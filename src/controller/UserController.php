<?php

/**
 * User controller for Silex
 * This controller processes the user logging in and out of the website
 *
 * @package KBK\Controller
 */
namespace KBK\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @package KBK\Controller
 */
class UserController
{
    /**
     * Function for handling the user logging in to the website.
     * Action for POST route: /processLogin
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function processLoginAction(Request $request, Application $app)
    {
        //retrieve username from GET parameters in Request object
        $username = $request->get('username');
        $password = $request->get('password');

        //authenticate
        if (isValidUsernamePassword($username, $password)) {
            //store username in 'user' array in session
            $app['session']->set('user', array('username' => $username) );

            //if successful then redirect to secure admin home page
            return $app->redirect('/admin');
        }

        //login page and error message
        $templateName = 'login';
        $argsArray = array(
            'errorMessage' => 'bad username or password - please re-enter'
        );

        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Function for handling session data for the user logging in.
     *
     * Action for route: /login
     *
     * @param Request $request
     * @param Application $app
     */
    public function loginAction(Request $request, Application $app)
    {
        //logout any existing user
        $app['session']->set('user', null);

        //build argsArray
        $argsArray = [];

        //render template
        $templateName = 'login';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Function for handling session data for the user logging out.
     *
     * Action for route: /logout
     *
     * @param Request $request
     * @param Application $app
     */
    public function logoutAction(Request $request, Application $app)
    {
        //logout any existing user
        $app['session']->set('user', null);

        //redirect to home page
       // return $app->redirect('/');

        //render template
        $templateName = 'index';
        return $app['twig']->render($templateName . '.html.twig', []);
    }
}