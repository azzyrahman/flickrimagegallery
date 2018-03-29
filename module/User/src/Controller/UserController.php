<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\ServiceManager\ServiceManager;

use User\Form\UserForm;
use User\Model\User;
use User\Model\UserRepository;

class UserController extends AbstractActionController
{
  
	  private $userRepository;
    protected $serviceManager;

    public function __construct(ServiceManager $serviceManager, UserRepository $userRepository)
    {
        $this->serviceManager = $serviceManager;
        $this->userRepository = $userRepository;
    }

    public function signupAction()
    {
      $sessionContainer = $this->serviceManager->get('UserSessionContainer');
          
      $form = new UserForm();

      //print_r($sessionContainer);

      $request = $this->getRequest();
      if ($request->isPost()) {
        $user = new User();
        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());

        if ($form->isValid()) {
          $user->exchangeArray($form->getData());
          $user->create_system = $this->params('controller');
          $this->userRepository->saveUser($user);
          
          // TODO: Save user in the session 
           $sessionContainer->email = $user->email;
          // Redirect to image search page
          return $this->redirect()->toRoute('imagegallery', ['action' => 'index']);
         }
      }
      return array('form' => $form);
    }

    public function loginAction()
    {
      //TODO
    }

    public function logoutAction()
    {
      //TODO
    }
}
?>