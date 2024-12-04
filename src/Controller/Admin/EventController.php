<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Repository\EventRepository;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/events', name: 'admin_event_')]
class EventController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(EventRepository $repository): Response
    {
        $events = $repository->findBy([], ['id' => 'ASC']);

        return $this->render('admin/event/index.html.twig', compact('events'));
    }

    #[Route('/create', name: 'create', methods: ['GET'])]
    public function create(EventRepository $repository): Response
    {
        return $this->render('admin/event/create.html.twig');
    }

    #[Route('/store', name: 'store', methods: ['POST'])]
    public function store(EntityManagerInterface $manager, Request $request): Response
    {
        $data = $request->request->all()['event'];

        $timezone = new DateTimeZone('America/Sao_Paulo');

        $event = new Event();
        $event->setTitle($data['title']);
        $event->setDescription($data['description']);
        $event->setBody($data['body']);
        $event->setSlug($data['slug']);

        $event->setStartDate(DateTime::createFromFormat('d/m/Y H:i:s', $data['start_date']));
        $event->setEndDate(DateTime::createFromFormat('d/m/Y H:i:s', $data['end_date']));

        $event->setCreatedAt(new DateTimeImmutable('now', $timezone));
        $event->setUpdatedAt(new DateTimeImmutable('now', $timezone));


        $manager->persist($event);
        $manager->flush();

        return $this->redirectToRoute('admin_event_edit', ['id' => $event->getId()]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET'])]
    public function show(int $id, EventRepository $repository)
    {
        $event = $repository->find($id);

        if (!$event)
            throw $this->createNotFoundException();

        return $this->render('admin/event/edit.html.twig', compact('event'));
    }

    #[Route('/update/{id}', name: 'update', methods: ['POST'])]
    public function update(int $id, EntityManagerInterface $manager, EventRepository $eventRepository, Request $request): Response
    {
        $data = $request->request->all()['event'];

        $timezone = new DateTimeZone('America/Sao_Paulo');

        $event = $eventRepository->find($id);

        if (!$event) throw $this->createNotFoundException();

        $event->setTitle($data['title']);
        $event->setDescription($data['description']);
        $event->setBody($data['body']);
        $event->setSlug($data['slug']);

        $event->setStartDate(DateTime::createFromFormat('d/m/Y H:i:s', $data['start_date']));
        $event->setEndDate(DateTime::createFromFormat('d/m/Y H:i:s', $data['end_date']));

        $event->setUpdatedAt(new DateTimeImmutable('now', $timezone));

        $manager->flush();

        return $this->redirectToRoute('admin_event_edit', ['id' => $event->getId()]);
    }

    #[Route('/remove/{id}', name: 'remove', methods: ['GET'])]
    public function remove(int $id, EntityManagerInterface $manager, EventRepository $eventRepository): Response
    {
        $timezone = new DateTimeZone('America/Sao_Paulo');

        $event = $eventRepository->find($id);

        if (!$event) throw $this->createNotFoundException();

        $manager->remove($event);
        $manager->flush();

        return $this->redirectToRoute('admin_event_index');
    }
}
