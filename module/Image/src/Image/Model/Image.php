<?php
namespace Image\Model;

 // Add these import statements
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;

 class Image implements InputFilterAwareInterface
 {
     public $id;
     public $lien;
     public $id_membre;
     protected $inputFilter;                    

       public function exchangeArray($data)
     {
         $this->id     = (isset($data['id']))     ? $data['id']     : null;
         $this->lien = (isset($data['lien'])) ? $data['lien'] : null;
         $this->id_membre  = (isset($data['id_membre']))  ? $data['id_membre']  : null;
     }

     // Add the following method:
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }

     // Add content to these methods:
     public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }

     public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'lien',
                 'required' => true,
             ));

             $inputFilter->add(array(
                 'name'     => 'id_membre',
                 'required' => false,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
 }