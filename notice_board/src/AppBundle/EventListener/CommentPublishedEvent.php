<?php


namespace AppBundle\EventListener;

use AppBundle\Entity\Comment;
use Symfony\Component\EventDispatcher\Event;

class CommentPublishedEvent extends Event
{
    /**
     * @var Comment $_comment
     */
    private $_comment;

    const NAME = "comment.published";

    public function __construct(Comment $comment)
    {
        $this->_comment = $comment;
    }

    public function getNotice()
    {
        $this->_comment->getNotice();
    }
}