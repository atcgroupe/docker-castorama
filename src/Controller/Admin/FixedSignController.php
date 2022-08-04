<?php

namespace App\Controller\Admin;

use App\Entity\FixedSign;
use App\Enum\FixedSignFileType;
use App\Form\FixedSignCreateType;
use App\Form\FixedSignUpdateType;
use App\Repository\FixedOrderSignRepository;
use App\Repository\FixedSignRepository;
use App\Service\Alert\Alert;
use App\Service\Controller\AbstractAppController;
use App\Service\Sign\FixedSignFileManager;
use App\Service\Sign\FixedSignHelper;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/fixed-signs', name: 'admin_fixed_signs')]
class FixedSignController extends AbstractAppController
{
    public function __construct(
        private readonly FixedSignRepository  $signRepository,
        private readonly FixedSignFileManager $fileManager,
        private readonly FixedSignHelper $signHelper,
    ) {
    }

    #[Route('', name: '_list')]
    public function list(): Response
    {
        $signs = $this->signRepository->findAll();

        return $this->render('admin/fixed_sign/list.html.twig', ['signs' => $signs]);
    }

    #[Route('/{id}/view', name: '_view')]
    public function view(int $id): Response
    {
        $sign = $this->signRepository->find($id);

        return $this->render(
            'admin/fixed_sign/view.html.twig',
            [
                'sign' => $sign,
                'chooseFilename' => $sign->getFilename(FixedSignFileType::Choose),
                'previewFilename' => $sign->getFilename(FixedSignFileType::Preview),
                'prodFilename' => $sign->getFilename(FixedSignFileType::Production),
                'chooseType' => FixedSignFileType::Choose->getName(),
                'previewType' => FixedSignFileType::Preview->getName(),
                'productionType' => FixedSignFileType::Production->getName(),
                'isRemovable' => $this->signHelper->isRemovable($sign)
            ]
        );
    }

    #[Route('/create', name: '_create')]
    public function create(Request $request): Response
    {
        $sign = new FixedSign();
        $form = $this->createForm(FixedSignCreateType::class, $sign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $this->fileManager->saveAll($sign);

            if (!$result) {
                $this->dispatchAlert(
                    Alert::INFO,
                    'Une erreur est survenue lors de l\'enregistrement des fichiers de production.'
                    . 'Merci de reessayer.'
                );
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($sign);
            $manager->flush();

            $this->dispatchHtmlAlert(
                Alert::INFO,
                sprintf(
                    'Le panneau <b>%s</b> a été enregistré.',
                    $sign->getTitle()
                )
            );

            return $this->redirectToRoute('admin_fixed_signs_list');
        }

        return $this->render(
            'admin/fixed_sign/create.html.twig',
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
        $form = $this->createForm(
            FixedSignUpdateType::class,
            $sign,
            [
                'validation_groups' => ['update']
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($sign->getName() !== $oldSign->getName()) {
                $result = $this->fileManager->renameAll($oldSign, $sign);

                if (!$result) {
                    $this->dispatchAlert(Alert::DANGER, 'Un problème est survenu, merci de re-essayer');

                    return $this->redirectToRoute('admin_fixed_signs_view', ['id' => $id]);
                }
            }

            $this->getDoctrine()->getManager()->flush();
            $this->dispatchAlert(Alert::INFO, 'Les informations ont été mises à jour.');

            return $this->redirectToRoute('admin_fixed_signs_view', ['id' => $id]);
        }

        return $this->render(
            'admin/fixed_sign/update.html.twig',
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
        $type = FixedSignFileType::from($type);
        $sign = $this->signRepository->find($id);
        $form = $this->createForm(
            FixedSignUpdateType::class,
            $sign,
            [
                FixedSignUpdateType::UPDATE_TYPE => $type,
                'validation_groups' => [$type->getName()]
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $this->fileManager->save($sign, $type);

            $result ?
                $this->dispatchAlert(Alert::SUCCESS, 'l\'image a été mise à jour.') :
                $this->dispatchAlert(Alert::DANGER, 'Un problème est survenu lors de l\'enregistrement.');

            return $this->redirectToRoute('admin_fixed_signs_view', ['id' => $id]);
        }

        return $this->render(
            'admin/fixed_sign/update.html.twig',
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

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('admin_fixed_signs_view', ['id' => $sign->getId()]);
    }

    #[Route('/{id}/delete', name: '_delete')]
    public function delete(int $id, Request $request): Response
    {
        $sign = $this->signRepository->find($id);
        if (!$this->signHelper->isRemovable($sign)) {
            $this->dispatchHtmlAlert(
                Alert::DANGER,
                'Impossible de supprimer ce panneau. Il est utilisé dans une commande.<br>'
                . 'dans ce cas, le panneau ne sera plus selectionnable pour les prochaines commandes'
            );

            return $this->redirectToRoute('admin_fixed_signs_view', ['id' => $id]);
        }

        if ($request->isMethod('POST')) {
            $this->fileManager->removeAll($sign);
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($sign);
            $manager->flush();

            $this->dispatchAlert(Alert::SUCCESS, 'Le panneau a été supprimé');

            return $this->redirectToRoute('admin_fixed_signs_list');
        }


        return $this->render(
            'admin/fixed_sign/delete.html.twig',
            [
                'sign' => $sign
            ]
        );
    }
}
