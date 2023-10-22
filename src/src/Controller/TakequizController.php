<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Entity\QuizQuestion;
use App\Form\QuizType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TakequizController extends AbstractController
{
    #[Route('/takequiz', name: 'takequiz')]
    public function index(        Request $request,
                                  QuestionRepository $questionRepository,
                                  EntityManagerInterface $entityManager
    ): Response
    {
        $questions = $questionRepository->findAll();

        $quiz = (new Quiz())
            ->setCreatedAt(new \DateTimeImmutable());

        foreach ($questions as $question) {
            $quizQuestion = (new QuizQuestion())
                ->setQuestion($question);

            $quiz->addQuizQuestion($quizQuestion);

            $entityManager->persist($quizQuestion);
        }
        $entityManager->persist($quiz);
        $entityManager->flush();

        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... do your form processing, like saving the Task and Tag entities
        }

        return $this->render('quiz/index.html.twig', [
            'controller_name' => 'QuizController',
            'quiz' => $quiz,
            'form' => $form->createView(),
        ]);
    }
}
