<?php
namespace CatalogBundle\Controller\Api\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserApiController extends Controller
{
    /**
     * @param $request
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route("/api/users", name="api_users")
     * @return Response
     */
    public function getUsersAction(Request $request)
    {
        //products?page=1&per_page=5&ordered_by=id&direction=1
        $page = $request->get('page') ? $request->get('page') : 1;
        $per_page = $request->get('per_page') ? $request->get('per_page') : 5;
        $ordered_by = $request->get('ordered_by') ? $request->get('ordered_by') : 'id';
        $direction = $request->get('direction') ? $request->get('direction') : 0;

        $result = $this
            ->get('app.user_serializer')
            ->serializeProducts(
                $page,
                $per_page,
                $ordered_by,
                $direction
            );

        return $result;
    }
}
