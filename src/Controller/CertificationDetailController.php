<?php

namespace App\Controller;

use App\Entity\CertificationDetail;
use App\Form\CertificationDetailType;
use App\Repository\CertificationDetailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/certification/detail')]
class CertificationDetailController extends AbstractController
{
    #[Route('/', name: 'app_certification_detail_index', methods: ['GET'])]
    public function index(CertificationDetailRepository $certificationDetailRepository): Response
    {
        return $this->render('certification_detail/index.html.twig', [
            'certification_details' => $certificationDetailRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_certification_detail_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CertificationDetailRepository $certificationDetailRepository): Response
    {
        $certificationDetail = new CertificationDetail();
        $form = $this->createForm(CertificationDetailType::class, $certificationDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $certificationDetailRepository->add($certificationDetail, true);

            return $this->redirectToRoute('app_certification_detail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('certification_detail/new.html.twig', [
            'certification_detail' => $certificationDetail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_certification_detail_show', methods: ['GET'])]
    public function show(CertificationDetail $certificationDetail): Response
    {
        return $this->render('certification_detail/show.html.twig', [
            'certification_detail' => $certificationDetail,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_certification_detail_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CertificationDetail $certificationDetail, CertificationDetailRepository $certificationDetailRepository): Response
    {
        $form = $this->createForm(CertificationDetailType::class, $certificationDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $certificationDetailRepository->add($certificationDetail, true);

            return $this->redirectToRoute('app_certification_detail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('certification_detail/edit.html.twig', [
            'certification_detail' => $certificationDetail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_certification_detail_delete', methods: ['POST'])]
    public function delete(Request $request, CertificationDetail $certificationDetail, CertificationDetailRepository $certificationDetailRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$certificationDetail->getId(), $request->request->get('_token'))) {
            $certificationDetailRepository->remove($certificationDetail, true);
        }

        return $this->redirectToRoute('app_certification_detail_index', [], Response::HTTP_SEE_OTHER);
    }
}
