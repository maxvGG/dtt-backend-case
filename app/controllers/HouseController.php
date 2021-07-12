<?php

declare(strict_types=1);



use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class HouseController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->loginredirect();
    }

    /**
     * Searches for house
     */
    public function searchAction()
    {
        $this->loginredirect();
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, 'House', $_GET)->getParams();
        $parameters['order'] = "id";

        $paginator   = new Model(
            [
                'model'      => 'House',
                'parameters' => $parameters,
                'limit'      => 200,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any house");

            $this->dispatcher->forward([
                "controller" => "house",
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
        $this->loginredirect();
    }

    /**
     * Edits a house
     *
     * @param string $id
     */
    public function editAction($id)
    {
        $this->loginredirect();
        if (!$this->request->isPost()) {
            $house = House::findFirstByid($id);
            if (!$house) {
                $this->flash->error("house was not found");

                $this->dispatcher->forward([
                    'controller' => "house",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $house->getId();

            $this->tag->setDefault("id", $house->getId());
            $this->tag->setDefault("street", $house->getStreet());
            $this->tag->setDefault("number", $house->getNumber());
            $this->tag->setDefault("addition", $house->getAddition());
            $this->tag->setDefault("zipcode", $house->getZipcode());
            $this->tag->setDefault("city", $house->getCity());
            $this->tag->setDefault("bedroomCount", $house->getBedroomcount());
            $this->tag->setDefault("livingroomCount", $house->getLivingroomcount());
            $this->tag->setDefault("bathroomCount", $house->getBathroomcount());
            $this->tag->setDefault("toiletCount", $house->getToiletcount());
            $this->tag->setDefault("storageCount", $house->getStoragecount());
        }
    }

    /**
     * Creates a new house
     */
    public function createAction()
    {
        $this->loginredirect();
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "house",
                'action' => 'index'
            ]);

            return;
        }

        $house = new House();
        $house->setid($this->request->getPost("id", "int"));
        $house->setstreet($this->request->getPost("street"));
        $house->setnumber($this->request->getPost("number", "int"));
        $house->setaddition($this->request->getPost("addition"));
        $house->setzipcode($this->request->getPost("zipcode"));
        $house->setcity($this->request->getPost("city"));
        $house->setbedroomCount($this->request->getPost("bedroomCount", "int"));
        $house->setlivingroomCount($this->request->getPost("livingroomCount", "int"));
        $house->setbathroomCount($this->request->getPost("bathroomCount", "int"));
        $house->settoiletCount($this->request->getPost("toiletCount", "int"));
        $house->setstorageCount($this->request->getPost("storageCount", "int"));


        if (!$house->save()) {
            foreach ($house->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "house",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("house was created successfully");

        $this->dispatcher->forward([
            'controller' => "house",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a house edited
     *
     */
    public function saveAction()
    {
        $this->loginredirect();
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "house",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $house = House::findFirstByid($id);

        if (!$house) {
            $this->flash->error("house does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "house",
                'action' => 'index'
            ]);

            return;
        }

        $house->setid($this->request->getPost("id", "int"));
        $house->setstreet($this->request->getPost("street"));
        $house->setnumber($this->request->getPost("number", "int"));
        $house->setaddition($this->request->getPost("addition"));
        $house->setzipcode($this->request->getPost("zipcode"));
        $house->setcity($this->request->getPost("city"));
        $house->setbedroomCount($this->request->getPost("bedroomCount", "int"));
        $house->setlivingroomCount($this->request->getPost("livingroomCount", "int"));
        $house->setbathroomCount($this->request->getPost("bathroomCount", "int"));
        $house->settoiletCount($this->request->getPost("toiletCount", "int"));
        $house->setstorageCount($this->request->getPost("storageCount", "int"));


        if (!$house->save()) {

            foreach ($house->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "house",
                'action' => 'edit',
                'params' => [$house->getId()]
            ]);

            return;
        }

        $this->flash->success("house was updated successfully");

        $this->dispatcher->forward([
            'controller' => "house",
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
        $this->loginredirect();
        $house = House::findFirstByid($id);
        if (!$house) {
            $this->flash->error("house was not found");

            $this->dispatcher->forward([
                'controller' => "house",
                'action' => 'index'
            ]);

            return;
        }

        if (!$house->delete()) {

            foreach ($house->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "house",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("house was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "house",
            'action' => "index"
        ]);
    }
    public function loginredirect()
    {
        if (!$this->session->get('userId')) {
            var_dump($_SESSION);
            $this->response->redirect('/user/login');
        }
    }
}
