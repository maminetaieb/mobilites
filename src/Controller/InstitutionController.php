<?php

namespace App\Controller;

use App\Entity\Institution;
use App\Form\InstitutionType;
use App\Repository\InstitutionRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/institution')]
class InstitutionController extends AbstractController
{
    #[Route('/', name: 'app_institution_index', methods: ['GET'])]
    public function index(InstitutionRepository $institutionRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $donnees = $institutionRepository->findBy([],['name' => 'desc']);
        $institutions = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            2 // Nombre de résultats par page
        );
        return $this->render('institution/index.html.twig', [
            'institutions' => $institutions
        ]);
    }

    #[Route('/new', name: 'app_institution_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InstitutionRepository $institutionRepository): Response
    {
        $institution = new Institution();
        $institution->addManager($this->getUser());
        $form = $this->createForm(InstitutionType::class, $institution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $institutionRepository->add($institution, true);

            return $this->redirectToRoute('app_institution_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('institution/new.html.twig', [
            'institution' => $institution,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_institution_show', methods: ['GET'])]
    public function show(Institution $institution): Response
    {
        return $this->render('institution/show.html.twig', [
            'institution' => $institution,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_institution_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Institution $institution, InstitutionRepository $institutionRepository, UserRepository $userRepository): Response
    {
        $form = $this->createForm(InstitutionType::class, $institution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $institutionRepository->add($institution, true);

            return $this->redirectToRoute('app_institution_index', [], Response::HTTP_SEE_OTHER);
        }

        $criteria = new Criteria();
        $expressionBuilder = Criteria::expr();

        $criteria
            ->where($expressionBuilder->orX(
                $expressionBuilder->isNull('institution'),
                $expressionBuilder->eq('institution', $institution)
            ))
            ->orderBy([
                'institution' => 'DESC'
            ]);

        return $this->renderForm('institution/edit.html.twig', [
            'institution' => $institution,
            'users' => $userRepository->matching($criteria),
            'form' => $form,
        ]);
    }

    #[Route('/{id}/add-manager/{mid}', name: 'app_institution_edit_managers_add', methods: ['GET', 'POST'])]
    public function addManager(Request $request, EntityManagerInterface $entityManager, Institution $institution, UserRepository $userRepository): Response
    {
        $newManager = $userRepository->find(($request->get('mid')));
        $institution->addManager($newManager);

        $entityManager->flush($newManager);
        $entityManager->flush($institution);


        return $this->redirectToRoute('app_institution_edit', ['id' => $institution->getId()]);
    }

    #[Route('/{id}/remove-manager/{mid}', name: 'app_institution_edit_managers_remove', methods: ['GET', 'POST'])]
    public function removeManager(Request $request, EntityManagerInterface $entityManager, Institution $institution, UserRepository $userRepository): Response
    {
        $oldManager = $userRepository->find(($request->get('mid')));
        $institution->removeManager($oldManager);

        $entityManager->flush($oldManager);
        $entityManager->flush($institution);

        if ($this->getUser() == $oldManager) {
            return $this->redirectToRoute('app_institution_show', ['id' => $institution->getId()]);
        }

        return $this->redirectToRoute('app_institution_edit', ['id' => $institution->getId()]);
    }

    #[Route('/{id}', name: 'app_institution_delete', methods: ['POST'])]
    public function delete(Request $request, Institution $institution, InstitutionRepository $institutionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $institution->getId(), $request->request->get('_token'))) {
            $institutionRepository->remove($institution, true);
        }

        return $this->redirectToRoute('app_institution_index', [], Response::HTTP_SEE_OTHER);
    }
}
