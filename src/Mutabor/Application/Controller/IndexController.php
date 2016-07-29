<?php


namespace Mutabor\Application\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class IndexController extends Controller
{
    /**
     * @Security("has_role('IS_AUTHENTICATED_FULLY')")
     * @return Response
     */
    public function indexAction()
    {
        return new Response('<html><body></body></html>');
    }
}