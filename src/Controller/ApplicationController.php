<?php

namespace App\Controller;

use App\Entity\Application;
use App\Repository\ApplicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/application')]
class ApplicationController extends AbstractController
{
    #[Route('/', name: 'app_application_index', methods: ['GET'])]
    public function index(ApplicationRepository $applicationRepository): Response
    {
        return $this->render('application/index.html.twig', [
            'applications' => $applicationRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_application_show', methods: ['GET'])]
    public function show(Application $application): Response
    {
        return $this->render('application/show.html.twig', [
            'application' => $application,
        ]);
    }

    #[Route('/{id}/edit-status/{r}', name: 'app_application_edit_status', methods: ['GET', 'POST'])]
    public function editStatus(Request $request, Application $application, ApplicationRepository $applicationRepository): Response
    {
        $application->setStatus($request->get('r') != 0);
        $applicationRepository->add($application, true);

        return $this->redirectToRoute('app_mobility_show', ['id' => $application->getMobility()->getId()]);
    }

    #[Route('/{id}/edit-verified/{r}', name: 'app_application_edit_verified', methods: ['GET', 'POST'])]
    public function editVerified(Request $request, Application $application, ApplicationRepository $applicationRepository): Response
    {
        $application->setVerified($request->get('r') != 0);
        $applicationRepository->add($application, true);

        return $this->redirectToRoute('app_grade_edit', ['id' => $application->getSourceGrade()->getId()]);
    }

    #[Route('/{id}', name: 'app_application_delete', methods: ['POST'])]
    public function delete(Request $request, Application $application, ApplicationRepository $applicationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $application->getId(), $request->request->get('_token'))) {
            $applicationRepository->remove($application, true);
        }

        return $this->redirectToRoute('app_mobility_show', ['id' => $application->getMobility()->getId()], Response::HTTP_SEE_OTHER);
    }
}
