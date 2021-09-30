<?php

namespace App\Controller\Member;

use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use App\Service\Controller\AbstractAppController;
use App\Service\Alert\Alert;
use App\Service\Member\MemberSessionHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/members', name: 'member')]
class MemberController extends AbstractAppController
{
    public const MEMBER_SELECT_ROUTE_PREFIX = '/members/select/';

    public function __construct(
        private MemberSessionHandler $memberSessionHandler,
    ) {
    }

    #[Route('/choose', name: '_choose')]
    public function choose(MemberRepository $memberRepository): Response
    {
        $this->memberSessionHandler->destroy();
        $members = $memberRepository->findBy(['user' => $this->getUser()], ['name' => 'ASC']);

        return $this->render('member/choose.html.twig', ['members' => $members]);
    }

    #[Route('/select/{id}', name: '_select')]
    public function select(int $id, MemberRepository $memberRepository,): RedirectResponse {
        $this->memberSessionHandler->set($memberRepository->find($id));

        $this->dispatchAlert(
            Alert::BASIC,
            sprintf('Bonjour %s', $this->memberSessionHandler->get()->getName()),
            true,
            2000
        );

        return $this->redirectToRoute('home');
    }

    #[Route('/create', name: '_create')]
    public function create(Request $request): Response
    {
        $member = new Member();
        $member->setUser($this->getUser());

        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($member);
            $manager->flush();

            $this->dispatchHtmlAlert(
                Alert::INFO,
                sprintf('Bienvenue <b>%s</b>!', $member->getName())
            );

            $this->memberSessionHandler->destroy();
            $this->memberSessionHandler->set($member);

            return $this->redirectToRoute('member_events', ['id' => $member->getId()]);
        }

        return $this->render('member/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}/update', name: '_update')]
    public function update(int $id, Request $request, MemberRepository $memberRepository): Response
    {
        $member = $memberRepository->find($id);
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->memberSessionHandler->set($member);

            $this->dispatchAlert(Alert::INFO, 'Vos données ont été mises à jour avec succès.');

            return $this->redirectToRoute('home');
        }

        return $this->render('member/update.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}/delete', name: '_delete')]
    public function delete(int $id, Request $request, MemberRepository $memberRepository): Response
    {
        if ($request->isMethod('POST')) {
            $member = $memberRepository->find($id);

            $manager = $this->getDoctrine()->getManager();
            $manager->remove($member);
            $manager->flush();

            $this->memberSessionHandler->destroy();

            $this->dispatchHtmlAlert(
                Alert::INFO,
                sprintf('le membre <b>%s</b> a été supprimé avec succès.', $member->getName())
            );

            return $this->redirectToRoute('home');
        }


        return $this->render('member/delete.html.twig');
    }
}
