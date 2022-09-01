<?php

namespace App\Controller;

use App\Entity\Mobility;
use App\Entity\Application;
use App\Form\MobilityType;
use App\Form\ApplicationType;
use App\Repository\MobilityRepository;
use App\Repository\ApplicationRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mobility')]
class MobilityController extends AbstractController
{
    #[Route('/', name: 'app_mobility_index', methods: ['GET'])]
    public function index(MobilityRepository $mobilityRepository): Response
    {
        $suggestedMobilityCriteria = new Criteria();
        $suggestedMobilityExpressionBuilder = Criteria::expr();

        $suggestedMobilityCriteria->where(
            $suggestedMobilityExpressionBuilder->gte('startDate', new \DateTime('now')),
        )->orderBy([
            'startDate' => 'ASC',
        ]);


        return $this->render('mobility/index.html.twig', [
            'mobilities' => $mobilityRepository->matching($suggestedMobilityCriteria),
        ]);
    }

    #[Route('/new', name: 'app_mobility_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MobilityRepository $mobilityRepository): Response
    {
        $mobility = new Mobility();
        $form = $this->createForm(MobilityType::class, $mobility);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mobility->setInstitution($this->getUser()->getInstitution());
            $mobilityRepository->add($mobility, true);

            return $this->redirectToRoute('app_mobility_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mobility/new.html.twig', [
            'mobility' => $mobility,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mobility_show', methods: ['GET'])]
    public function show(Mobility $mobility): Response
    {
        return $this->render('mobility/show.html.twig', [
            'mobility' => $mobility,
            'currdate' => new \DateTime('now'),
        ]);
    }

    #[Route('/{id}/application/new', name: 'app_application_new', methods: ['GET', 'POST'])]
    public function apply(Mobility $mobility, Request $request, ApplicationRepository $applicationRepository): Response
    {
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $application->setApplicant($this->getUser());
            $application->setApplicationDate(new \DateTime('now'));
            $mobility->addApplication($application);

            $applicationRepository->add($application, true);

            return $this->redirectToRoute('app_mobility_show', ['id' => $mobility->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('application/new.html.twig', [
            'application' => $application,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mobility_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mobility $mobility, MobilityRepository $mobilityRepository): Response
    {
        $form = $this->createForm(MobilityType::class, $mobility);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mobilityRepository->add($mobility, true);

            return $this->redirectToRoute('app_mobility_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mobility/edit.html.twig', [
            'mobility' => $mobility,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mobility_delete', methods: ['POST'])]
    public function delete(Request $request, Mobility $mobility, MobilityRepository $mobilityRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $mobility->getId(), $request->request->get('_token'))) {
            $mobilityRepository->remove($mobility, true);
        }

        return $this->redirectToRoute('app_mobility_index', [], Response::HTTP_SEE_OTHER);
    }
}
