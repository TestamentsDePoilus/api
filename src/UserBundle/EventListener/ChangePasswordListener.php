<?php

namespace UserBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;

class ChangePasswordListener implements EventSubscriberInterface
{
    protected $em;
    protected $twig;
    protected $mailer;

    public function __construct(EntityManager $EntityManager, \Twig_Environment $twig, \Swift_Mailer $mailer)
    {
        $this->em = $EntityManager;
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [FOSUserEvents::CHANGE_PASSWORD_SUCCESS => 'onPasswordChangingSuccess'];
    }

    public function onPasswordChangingSuccess(FormEvent $event)
    {
        /** @var $user \FOS\UserBundle\Model\UserInterface */
        $user = $event->getForm()->getData();
        $this->sendEmail($user->getEmail());
    }

    public function sendEmail($email)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Votre mot de passe a été modifié - Testaments de Poilus')
            ->setFrom('testaments-de-poilus@huma-num.fr')
            ->setTo($email)
            ->setBody($this->renderTemplate($email),'text/html')
        ;
        $this->mailer->send($message);
    }

    public function renderTemplate($email)
    {
        return $this->renderView(
            'UserBundle:ChangePassword:mail.html.twig',
             array('email' => $email)
        );
    }
}