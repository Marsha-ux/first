<?php
namespace app\controllers;

require __DIR__.'/../models/UserModel.php';
use app\models\UserModel;


class UserController {
    private $model;
  

    public function __construct($db) {
      
        $this->model = new UserModel($db);
    }
   private function jsonResponse($data){
    // var_dump("maria");
    header("Content-Type:application/json");
    // var_dump("maria");
    echo json_encode($data);

   }

    public function index() {
        $users = $this->model->getUsers();
        // var_dump('gg');
        $this->jsonResponse($users);
        //include __DIR__.'/../../Resourses/user_list.php';// viewلحتى اعرض ال  
    }

    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $data = [
                'username' => $username,
                'password' => $password,
            ];

            if ($this->model->addUser($data)) {
               // header('Location:' . BASE_PATH);
               $this->jsonResponse(['msg'=>'user added successfully']);
            } else {
                //echo "Failed to add user.";
                  $this->jsonResponse(['error'=>'failed to add']);
            }
        }
        else  $this->jsonResponse(['error'=>'method not allowed']);
    }

    public function showUsers() {
        $users = $this->model->getUsers();
        //include '../../Resourses/user_list.php';
        $this->jsonResponse($users);
    }

    public function deleteUser($id) {
        if ($this->model->deleteUser($id)) {
          //  echo "User deleted successfully!";
           // header('Location:' . BASE_PATH);
           $this->jsonResponse(['msg'=>"User deleted  successfully"]);
        } else {
           // echo "Failed to delete user.";
           $this->jsonResponse(['msg'=>"Failed to delete user"]);
        }
    }

    public function updateUser($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $data = [
                'username' => $username,
                'password' => $password,
            ];

            if ($this->model->updateUser($id, $data)) {
              //  echo "User updated successfully!";
               // header('Location:' . BASE_PATH);
               $this->jsonResponse(['msg'=>"User updated successfully"]);
            } else {
              //  echo "Failed to update user.";
              $this->jsonResponse(['msg'=>"Failed to update user."]);
            }
        } else {
            $user = $this->model->getUserById($id);
           // include __DIR__.'/../../Resourses/edit_user.php';
           $this->jsonResponse($users);
           
        }
    }

    public function editUser($id) {
        $user = $this->model->getUserById($id);
       // include __DIR__.'/../../Resourses/edit_user.php';
       $this->jsonResponse($users);
    }

    public function searchUsers($searchTerm) {
        $users = $this->model->searchUsers($searchTerm);
        include '../../Resourses/user_list.php';
    }

    public function showSearchedUsers($searchTerm) {
        $users = $this->model->searchUsers($searchTerm);
        include '../../Resourses/user_list.php';
    }
}
