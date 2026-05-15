<?php

namespace App\Services;

class GrievanceIntelligenceService
{
    private const CATEGORY_KEYWORDS = [
        'HR issues' => ['hr', 'manager', 'leave', 'salary', 'harassment', 'team', 'policy', 'attendance', 'workplace'],
        'Funding/legal issues' => ['funding', 'legal', 'invoice', 'contract', 'compliance', 'equity', 'investment', 'payment', 'lawyer'],
        'Technical/IT problems' => ['server', 'bug', 'error', 'login', 'system', 'database', 'it', 'deploy', 'technical', 'app'],
        'Other' => [],
    ];

    private const NEGATIVE_TERMS = [
        'urgent', 'blocked', 'angry', 'delay', 'critical', 'stuck', 'broken', 'failed', 'harassment', 'panic',
    ];

    private const POSITIVE_TERMS = [
        'thanks', 'resolved', 'okay', 'minor', 'gentle', 'stable',
    ];

    public function suggestCategory(string $subject, string $description, ?string $submittedCategory = null): string
    {
        if ($submittedCategory && $submittedCategory !== 'Other') {
            return $submittedCategory;
        }

        $haystack = strtolower($subject.' '.$description);
        $bestCategory = 'Other';
        $bestScore = 0;

        foreach (self::CATEGORY_KEYWORDS as $category => $keywords) {
            $score = 0;

            foreach ($keywords as $keyword) {
                if (str_contains($haystack, $keyword)) {
                    $score++;
                }
            }

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestCategory = $category;
            }
        }

        return $bestCategory;
    }

    public function analyzeSentiment(string $subject, string $description, string $priority): array
    {
        $haystack = strtolower($subject.' '.$description);
        $score = 0;

        foreach (self::NEGATIVE_TERMS as $term) {
            if (str_contains($haystack, $term)) {
                $score -= 1.2;
            }
        }

        foreach (self::POSITIVE_TERMS as $term) {
            if (str_contains($haystack, $term)) {
                $score += 0.8;
            }
        }

        $score += match ($priority) {
            'High' => -1.5,
            'Medium' => -0.5,
            default => 0.25,
        };

        $label = match (true) {
            $score <= -2 => 'Critical',
            $score <= -0.75 => 'Concerned',
            $score < 1 => 'Neutral',
            default => 'Calm',
        };

        return [
            'score' => round($score, 2),
            'label' => $label,
        ];
    }

    public function determineSlaHours(string $priority, string $sentimentLabel): int
    {
        if ($priority === 'High' || $sentimentLabel === 'Critical') {
            return 24;
        }

        if ($priority === 'Medium' || $sentimentLabel === 'Concerned') {
            return 48;
        }

        return 72;
    }
}
