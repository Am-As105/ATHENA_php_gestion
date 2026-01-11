
<?php


abstract class User {
    protected int $id;
    protected string $email;
    protected string $name;

    public function __construct(int $id, string $name, string $email) {
        $this->id = $id;

        $this->name = $name;
        $this->email = $email;
    }

   
    public function getId(): int
     { 
        return $this->id;
     }
    public function getName() 
    {
         return $this->name; 
    }
    public function getEmail()
     { 
        return $this->email;
     }

    
    public function setName(string $name) 
    {
         $this->name = $name;
     }
    public function setEmail(string $email) 
    {
         $this->email = $email; 
    }

    abstract public function task(Task $task);
}

