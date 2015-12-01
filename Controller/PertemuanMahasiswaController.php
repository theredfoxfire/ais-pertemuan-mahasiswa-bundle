<?php

namespace Ais\PertemuanMahasiswaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;

use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Ais\PertemuanMahasiswaBundle\Exception\InvalidFormException;
use Ais\PertemuanMahasiswaBundle\Form\PertemuanMahasiswaType;
use Ais\PertemuanMahasiswaBundle\Model\PertemuanMahasiswaInterface;


class PertemuanMahasiswaController extends FOSRestController
{
    /**
     * List all pertemuan_mahasiswas.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing pertemuan_mahasiswas.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many pertemuan_mahasiswas to return.")
     *
     * @Annotations\View(
     *  templateVar="pertemuan_mahasiswas"
     * )
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getPertemuanMahasiswasAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');

        return $this->container->get('ais_pertemuan_mahasiswa.pertemuan_mahasiswa.handler')->all($limit, $offset);
    }

    /**
     * Get single PertemuanMahasiswa.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a PertemuanMahasiswa for a given id",
     *   output = "Ais\PertemuanMahasiswaBundle\Entity\PertemuanMahasiswa",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the pertemuan_mahasiswa is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="pertemuan_mahasiswa")
     *
     * @param int     $id      the pertemuan_mahasiswa id
     *
     * @return array
     *
     * @throws NotFoundHttpException when pertemuan_mahasiswa not exist
     */
    public function getPertemuanMahasiswaAction($id)
    {
        $pertemuan_mahasiswa = $this->getOr404($id);

        return $pertemuan_mahasiswa;
    }

    /**
     * Presents the form to use to create a new pertemuan_mahasiswa.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  templateVar = "form"
     * )
     *
     * @return FormTypeInterface
     */
    public function newPertemuanMahasiswaAction()
    {
        return $this->createForm(new PertemuanMahasiswaType());
    }
    
    /**
     * Presents the form to use to edit pertemuan_mahasiswa.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisPertemuanMahasiswaBundle:PertemuanMahasiswa:editPertemuanMahasiswa.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the pertemuan_mahasiswa id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when pertemuan_mahasiswa not exist
     */
    public function editPertemuanMahasiswaAction($id)
    {
		$pertemuan_mahasiswa = $this->getPertemuanMahasiswaAction($id);
		
        return array('form' => $this->createForm(new PertemuanMahasiswaType(), $pertemuan_mahasiswa), 'pertemuan_mahasiswa' => $pertemuan_mahasiswa);
    }

    /**
     * Create a PertemuanMahasiswa from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new pertemuan_mahasiswa from the submitted data.",
     *   input = "Ais\PertemuanMahasiswaBundle\Form\PertemuanMahasiswaType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisPertemuanMahasiswaBundle:PertemuanMahasiswa:newPertemuanMahasiswa.html.twig",
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postPertemuanMahasiswaAction(Request $request)
    {
        try {
            $newPertemuanMahasiswa = $this->container->get('ais_pertemuan_mahasiswa.pertemuan_mahasiswa.handler')->post(
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $newPertemuanMahasiswa->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_pertemuan_mahasiswa', $routeOptions, Codes::HTTP_CREATED);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing pertemuan_mahasiswa from the submitted data or create a new pertemuan_mahasiswa at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Ais\PertemuanMahasiswaBundle\Form\PertemuanMahasiswaType",
     *   statusCodes = {
     *     201 = "Returned when the PertemuanMahasiswa is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisPertemuanMahasiswaBundle:PertemuanMahasiswa:editPertemuanMahasiswa.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the pertemuan_mahasiswa id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when pertemuan_mahasiswa not exist
     */
    public function putPertemuanMahasiswaAction(Request $request, $id)
    {
        try {
            if (!($pertemuan_mahasiswa = $this->container->get('ais_pertemuan_mahasiswa.pertemuan_mahasiswa.handler')->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $pertemuan_mahasiswa = $this->container->get('ais_pertemuan_mahasiswa.pertemuan_mahasiswa.handler')->post(
                    $request->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $pertemuan_mahasiswa = $this->container->get('ais_pertemuan_mahasiswa.pertemuan_mahasiswa.handler')->put(
                    $pertemuan_mahasiswa,
                    $request->request->all()
                );
            }

            $routeOptions = array(
                'id' => $pertemuan_mahasiswa->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_pertemuan_mahasiswa', $routeOptions, $statusCode);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing pertemuan_mahasiswa from the submitted data or create a new pertemuan_mahasiswa at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Ais\PertemuanMahasiswaBundle\Form\PertemuanMahasiswaType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisPertemuanMahasiswaBundle:PertemuanMahasiswa:editPertemuanMahasiswa.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the pertemuan_mahasiswa id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when pertemuan_mahasiswa not exist
     */
    public function patchPertemuanMahasiswaAction(Request $request, $id)
    {
        try {
            $pertemuan_mahasiswa = $this->container->get('ais_pertemuan_mahasiswa.pertemuan_mahasiswa.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $pertemuan_mahasiswa->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_pertemuan_mahasiswa', $routeOptions, Codes::HTTP_NO_CONTENT);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Fetch a PertemuanMahasiswa or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return PertemuanMahasiswaInterface
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id)
    {
        if (!($pertemuan_mahasiswa = $this->container->get('ais_pertemuan_mahasiswa.pertemuan_mahasiswa.handler')->get($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        return $pertemuan_mahasiswa;
    }
    
    public function postUpdatePertemuanMahasiswaAction(Request $request, $id)
    {
		try {
            $pertemuan_mahasiswa = $this->container->get('ais_pertemuan_mahasiswa.pertemuan_mahasiswa.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $pertemuan_mahasiswa->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_pertemuan_mahasiswa', $routeOptions, Codes::HTTP_NO_CONTENT);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
	}
}
