<?php


namespace Mutabor\Application\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ReferenceController extends RestController
{
    /**
     * @ApiDoc(
     *     resource = true,
     *     description = "Reference",
     *     views = { "rest" },
     *     statusCodes = {
     *         200 = "Result",
     *         500 = "Server fatal error",
     *     },
     *     responseMap = {
     *         500 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error500" },
     *         },
     *     }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getReferenceAction()
    {
        $rooms = $this->get('domain.room_repository')->all();
        $design_styles = $this->get('domain.designstyle_repository')->all();

        $view = $this->view([
            'rooms' => $rooms,
            'designStyles' => $design_styles
        ], 200);
        return $this->handleView($view);
    }
}