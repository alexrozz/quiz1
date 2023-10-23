<?php

namespace App\Controller;

use App\Form\QuizType;
use App\Repository\QuestionRepository;
use App\Service\QuizServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/app/quiz', name: 'app_quiz')]
    public function quiz(
        Request $request,
        EntityManagerInterface $entityManager,
        QuizServiceInterface $quizService
    ): Response
    {
        $quiz = $quizService->createQuiz();

        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quiz->setCompletedAt(new \DateTimeImmutable());
            $entityManager->flush();

            $correctQuestions = $quizService->getCorrectQuestions($quiz);
            $incorrectQuestions = $quizService->getIncorrectQuestions($quiz);
        }

        return $this->render('app/index.html.twig', [
            'form' => $form->createView(),
            'correctQuestions' => $correctQuestions ?? null,
            'incorrectQuestions' => $incorrectQuestions ?? null,
        ]);
    }
}
