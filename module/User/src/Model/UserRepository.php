<?php
namespace User\Model;

use Zend\Db\TableGateway\TableGateway;

use User\Utilities\LoginHelper;

class UserRepository
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchByEmail($email)
     {
         $rowset = $this->tableGateway->select(array('email' => $email));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find user with email: $email");
         }
         return $row;
     }

     public function getUser($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find user $id");
         }
         return $row;
     }

     public function saveUser(User $user)
     {
         $data = array(
             'email'     => $user->email,
             'name'      => $user->name,
             'password'  => LoginHelper::encrypt($user->name),
             'create_system'  => $user->create_system
            );

         $id = (int) $user->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getUser($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('User id does not exist');
             }
         }
     }

    
 }
 ?>