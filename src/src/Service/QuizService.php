<?php

namespace App\Service;

use App\Entity\Quiz;
use App\Entity\QuizQuestion;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;

class QuizService implements QuizServiceInterface
{
    protected QuestionRepository $questionRepository;
    protected EntityManagerInterface $entityManager;

    public function __construct(QuestionRepository $questionRepository, EntityManagerInterface $entityManager)
    {
        $this->questionRepository = $questionRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function createQuiz(): Quiz
    {
        $questions = $this->questionRepository->findAll();

        $quiz = (new Quiz())
            ->setCreatedAt(new \DateTimeImmutable());

        foreach ($questions as $question) {
            $quizQuestion = (new QuizQuestion())
                ->setQuestion($question);
            $quiz->addQuizQuestion($quizQuestion);
            $this->entityManager->persist($quizQuestion);
        }
        $this->entityManager->persist($quiz);
        $this->entityManager->flush();

        return $quiz;
    }

    /**
     * @inheritDoc
     */
    public function getCorrectQuestions(Quiz $quiz): array
    {
        $correctQuestions = [];
        foreach ($quiz->getQuizQuestions() as $quizQuestion) {
            if ($this->isCorrect($quizQuestion)) {
                $correctQuestions[] = $quizQuestion;
            }
        }
        return $correctQuestions;
    }

    /**
     * @inheritDoc
     */
    public function getIncorrectQuestions(Quiz $quiz): array
    {
        $incorrectQuestions = [];
        foreach ($quiz->getQuizQuestions() as $quizQuestion) {
            if (!$this->isCorrect($quizQuestion)) {
                $incorrectQuestions[] = $quizQuestion;
            }
        }
        return $incorrectQuestions;
    }

    /**
     * Checks the question is answered correctly
     *
     * @param QuizQuestion $quizQuestion
     * @return bool
     */
    protected function isCorrect(QuizQuestion $quizQuestion): bool
    {
        $correctAnswers = $quizQuestion->getQuestion()->getCorrectAnswers();
        $incorrectAnswers = $quizQuestion->getQuestion()->getIncorrectAnswers();

        $correctCount = 0;
        foreach ($quizQuestion->getAnswers() as $answer) {
            // at least one incorrect answer
            if ($incorrectAnswers->contains($answer)) {
                return false;
            }
            if ($correctAnswers->contains($answer)) {
                $correctCount++;
            }
        }

        // at least one correct answer chosen
        if ((count($correctAnswers) > 0) && $correctCount > 0) {
            return true;
        }

        return false;
    }

}
