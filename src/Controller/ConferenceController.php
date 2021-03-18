<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Conference;
use App\Repository\ConferenceRepository;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(ConferenceRepository $conferenceRepository): Response
    {
        return $this->render(
            'conference/index.html.twig',
            [
                'conferences' => $conferenceRepository->findAll()
            ]
        );
    }

    /**
     * @Route("/conference/{id}", name="conference")
     */
    public function show(Conference $conference, CommentRepository $commentRepository): Response
    {
        return $this->render(
            'conference/show.html.twig',
            [
                'conference' => $conference,
                'comments' => $commentRepository->findBy(
                    ['conference' => $conference],
                    ['createdAt' => 'DESC']
                )
            ]
        );
    }
}
