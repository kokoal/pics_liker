<?php
namespace Image\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Image\Model\Image;          
 use Image\Form\ImageForm; 
 
 use Zend\Session\Container;
 

 class ImageController extends AbstractActionController
 {
     // module/Album/src/Album/Controller/AlbumController.php:
     protected $imageTable;
     public function getImageTable()
     {
         if (!$this->imageTable) {
             $sm = $this->getServiceLocator();
             $this->imageTable = $sm->get('Image\Model\ImageTable');
         }
         return $this->imageTable;
     }
     
     // module/Album/src/Album/Controller/AlbumController.php:
 // ...
     public function indexAction()
     {
         return new ViewModel(array(
             'images' => $this->getImageTable()->fetchAll(),
         ));
     }
 // ...
   

     public function addAction()
     {
         $form = new ImageForm();
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $image = new Image();
             $form->setInputFilter($image->getInputFilter());
             
             $nonFile = $request->getPost()->toArray();
             $File = $this->params()->fromFiles('lien');
             
             $names = $File['name'];
             
             echo $names;
             
             $form->setData($request->getPost());
             $data = array_merge(
                 $nonFile, //POST 
                 array('fileupload'=> $File['name']) //FILE...
             );
             

             if ($form->isValid()) {
                 
                 $image->exchangeArray($form->getData());
                 $this->getImageTable()->saveImage($image);

                 // Redirect to list of images
                 return $this->redirect()->toRoute('image');
             }
         }
         return array('form' => $form);
     }

     public function deleteAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('image');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $this->getImageTable()->deleteImage($id);
             }

             // Redirect to list of images
             return $this->redirect()->toRoute('image');
         }

         return array(
             'id'    => $id,
             'image' => $this->getImageTable()->getImage($id)
         );
     }
 }