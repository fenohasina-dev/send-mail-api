<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mime\Email;

final class ContactController extends AbstractController
{

    #[Route('/api/contact', methods: ['POST'])]
    public function send(Request $request, MailerInterface $mailer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $subject = $data['subject'] ?? 'Nouveau message';
        $message = $data['message'] ?? '';

        if (!$name || !$email || !$message) {
            return new JsonResponse(['error' => 'Champs requis'], 400);
        }

        $mail = (new Email())
            ->from('no-reply@tonsite.com')
            ->to('andrinirinafenohasina@gmail.com')
            ->subject($subject)
            ->text("Nom: $name\nEmail: $email\nMessage:\n$message");

        $mailer->send($mail);

        return new JsonResponse(['success' => true]);
    }
}
