<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\Users;
use Symfony\Component\Security\Core\Security;
use App\Form\TicketFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PanelController extends AbstractController
{
    /**
     * @Route("/panel_member", name="panel_member")
     */
    public function member(Request $request, Security $security): Response
    {

        $users = $this->getUser();
        $speticket = $this->getDoctrine()
        ->getRepository(Ticket::class)
        ->findBy(
            ['user' => $users]
        );

        $ticket = new Ticket();
        $this->security = $security;
        $user = $security->getUser();
        $form = $this->createForm(TicketFormType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket->setLabel(
                $form->get('label')->getData()
            );
            $ticket->setSubject(
                $form->get('subject')->getData()
            );
            $ticket->setTitle(
                $form->get('title')->getData()
            );
            $ticket->setUser(
                $user
            );
            $ticket->setIsActive(
                true
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticket);
            $entityManager->flush();

    }
        return $this->render('panel/member.html.twig', [
            'controller_name' => 'PanelController',
            'speticket' => $speticket,
            'ticketForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/panel_admin", name="panel_admin")
     */
    public function admin()
    {
        $tickets = $this->getDoctrine()
        ->getRepository(Ticket::class)
        ->getAllTickets();
        
        return $this->render('panel/admin.html.twig', [
            'controller_name' => 'PanelController',
            'tickets' => $tickets
        ]);
    }
}
