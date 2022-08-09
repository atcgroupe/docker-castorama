<?php

namespace App\Controller\Admin;

use App\Entity\Shop;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\UserPasswordManager;
use App\Service\Alert\Alert;
use App\Service\Controller\AbstractAppController;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/shops', name: 'admin_shop')]
class UserShopController extends AbstractAppController
{
    /**
     * @var ObjectManager
     */
    private ObjectManager $manager;

    public function __construct(
        private readonly UserPasswordManager $userPasswordManager,
        ManagerRegistry $doctrine
    ) {
        $this->manager = $doctrine->getManager();
    }

    #[Route('/list', name: '_list')]
    public function list(UserRepository $userRepository): Response
    {
        $shops = $userRepository->findShopsUsers();

        return $this->render('admin/user_shop/shop_list.html.twig', ['shops' => $shops]);
    }

    #[Route('/{id}/switch', name: '_switch')]
    public function switchIsActive(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        $user->setIsActive(!$user->getIsActive());
        $this->manager->flush();

        $isActive = ($user->getIsActive()) ? 'réactivé' : 'désactivé';

        $this->dispatchHtmlAlert(
            Alert::INFO,
            sprintf('Le magasin de <b>%s</b> a été %s', $user->getShop()->getName(), $isActive)
        );

        return $this->redirectToRoute('admin_shop_list');
    }

    #[Route('/create', name: '_create')]
    public function create(Request $request): Response
    {
        $user = new User();
        $user->setShop(new Shop());

        $form = $this->createForm(UserType::class, $user, ['validation_groups' => ['Default', 'registration']]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userPasswordManager->setPassword($user);
            $user->setRoles([User::ROLE_CUSTOMER_SHOP]);
            $user->setIsActive(true);

            $this->manager->persist($user);
            $this->manager->flush();

            $this->dispatchHtmlAlert(
                Alert::INFO,
                sprintf('Le magasin <b>%s</b> a été créé avec succès', $user->getShop()->getName())
            );

            return $this->redirectToRoute('admin_shop_list');
        }

        return $this->render(
            'admin/user_shop/shop_edit.html.twig',
            [
                'action' => 'create',
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/{id}/update', name: '_update')]
    public function update(int $id, Request $request): Response
    {
        $user = $this->manager->getRepository(User::class)->findWithShop($id);

        $form = $this->createForm(UserType::class, $user, ['validation_groups' => ['Default']]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userPasswordManager->setPassword($user);

            $this->manager->flush();

            $this->dispatchHtmlAlert(
                Alert::INFO,
                sprintf(
                    'Les informations du magasin <b>%s</b> ont été mises à jour avec succès.',
                    $user->getShop()->getName()
                )
            );

            return $this->redirectToRoute('admin_shop_list');
        }

        return $this->render(
            'admin/user_shop/shop_edit.html.twig',
            [
                'action' => 'update',
                'form' => $form->createView(),
                'shopName' => $user->getShop()->getName(),
            ]
        );
    }
}
