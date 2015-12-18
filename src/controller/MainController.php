<?php
namespace KBK\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use KBK\Model\MenuCategoryRepository;

class MainController
{
    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    //action for route:     /
    public function indexAction(Request $request, Application $app)
    {
        // build args array
        $argsArray = array(
            'title' => "Kevin's Vegeburger Kitchen",
        );

        //render template
        $templateName = 'index';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    //action for route:     /about
    public function aboutAction(Request $request, Application $app)
    {
        // build arrgs array
        $argsArray = array(
            'title' => 'About us',
            'content'=> 'About us - we`re a great food company'
        );

        //render template
        $templateName = 'about';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    //action for route:     /menu
    public function menuAction(Request $request, Application $app)
    {
        // get reference to our Menu category repository
        $menuCategoryRepository = new MenuCategoryRepository();

        // build arrgs array
        $argsArray = array(
            'categories' => $menuCategoryRepository->getAllMenuCategories()
        );

        //render template
        $templateName = 'menu';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    //action for route:     /contact
    public function contactAction(Request $request, Application $app)
    {
        // build arrgs array
        $argsArray = array(
            'title' => 'Contact Details',
            'content'=> 'These are our contact details: ...'
        );

        //render template
        $templateName = 'contact';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}