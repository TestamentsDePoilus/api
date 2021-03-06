<?php

namespace UserBundle\Controller;

use JMS\Serializer\SerializationContext;
use UserBundle\Entity\Access;

use UserBundle\Form\AccessType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Nelmio\ApiDocBundle\Annotation as Doc;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use UserBundle\Repository\UserRepository;

class AccessController extends FOSRestController
{
    /**
     * @Rest\Get("/accesses")
     * @QueryParam(name="user", nullable=true, description="User is required")
     *
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     *
     * @Doc\ApiDoc(
     *     section="Accesses",
     *     resource=true,
     *     description="Get the list of all accesses",
     *     statusCodes={
     *         200="Returned when fetched",
     *         400="Returned when a violation is raised by validation"
     *     }
     * )
     */
    public function getAccessesAction(Request $request, ParamFetcher $paramFetcher)
    {
        $user = $paramFetcher->get('user');

        $repository = $this->getDoctrine()->getManager()->getRepository('UserBundle:Access');
        /* @var $repository UserRepository */
        if($user != "") {
            $access = $repository->findOneBy(array("user" => $user));
            /* @var $access Access */
        } else {
            if($this->get('security.authorization_checker')->isGranted('ROLE_MODO')) {
                $access = $repository->findAll();
                /* @var $access Access[] */
            } else {
                throw $this->createAccessDeniedException('Unable to access this page!');
            }
        }
        return new JsonResponse(json_decode($this->get('jms_serializer')->serialize($access, 'json', SerializationContext::create()->enableMaxDepthChecks()->setGroups(['id','accessProperties']))));
    }

    /**
     * @Rest\Get("/accesses/{id}")
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     * @Doc\ApiDoc(
     *     section="Accesses",
     *     resource=true,
     *     description="Return one access",
     *     requirements={
     *         {
     *             "name"="id",
     *             "dataType"="integer",
     *             "requirement"="\d+",
     *             "description"="The access unique identifier.",
     *         }
     *     },
     *     statusCodes={
     *         200="Returned when fetched",
     *         400="Returned when a violation is raised by validation"
     *     }
     * )
     */
    public function getAccessAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $access = $em->getRepository('UserBundle:Access')->find($request->get('id'));
        /* @var $access Access */

        if (empty($access)) {
            return new JsonResponse(['message' => 'Access not found'], Response::HTTP_NOT_FOUND);
        }

        /*if(!$this->get('security.authorization_checker')->isGranted('ROLE_MODO') and $this->get('security.token_storage')->getToken()->getUser() != $access->getUser()) {
            throw $this->createAccessDeniedException('Unable to access this page!');
        }*/

        return new JsonResponse(json_decode($this->get('jms_serializer')->serialize($access, 'json', SerializationContext::create()->enableMaxDepthChecks()->setGroups(['id','accessProperties']))));
    }

    /**
     * @Rest\Post("/accesses")
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerEnableMaxDepthChecks=true)
     *
     * @Doc\ApiDoc(
     *     section="Accesses",
     *     resource=true,
     *     description="Create a new access",
     *     statusCodes={
     *         201="Returned when created",
     *         400="Returned when a violation is raised by validation"
     *     }
     * )
     */
    public function postAccessesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $access = new Access();
        $form = $this->createForm(AccessType::class, $access);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em->persist($access);
            $em->flush();
            return $access;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     * @Rest\Put("/accesses/{id}")
     * @Doc\ApiDoc(
     *     section="Accesses",
     *     resource=true,
     *     description="Update an existing access",
     *     statusCodes={
     *         200="Returned when updated",
     *         400="Returned when a violation is raised by validation"
     *     }
     * )
     */
    public function updateAccessAction(Request $request)
    {
        return $this->updateAccess($request, true);
    }

    /**
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     * @Rest\Patch("/accesses/{id}")
     * @Doc\ApiDoc(
     *     section="Accesses",
     *     resource=true,
     *     description="Update an existing access",
     *     statusCodes={
     *         200="Returned when updated",
     *         400="Returned when a violation is raised by validation"
     *     }
     * )
     */
    public function patchAccessAction(Request $request)
    {
        return $this->updateAccess($request, false);
    }

    private function updateAccess(Request $request, $clearMissing)
    {
        $isRequestValidation = false;
        $em = $this->getDoctrine()->getManager();
        $access = $em->getRepository('UserBundle:Access')->find($request->get('id'));
        /* @var $access Access */
        if (empty($access)) {
            return new JsonResponse(['message' => 'Access not found'], Response::HTTP_NOT_FOUND);
        }
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_MODO') and $this->get('security.token_storage')->getToken()->getUser() != $access->getUser()) {
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        if($access->getTaxonomyRequest() != null and $access->getIsTaxonomyAccess() == false) {
            $isRequestValidation = true;
        }

        $form = $this->createForm(AccessType::class, $access);
        $form->submit($request->request->all(), $clearMissing);
        if ($form->isValid()) {
            $em->merge($access);
            $em->flush();

            if($isRequestValidation == false and $access->getTaxonomyRequest() == null and $access->getIsTaxonomyAccess() == false) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Information concernant votre compte - Testaments de Poilus')
                    ->setFrom('testaments-de-poilus@huma-num.fr')
                    ->setTo($access->getUser()->getEmail())
                    ->setBody($this->renderView(
                        'UserBundle:SetRole:emailNoPromote.html.twig',
                        array('user' => $access->getUser())));
                $this->get('mailer')->send($message);
            }

            return $access;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\Delete("/accesses/{id}")
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Doc\ApiDoc(
     *     section="Accesses",
     *     resource=true,
     *     description="Remove a access",
     *     requirements={
     *         {
     *             "name"="id",
     *             "dataType"="integer",
     *             "requirement"="\d+",
     *             "description"="The access unique identifier.",
     *         }
     *     },
     *     statusCodes={
     *         204="Returned when deleted",
     *         400="Returned when a violation is raised by validation"
     *     }
     * )
     */
    public function removeAccessAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $access = $em->getRepository('UserBundle:Access')->find($request->get('id'));
        /* @var $access Access */
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_MODO') and $this->get('security.token_storage')->getToken()->getUser() != $access->getUser()) {
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        if ($access) {
            $em->remove($access);
            $em->flush();
        }
    }
}
