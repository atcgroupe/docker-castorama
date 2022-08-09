<?php

namespace App\Controller\Admin;

use App\Entity\CustomOrderSign;
use App\Entity\Sign;
use App\Enum\CustomSignFileType;
use App\Form\CustomSignCreateType;
use App\Form\CustomSignUpdateType;
use App\Repository\SignRepository;
use App\Service\Alert\Alert;
use App\Service\Controller\AbstractAppController;
use App\Service\Sign\CustomSignFileManager;
use App\Service\Sign\CustomSignHelper;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/custom-signs', name: 'admin_custom_signs')]
class CustomSignController extends AbstractAppController
{
    private ObjectManager $manager;
    public function __construct(
        private readonly SignRepository        $signRepository,
        private readonly CustomSignFileManager $fileManager,
        private readonly CustomSignHelper      $signHelper,
        private readonly ManagerRegistry       $managerRegistry,
    ) {
        $this->manager = $this->managerRegistry->getManager();
    }

    #[Route('', name: '_list')]
    public function list(): Response
    {
        $signs = $this->signRepository->findBy(['class' => CustomOrderSign::class]);

        return $this->render('admin/custom_sign/list.html.twig', ['signs' => $signs]);
    }

    #[Route('/{id}/view', name: '_view')]
    public function view(int $id): Response
    {
        $sign = $this->signRepository->find($id);

        return $this->render(
            'admin/custom_sign/view.html.twig',
            [
                'sign' => $sign,
                'isRemovable' => $this->signHelper->isRemovable($sign)
            ]
        );
    }

    #[Route('/create', name: '_create')]
    public function create(Request $request): Response
    {
        $sign = new Sign(false);
        $sign->setClass(CustomOrderSign::class);
        $form = $this->createForm(CustomSignCreateType::class, $sign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $this->fileManager->saveAll($sign);

            if (!$result) {
                $this->dispatchAlert(
                    Alert::INFO,
                    'Une erreur est survenue lors de l\'enregistrement des fichiers. Merci de reessayer.'
                );
            }

            $this->manager->persist($sign);
            $this->manager->flush();

            $this->dispatchHtmlAlert(
                Alert::INFO,
                sprintf(
                    'Le panneau <b>%s</b> a été enregistré.',
                    $sign->getTitle()
                )
            );

            return $this->redirectToRoute('admin_custom_signs_list');
        }

        return $this->render(
            'admin/custom_sign/create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/{id}/update', name: '_update')]
    public function updateInfo(int $id, Request $request): Response
    {
        $sign = $this->signRepository->find($id);
        $oldSign = clone $sign;
        $form = $this->createForm(CustomSignUpdateType::class, $sign, ['validation_groups' => ['update_info']]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            # Rename file if sign name has changed
            if ($sign->getName() !== $oldSign->getName()) {
                $result = $this->fileManager->renameAll($oldSign, $sign);

                if (!$result) {
                    $this->dispatchAlert(Alert::DANGER, 'Un problème est survenu lors du renommage, merci de re-essayer');

                    return $this->redirectToRoute('admin_custom_signs_view', ['id' => $id]);
                }
            }

            $this->manager->flush();
            $this->dispatchAlert(Alert::INFO, 'Les informations ont été mises à jour.');

            return $this->redirectToRoute('admin_custom_signs_view', ['id' => $id]);
        }

        return $this->render(
            'admin/custom_sign/update.html.twig',
            [
                'sign' => $sign,
                'form' => $form->createView(),
                'title' => 'Modification du panneau',
            ]
        );
    }

    #[Route('/{id}/update-image/{type}', name: '_update_image')]
    public function updateImage(int $id, string $type, Request $request): Response
    {
        $type = CustomSignFileType::from($type);
        $sign = $this->signRepository->find($id);
        #The CustomSignUpdateType is customized with the type of the image (choose|preview|production)
        $form = $this->createForm(
            CustomSignUpdateType::class,
            $sign,
            [
                CustomSignUpdateType::UPDATE_TYPE => $type,
                'validation_groups' => [$type->getName()]
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $this->fileManager->save($sign, $type);

            $result ?
                $this->dispatchAlert(Alert::SUCCESS, 'l\'image a été mise à jour.') :
                $this->dispatchAlert(Alert::DANGER, 'Un problème est survenu lors de l\'enregistrement.');

            return $this->redirectToRoute('admin_custom_signs_view', ['id' => $id]);
        }

        return $this->render(
            'admin/custom_sign/update.html.twig',
            [
                'sign' => $sign,
                'form' => $form->createView(),
                'title' => 'Modification d\'une image pour le panneau',
            ]
        );
    }

    #[Route('/{id}/change-status', name: '_change_status')]
    public function changeStatus(int $id): RedirectResponse
    {
        $sign = $this->signRepository->find($id);
        $sign->setIsActive(!$sign->getIsActive());

        $this->manager->flush();

        return $this->redirectToRoute('admin_custom_signs_view', ['id' => $sign->getId()]);
    }

    #[Route('/{id}/delete', name: '_delete')]
    public function delete(int $id, Request $request): Response
    {
        $sign = $this->signRepository->find($id);
        # If a custom Sign is used in a order, it cant be removed.
        if (!$this->signHelper->isRemovable($sign)) {
            $this->dispatchHtmlAlert(
                Alert::DANGER,
                'Impossible de supprimer ce panneau. Il est utilisé dans une commande.<br>'
                . 'dans ce cas, le panneau ne sera plus selectionnable pour les prochaines commandes'
            );

            return $this->redirectToRoute('admin_custom_signs_view', ['id' => $id]);
        }

        if ($request->isMethod('POST')) {
            $this->fileManager->removeAll($sign);
            $this->manager->remove($sign);
            $this->manager->flush();

            $this->dispatchAlert(Alert::SUCCESS, 'Le panneau a été supprimé');

            return $this->redirectToRoute('admin_custom_signs_list');
        }

        return $this->render(
            'admin/custom_sign/delete.html.twig',
            [
                'sign' => $sign
            ]
        );
    }
}
