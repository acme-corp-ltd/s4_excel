<?php

namespace App\Controller;

use App\Utils\DataExtractorInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ExcelController extends AbstractFOSRestController
{
    /**
     * @Route("/extract", name="extract", methods={"post"})
     * @param Request $request
     * @param DataExtractorInterface $extractor
     * @return View
     */
    public function extract(Request $request, DataExtractorInterface $extractor)
    {
        if($request->files->count() !== 1) {
            throw new BadRequestHttpException('file missing');
        }
        /** @var UploadedFile $file */
        $file = array_values($request->files->all())[0];
        $path = $file->getRealPath();

        $data = $extractor->extract($path);

        return $this->view($data, 200)
            ->setTemplate('excel/index.html.twig')
            ->setTemplateVar('data');
    }

    /**
     * @Route("/form", name="form")
     * @return Response
     */
    public function form(): Response {
        return $this->render('excel/form.html.twig');
    }
}
