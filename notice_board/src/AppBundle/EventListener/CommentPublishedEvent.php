<?php


namespace AppBundle\EventListener;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Notices;
use Symfony\Component\EventDispatcher\Event;

class CommentPublishedEvent extends Event
{
    /**
     * @var Comment $comment
     */
    private $comment;

    const NAME = "comment.published";

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function getNotice(): Notices
    {
        return $this->comment->getNotice();
    }

    public function getComment(): Comment
    {
        return $this->comment;
    }
}