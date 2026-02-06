<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    #[Route('/api/events', name: 'api_events', methods: ['GET'])]
    public function events(EventRepository $eventRepository): JsonResponse
    {
        $events = $eventRepository->findAll();

        $data = array_map(function($event) {
            return [
                'id' => $event->getId(),
                'title' => $event->getTitle(),
                'location' => $event->getLocation(),
                'date' => $event->getEventDate()->format('Y-m-d'),
                'description' => $event->getDescription(),
            ];
        }, $events);

        return new JsonResponse($data);
    }
}