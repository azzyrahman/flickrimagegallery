<?php
namespace ImageGallery\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\ServiceManager\ServiceManager;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

use ImageGallery\Utilities\FlickrHelper;
use ImageGallery\Form\SearchForm;

class ImageGalleryController extends AbstractActionController
{
  const ITEM_PER_PAGE = 5;

  protected $serviceManager;

  private $images = null;

  public function __construct(ServiceManager $serviceManager) 
    {
      $this->serviceManager = $serviceManager;
    }

  public function indexAction()
    {
      return ['form' => new SearchForm()];
    }

    public function listAction()
    {
      $config = $this->serviceManager->get('config');
      $sessionContainer = $this->serviceManager->get('UserSessionContainer');
  
     	$page_no =$this->params()->fromQuery('page', 0);

      if (0 === $page_no ){
      
       if(isset($sessionContainer->images)){
        $date = date("Y-m-d H:i:s");
        if(isset($sessionContainer->recent_images)){
         //TODO: should be saved in db : flickr_images.flickr_image if time permits
         $sessionContainer->recent_images[$date] = $sessionContainer->images;
        } else {
         $sessionContainer->recent_images = [];
         $sessionContainer->recent_images[$date] = $sessionContainer->images;
        }
       }
       unset($sessionContainer->images);
       
       $form = new SearchForm();
       
       $request = $this->getRequest();
       if (! $request->isPost()) {
            return ['form' => $form];
       }
      
       $query = $this->getRequest()->getPost('query', null);
      
       if (null == $query) {
           return $this->redirect()->toUrl('/imagegallery');
       }
       $this->images = FlickrHelper::searchImages($config['flickr']['api_key'],$query); 
       if ($this->images !=null && isset($this->images['photos']['photo']) ){
        $sessionContainer->images = $this->images; 
        $page_no +=1;
       } else {
        return $this->redirect()->toUrl('/imagegallery');
       }
     }
     
     if ($this->images == null) {
       if(isset($sessionContainer->images)){
        $this->images = $sessionContainer->images;
       }
     }

     //print_r( $sessionContainer->images);
    
     if ($this->images !=null && isset($this->images['photos']['photo']) ){
       
        $paginator = new Paginator(new ArrayAdapter($this->images['photos']['photo']));
        $paginator->setCurrentPageNumber($page_no);
        $paginator->setDefaultItemCountPerPage(self::ITEM_PER_PAGE);
        
        $vm = new ViewModel();
        $vm->setVariable('paginator', $paginator);
        return $vm;
        
      }
      return ['form' => $form];
    }

    public function viewAction()
    {
    	$image_url = $this->params()->fromRoute('url', null);
      if (null === $image_url) {
            return $this->redirect()->toRoute('imagegallery', ['action' => 'index']);
        }
    
      return new ViewModel([
            'image_url' => $image_url,
        ]);
    }

    public function recentSearchAction()
    {
      //TODO
    }
   
}
