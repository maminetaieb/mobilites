<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Entity\YearDetail;
use App\Form\GradeType;
use App\Form\YearDetailType;
use App\Repository\GradeRepository;
use App\Repository\YearDetailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/grade')]
class GradeController extends AbstractController
{
    #[Route('/', name: 'app_grade_index', methods: ['GET'])]
    public function index(GradeRepository $gradeRepository): Response
    {
        return $this->render('grade/index.html.twig', [
            'grades' => $gradeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_grade_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GradeRepository $gradeRepository): Response
    {
        $grade = new Grade();
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $grade->setInstitution($this->getUser()->getInstitution());

            $gradeRepository->add($grade, true);

            return $this->redirectToRoute('app_grade_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('grade/new.html.twig', [
            'grade' => $grade,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_grade_show', methods: ['GET'])]
    public function show(Grade $grade): Response
    {
        return $this->render('grade/show.html.twig', [
            'grade' => $grade,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_grade_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Grade $grade, GradeRepository $gradeRepository): Response
    {
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gradeRepository->add($grade, true);

            return $this->redirectToRoute('app_grade_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('grade/edit.html.twig', [
            'grade' => $grade,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/year-detail/new', name: 'app_year_detail_new', methods: ['GET', 'POST'])]
    public function addYear(Grade $grade, Request $request, YearDetailRepository $yearDetailRepository): Response
    {
        $yearDetail = new YearDetail();
        $form = $this->createForm(YearDetailType::class, $yearDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $yearDetail->setStudent($this->getUser());
            $yearDetail->setGrade($grade);

            $yearDetailRepository->add($yearDetail, true);

            return $this->redirectToRoute('app_year_detail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('year_detail/new.html.twig', [
            'year_detail' => $yearDetail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_grade_delete', methods: ['POST'])]
    public function delete(Request $request, Grade $grade, GradeRepository $gradeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $grade->getId(), $request->request->get('_token'))) {
            $gradeRepository->remove($grade, true);
        }

        return $this->redirectToRoute('app_grade_index', [], Response::HTTP_SEE_OTHER);
    }
}
