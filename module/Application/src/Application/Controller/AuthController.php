<?php
/**
 * Created by PhpStorm.
 * User: vis
 * Date: 1/22/14
 * Time: 5:01 PM
 */

namespace Application\Controller;


use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use Symfony\Component\Console\Application;
use Zend\Mvc\Controller\AbstractActionController;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\View\Model\ViewModel;
use Application\Entity\User;
use Zend\Session\SessionManager;

class AuthController extends AbstractActionController
{
    public function indexAction()
    {
        $message = null;

        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $user = new User();

        $builder = new AnnotationBuilder($em);

        $form = $builder->createForm('Application\Entity\User');
        $form->setHydrator(new DoctrineHydrator($em, 'Application\Entity\User'))->bind($user);

        $request = $this->getRequest();



        if ($request->isPost()) {

            $form->setData($request->getPost());

            if($form->isValid())
            {
                $data = $request->getPost();

                $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

                $adapter = $authService->getAdapter();
                $adapter->setIdentityValue($data->username);
                $adapter->setCredentialValue($data->password);
                $authResult = $authService->authenticate();

                if ($authResult->isValid())
                {
                    $identity = $authResult->getIdentity();
                    $authService->getStorage()->write($identity);

                    return $this->redirect()->toRoute('home');
                }

                return new ViewModel(array(
                        'form' => $form,
                        'message' => 'Invalid username or password',
                    )
                );
            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }
} 