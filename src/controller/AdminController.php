<?php


namespace KBK\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminController
 * authentication class
 * @package KBK\Controller
 */
class AdminController
{
    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    // action for route:    /admin
    public function indexAction(Request $request, Application $app)
    {
        //check if username is stored in session
        $username = getAuthenticatedUserName($app);

        //check if we are authenticated
        $isAuthenticated = (null != $username);
        if(!$isAuthenticated){
            //not authenticated, so redirecting to login page
            return $app->redirect('/login');
        }

        //store username into argsArray
        $argsArray = array(
            'username' => $username,
            'title' => 'Admin'
        );

        //render template
        $templateName = 'admin/index';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    // action for route:    /adminCodes
    // will we allow access to the Admin home?
    public function codesAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if(!$isAuthenticated){
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        // store username into args array
        $argsArray = array(
            'username' => $username
        );

        // render (draw) template
        // ------------
        $templateName = 'admin/codes';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    // action for route:    /about
    // will we allow access to the Admin home?
    public function aboutAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if(!$isAuthenticated){
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        // store username into args array
        $argsArray = array(
            'username' => $username
        );

        // render (draw) template
        // ------------
        $templateName = 'admin/about';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}