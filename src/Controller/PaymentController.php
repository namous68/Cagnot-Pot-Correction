<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Participant;
use App\Entity\Payment;
use App\Form\PaymentType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/campaign/{id}/payment', name: 'app_campaign_payment', methods: ['GET', 'POST'])]
    public function payment(Campaign $campaign, Request $request, EntityManagerInterface $entityManager): Response
    {
        $payment = new Payment();

        $formPayment = $this->createForm(PaymentType::class, $payment);
        $formPayment->handleRequest($request);

        if ($formPayment->isSubmitted() && $formPayment->isValid()) {

            $payment->setCreatedAt(new DateTimeImmutable());
            $payment->setUpdatedAt(new DateTimeImmutable());

            $payment->getParticipant()->setCampaign($campaign);
            $payment->getParticipant()->getCampaign()->setUpdatedAt(new DateTimeImmutable());

            $entityManager->persist($payment);
            $entityManager->flush();

            return $this->redirectToRoute('app_campaign_show', ['id' => $campaign->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('campaign/payment.html.twig', [
            'campaign' => $campaign,
            'formPayment' => $formPayment
        ]);
    }


}
