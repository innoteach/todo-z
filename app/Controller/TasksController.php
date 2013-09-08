<?php

App::uses('AppController', 'Controller');

/**
 * Tasks Controller
 *
 * @property Task $Task
 * @property PaginatorComponent $Paginator
 */
class TasksController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'RequestHandler');

    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = array('Js' => array('Jquery'), 'Number');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->set('tasks', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Task->exists($id)) {
            throw new NotFoundException(__('Invalid task'));
        }
        $options = array('conditions' => array('Task.' . $this->Task->primaryKey => $id));
        $this->set('task', $this->Task->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Task->create();
            if ($this->Task->save($this->request->data)) {
                $this->Session->setFlash(__('The task has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The task could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Task->exists($id)) {
            throw new NotFoundException(__('Invalid task'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Task->save($this->request->data)) {
                $this->Session->setFlash(__('The task has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The task could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Task.' . $this->Task->primaryKey => $id));
            $this->request->data = $this->Task->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Task->id = $id;
        if (!$this->Task->exists()) {
            throw new NotFoundException(__('Invalid task'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Task->delete()) {
            $this->Session->setFlash(__('The task has been deleted.'));
        } else {
            $this->Session->setFlash(__('The task could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * Reorder an individual element on the list
     * @param char $id
     * @param int $sort
     */
    public function reorder($id, $sort) {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $this->set('r', $this->Task->reorder_sort($id, $sort));
        $this->set('_serialize', array('r'));
        $this->render();
    }

}