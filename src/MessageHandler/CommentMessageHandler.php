<?php

namespace App\MessageHandler;

use App\Message\CommentMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\SpamChecker;
use App\Repository\CommentRepository;

final class CommentMessageHandler implements MessageHandlerInterface
{
    /** @var SpamChecker */
    private $spamChecker;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var CommentRepository */
    private $commentRepository;

    public function __construct(EntityManagerInterface $entityManager, SpamChecker $spamChecker, CommentRepository $commentRepository)
    {
        $this->entityManager = $entityManager;        
        $this->spamChecker = $spamChecker;        
        $this->commentRepository = $commentRepository;
    }

    public function __invoke(CommentMessage $message)
    {
        $comment = $this->commentRepository->find($message->getId());

        if (!$comment) {
            return;
        }

        if (2 === $this->spamChecker->getSpamScore($comment, $message->getContext())) {
            $comment->setState('spam');
        } else {
            $comment->setState('published');
        }

        $this->entityManager->flush();
    }
}
