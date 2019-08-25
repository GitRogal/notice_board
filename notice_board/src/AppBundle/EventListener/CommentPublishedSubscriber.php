<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Notices;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Environment;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommentPublishedSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer $mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer, Environment $engine)
    {
        $this->mailer = $mailer;
        $this->engine = $engine;
    }

    public static function getSubscribedEvents()
    {
        return [
            CommentPublishedEvent::NAME => 'onCommentPublished'
        ];
    }

//    public function onCommentPublished(CommentPublishedEvent $event)
//    {
//        $comment = $event->getComment();
//
//        /**
//         * $var Notices $notice
//         */
//        $notice = $event->getNotice();
//
//        $message = (new \Swift_Message('hello'))
//            ->setFrom('no-reply@thomas.com')
//            ->setTo('rogalthomas@op.pl')
//            ->setBody($this->renderView('mail/mail.html.twig'));
////        ->setBody($this->engine->render('mail/mail.html.twig', [
////        'comment' => $comment,
////        'notice' => $notice
////    ]));
//
//        return $this->mailer->send($message);
//    }
}