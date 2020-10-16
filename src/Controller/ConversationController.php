<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Participant;
use App\Repository\ConversationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConversationController extends AbstractController
{
    /**
     * @var UserRepositry
     */
    protected $userRepository;

    /**
     * @var ConversationRepositry
     */
    protected $conversationRepository;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(
        UserRepository $userRepository,
        ConversationRepository $conversationRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->userRepository = $userRepository;
        $this->conversationRepository = $conversationRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/conversation/{id}", name="getConversations")
     * @param Request $request
     * @throws \Exception
     */
    public function index(Request $request, int $id): JsonResponse
    {
        // $otherUser = $request->get('otherUser', 0);
        $otherUser = $this->userRepository->find($id);

        if (is_null($otherUser)) {
            throw new \Exception('The user was not found!');
        }

        // Restrict to create conversation with same user.

        if ($otherUser->getId() == $this->getUser()->getId()) {
            throw new \Exception('That\'s deep, but you cannot create a conversation with yourself!');
        }

        // Check if conversation already exists

        $conversation = $this->conversationRepository->findConversationByParticipants(
            $otherUser->getId(),
            $this->getUser()->getId()
        );

        if (count($conversation)) {
            throw new \Exception('The conversation already exists!');
        }

        $conversation = new Conversation();
        $participant = new Participant();

        $participant->setUser($this->getUser());
        $participant->setConversation($this->getUser());

        return new JsonResponse($conversation);
    }
}
