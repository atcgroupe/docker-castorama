<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use App\Service\Member\MemberSessionHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/members', name: 'member')]
class MemberController extends AbstractController
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

            $this->addFlash('info', 'Le nouveau membre a été ajouté avec succès.');

            return $this->redirectToRoute('member_choose');
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

            $this->addFlash('info', 'Vos données ont été mises à jour avec succès.');

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

            $this->addFlash('info', sprintf('le membre %s a été supprimé avec succès.', $member->getName()));

            return $this->redirectToRoute('home');
        }


        return $this->render('member/delete.html.twig');
    }
}
