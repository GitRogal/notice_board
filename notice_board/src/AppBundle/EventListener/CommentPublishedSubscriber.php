<?php


namespace AppBundle\EventListener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommentPublishedSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            CommentPublishedEvent::NAME => 'onCommentPublished'
        ];
    }

    public function onCommentPublished(CommentPublishedEvent $event)
    {

    }
}