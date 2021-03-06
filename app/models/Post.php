<?php

class Post extends Model
{
    protected $author;
    protected $title;
    protected $body;
    protected $score;
    protected $votes;
    protected $comments = [];

    public function __construct()
    {
        parent::__construct();

        $this->setComments();

    }

    public function save()
    {
        $sql = "
            INSERT INTO posts(author, title, body)
            VALUES('{$this->author}', '{$this->title}', '{$this->body}')
        ";
        $this->db->exec($sql);

        $this->id = $this->db->lastInsertId();
    }

    public function update()
    {
        $sql = "
            UPDATE posts
            SET title='{$this->title}', body='{$this->body}'
            WHERE id={$this->id}
        ";
        
        $this->db->exec($sql);
    }
    public function addComment()
    {
        Comment::save($this);
    }

    public function vote()
    {
        $sql = "
            UPDATE posts
            SET score={$this->score}, votes={$this->votes} + 1
            WHERE id={$this->id}
        ";
    
        $this->db->exec($sql);
    }

    public function calcScore($vote)
    {
        $newScore = ($this->getScore() * $this->getVotes() + $vote) / ($this->getVotes() + 1); 

        $this->setScore($newScore);

        return $this->getScore();
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getScore()
    {
        return round((float) $this->score, 2);
    }

    public function setScore($score)
    {
        $this->score = $score;
    }

    public function getVotes()
    {
        return $this->votes;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments()
    {
        $this->comments = Comment::getBy('post_id', $this->id);
    }








}
