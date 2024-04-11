<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/create', name: 'app_user_create')]
    public function create(Request $request, UserPasswordHasherInterface $hasher, UserRepository $userRepository): Response
    {
        $user = new User;

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwordHash = $hasher->hashPassword($user, $user->getPassword());

            $user->setPassword($passwordHash);

            $userRepository->save($user, true);

            $this->addFlash('success', 'Inscription réalisée avec succès !');

            return $this->redirectToRoute('app_login');

        }

        return $this->render('user/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profile', name: 'app_user_profile')]
    #[IsGranted('IS_AUTHENTICATED')]
    public function profile(Request $request, UserRepository $userRepository)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);

        $form->remove('password');
        $form->remove('email');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            $this->addFlash('success', 'Profil mis à jour avec succès!');
        }


        return $this->render('user/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }
}