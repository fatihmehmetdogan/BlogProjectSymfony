<?php

namespace App\EventListener;

use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RequestListener
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
          $this->entityManager = $entityManager;
          $this->passwordEncoder = $passwordEncoder;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }

        if ($event->getRequest()->request->get("submit") === 'register') {
            $member = new Member();
            $registrationFormData = $event->getRequest()->get("registration_form");
            $member->setEmail($registrationFormData['email']);
            $member->setPassword(
                $this->passwordEncoder->encodePassword($member, $registrationFormData['plainPassword'])
            );

            $this->entityManager->persist($member);
            $this->entityManager->flush();

        }
    }
}