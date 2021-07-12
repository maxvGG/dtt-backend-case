<?php

declare(strict_types=1);



use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Session\Adapter\Files as Session;

class UserController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->loginredirect();
    }

    /**
     * Searches for user
     */
    public function searchAction()
    {
        $this->loginredirect();
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, 'User', $_GET)->getParams();
        $parameters['order'] = "id";

        $paginator   = new Model(
            [
                'model'      => 'User',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any user");

            $this->dispatcher->forward([
                "controller" => "user",
                "action" => "index"
            ]);

            return;
        }

        $this->view->page = $paginate;
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
    }

    /**
     * Edits a user
     *
     * @param string $id
     */
    public function editAction($id)
    {
        $this->loginredirect();
        if (!$this->request->isPost()) {
            $user = User::findFirstByid($id);
            if (!$user) {
                $this->flash->error("user was not found");

                $this->dispatcher->forward([
                    'controller' => "user",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $user->getId();

            $this->tag->setDefault("id", $user->getId());
            $this->tag->setDefault("username", $user->getUsername());
            $this->tag->setDefault("password", $user->getPassword());
            $this->tag->setDefault("firstname", $user->getFirstname());
            $this->tag->setDefault("surname", $user->getSurname());
            $this->tag->setDefault("emailAddress", $user->getEmailaddress());
            $this->tag->setDefault("role", $user->getRole());
            $this->tag->setDefault("validationkey", $user->getValidationkey());
            $this->tag->setDefault("status", $user->getStatus());
            $this->tag->setDefault("createdat", $user->getCreatedat());
            $this->tag->setDefault("updatedat", $user->getUpdatedat());
        }
    }

    /**
     * Creates a new user
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "user",
                'action' => 'index'
            ]);

            return;
        }

        $user = new User();
        $user->setusername($this->request->getPost("username"));
        $user->setpassword($this->security->hash($this->request->getPost("password")));
        $user->setfirstname($this->request->getPost("firstname"));
        $user->setsurname($this->request->getPost("surname"));
        $user->setemailAddress($this->request->getPost("emailAddress"));
        $user->setrole("Registered User");
        $user->setstatus("Active");
        $user->setvalidationkey(md5($this->request->getPost("username") . uniqid()));
        $user->setcreatedat((new DateTime())->format("Y-m-d H:i:s")); //will set to the current date/time


        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "user",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("user was created successfully");

        $this->dispatcher->forward([
            'controller' => "houses",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a user edited
     *
     */
    public function saveAction()
    {
        $this->loginredirect();
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "user",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $user = User::findFirstByid($id);

        if (!$user) {
            $this->flash->error("user does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "user",
                'action' => 'index'
            ]);

            return;
        }

        $user->setusername($this->request->getPost("username"));
        $user->setpassword($this->request->getPost("password"));
        $user->setfirstname($this->request->getPost("firstname"));
        $user->setsurname($this->request->getPost("surname"));
        $user->setemailAddress($this->request->getPost("emailAddress"));
        $user->setrole($this->request->getPost("role"));
        $user->setvalidationkey($this->request->getPost("validationkey"));
        $user->setstatus($this->request->getPost("status"));
        $user->setcreatedat($this->request->getPost("createdat"));
        $user->setupdatedat($this->request->getPost("updatedat"));


        if (!$user->save()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "user",
                'action' => 'edit',
                'params' => [$user->getId()]
            ]);

            return;
        }

        $this->flash->success("user was updated successfully");

        $this->dispatcher->forward([
            'controller' => "user",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a user
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $this->loginredirect();
        $user = User::findFirstByid($id);
        if (!$user) {
            $this->flash->error("user was not found");

            $this->dispatcher->forward([
                'controller' => "user",
                'action' => 'index'
            ]);

            return;
        }

        if (!$user->delete()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "user",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("user was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "user",
            'action' => "index"
        ]);
    }
    /**
     * custom functions
     */
    public function loginAction()
    {
    }
    public function logoutAction()
    {

        $this->session->destroy();
        return $this->dispatcher->forward(["controller" => "user", "action" => "search"]);
    }
    public function authorizeAction()
    {
        $this->loginredirect();
        $username = $this->request->getPost('username');
        $pass = $this->request->getPost('password');
        $user = User::findFirstByUsername($username);

        if ($user) {
            if ($this->security->checkHash($pass, $user->getpassword())) {
                $this->session->set(
                    'auth',
                    [
                        'userName' => $user->getusername(),
                        'role' => $user->getRole()
                    ]
                );
                $this->session->set('user', $user);

                // tests to make sure u can't delete other peoples houses
                $this->session->set('userId', $user->{'id'});
                $this->session->set('userAuth', $user->{'role'});

                $this->flash->success("Welcome back " . $user->getusername());
                return $this->dispatcher->forward(["controller" => "house", "action" => "search"]);
            } else {
                $this->flash->error("Your password is incorrect - try again");
                return $this->dispatcher->forward(["controller" => "user", "action" => "login"]);
            }
        } else {
            $this->flash->error("That username was not found - try again");
            return $this->dispatcher->forward(["controller" => "user", "action" => "login"]);
        }
        return $this->dispatcher->forward(["controller" => "index", "action" => "index"]);
    }
    public function validation()
    {
        $validator = new Validation();
        $uValidator = new UniquenessValidator(["message" => "this userName has already been chosen"]);
        $validator->add('username', $uValidator);
        return $this->validate($validator);
    }
    public function loginredirect()
    {
        if (!$this->session->get('userId')) {
            var_dump($_SESSION);
            $this->response->redirect('/user/login');
        }
    }
}
