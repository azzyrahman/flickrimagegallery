<?php
namespace User\Controller;

use Interop\Container\ContainerInterface;

use User\Model\UserRepository;

class UserControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
      return new UserController($container->get('ServiceManager'),$container->get('User\Model\UserRepository'));
   }
}
?>