<?php
App::uses('AppModel', 'Model');
/**
 * Task Model
 *
 */
class Task extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

        /**
         * Default order by field
         * @var string
         */
        public $order = 'sort';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
			),
		),
		'name' => array(
			'minlength' => array(
				'rule' => array('minlength','3'),
				'message' => 'Surely you can be more descriptive.',
			),
		),
		'completed' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
			),
		),
		'sort' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
			),
		),
	);

        
/**
 * Model Functions
 */
        
        public function beforeSave($options = array()){
            parent::beforeSave();
           return $this->set_sort_field($this->data);
        }
        
       
        /**
         * Get the next sort value 
         * @return float next sort value
         */
        public function get_sort_next(){
            //use implicit conversion so we always get a int
            $r = $this->field('max(sort)');
            return $r+1;
        }
        
        public function reorder_sort($id, $sort){
                try{
                    $this->id = $id;
                    return $this->saveField('sort',$sort);
                } 
                catch(Exception $e){
                    $this->log($e);
                    $this->flash('Error while saving. Please try again later');
                }
        }
        
        
        private function set_sort_field($data){
            if(empty($data['Task']['sort'])){
                $sort = $this->get_sort_next(); 
            }
            //detect an exclude an edit
            if(!$this->id && !isset($this->data[$this->alias][$this->primaryKey])){
                $this->data['Task']['sort'] = $sort;
            }
            return true;
        }
}
