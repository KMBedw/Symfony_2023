<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\Category;
use App\Form\TaskType;
use App\Repository\CategoryRepository;
use App\Repository\TaskRepository;
use App\Repository\TaskStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/task')]
#[IsGranted('IS_AUTHENTICATED')]
class TaskController extends AbstractController
{
    #[Route('/', name: 'app_task')]
    public function index(CategoryRepository $categoryRepository, Request $request): Response
    {

        $categories = $categoryRepository->findAll();

        $searchFormBuilder = $this->createFormBuilder();
        $searchFormBuilder->add('search', SearchType::class, [
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'recherche une tâche'
            ]
        ]);

        $form = $searchFormBuilder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();

            if ($search) {
                $categories = $categoryRepository->searchCategoriesByTaskName($search);
            }

        }


        return $this->render('task/index.html.twig', [
            'categories' => $categories,
            'form' => $form->createView()
        ]);
    }

    #[Route('/create/{id}', name: 'app_task_create')]
    public function create(Request $request, Category $category, TaskRepository $taskRepository, TaskStatusRepository $taskStatus): Response
    {
        $task = new Task;
        $task->setCategory($category);
        $form = $this->createForm(TaskType::class, $task);

        $form->remove('status');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère la catégorie de la tâche
            $taskStatusList = $taskStatus->findAll();
            $task->setStatus($taskStatusList[0]);

            // On définit l'utilisateur courant comme propriétaire de la tâche
            $task->setUser($this->getUser());
            // On persiste la tâche
            $taskRepository->save($task, true);
            $this->addFlash('success', 'Tâche ajoutée avec succès !');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_task_delete')]
    public function delete(Task $task, TaskRepository $taskRepository): Response
    {
        $taskRepository->remove($task, true);
        $this->addFlash('success', 'Tâche ajoutée avec succès !');

        return $this->redirectToRoute('app_home');
    }

    #[Route('/edit/{id}', name: 'app_task_edit')]
    public function update(Task $task, TaskRepository $taskRepository, Request $request): Response
    {

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskRepository->save($task, true);
            $this->addFlash('success', 'Tâche modifiée avec succès !');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}