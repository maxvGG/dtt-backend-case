<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class HousesController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        //
    }

    /**
     * Searches for houses
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, 'Houses', $_GET)->getParams();
        $parameters['order'] = "id";

        $paginator   = new Model(
            [
                'model'      => 'Houses',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any houses");

            $this->dispatcher->forward([
                "controller" => "houses",
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
        //
    }

    /**
     * Edits a house
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $house = Houses::findFirstByid($id);
            if (!$house) {
                $this->flash->error("house was not found");

                $this->dispatcher->forward([
                    'controller' => "houses",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $house->getId();

            $this->tag->setDefault("id", $house->getId());
            $this->tag->setDefault("street", $house->getStreet());
            $this->tag->setDefault("number", $house->getNumber());
            $this->tag->setDefault("addition", $house->getAddition());
            $this->tag->setDefault("zipCode", $house->getZipcode());
            $this->tag->setDefault("city", $house->getCity());
            $this->tag->setDefault("rooms", $house->getRooms());
            
        }
    }

    /**
     * Creates a new house
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "houses",
                'action' => 'index'
            ]);

            return;
        }

        $house = new Houses();
        $house->setstreet($this->request->getPost("street"));
        $house->setnumber($this->request->getPost("number"));
        $house->setaddition($this->request->getPost("addition"));
        $house->setzipCode($this->request->getPost("zipCode"));
        $house->setcity($this->request->getPost("city"));
        $house->setrooms($this->request->getPost("rooms"));
        

        if (!$house->save()) {
            foreach ($house->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "houses",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("house was created successfully");

        $this->dispatcher->forward([
            'controller' => "houses",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a house edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "houses",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $house = Houses::findFirstByid($id);

        if (!$house) {
            $this->flash->error("house does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "houses",
                'action' => 'index'
            ]);

            return;
        }

        $house->setstreet($this->request->getPost("street"));
        $house->setnumber($this->request->getPost("number"));
        $house->setaddition($this->request->getPost("addition"));
        $house->setzipCode($this->request->getPost("zipCode"));
        $house->setcity($this->request->getPost("city"));
        $house->setrooms($this->request->getPost("rooms"));
        

        if (!$house->save()) {

            foreach ($house->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "houses",
                'action' => 'edit',
                'params' => [$house->getId()]
            ]);

            return;
        }

        $this->flash->success("house was updated successfully");

        $this->dispatcher->forward([
            'controller' => "houses",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a house
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $house = Houses::findFirstByid($id);
        if (!$house) {
            $this->flash->error("house was not found");

            $this->dispatcher->forward([
                'controller' => "houses",
                'action' => 'index'
            ]);

            return;
        }

        if (!$house->delete()) {

            foreach ($house->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "houses",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("house was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "houses",
            'action' => "index"
        ]);
    }
}
