<?php

namespace App\Controller;

use App\Entity\YearDetail;
use App\Form\YearDetailType;
use App\Repository\YearDetailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/year/detail')]
class YearDetailController extends AbstractController
{
    #[Route('/', name: 'app_year_detail_index', methods: ['GET'])]
    public function index(YearDetailRepository $yearDetailRepository): Response
    {
        return $this->render('year_detail/index.html.twig', [
            'year_details' => $yearDetailRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_year_detail_new', methods: ['GET', 'POST'])]
    public function new(Request $request, YearDetailRepository $yearDetailRepository): Response
    {
        $yearDetail = new YearDetail();
        $form = $this->createForm(YearDetailType::class, $yearDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $yearDetailRepository->add($yearDetail, true);

            return $this->redirectToRoute('app_year_detail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('year_detail/new.html.twig', [
            'year_detail' => $yearDetail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_year_detail_show', methods: ['GET'])]
    public function show(YearDetail $yearDetail): Response
    {
        return $this->render('year_detail/show.html.twig', [
            'year_detail' => $yearDetail,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_year_detail_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, YearDetail $yearDetail, YearDetailRepository $yearDetailRepository): Response
    {
        $form = $this->createForm(YearDetailType::class, $yearDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $yearDetailRepository->add($yearDetail, true);

            return $this->redirectToRoute('app_year_detail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('year_detail/edit.html.twig', [
            'year_detail' => $yearDetail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_year_detail_delete', methods: ['POST'])]
    public function delete(Request $request, YearDetail $yearDetail, YearDetailRepository $yearDetailRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$yearDetail->getId(), $request->request->get('_token'))) {
            $yearDetailRepository->remove($yearDetail, true);
        }

        return $this->redirectToRoute('app_year_detail_index', [], Response::HTTP_SEE_OTHER);
    }
}
