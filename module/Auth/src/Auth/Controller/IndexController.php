<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\SessionManager;

use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use Auth\Entity\AccountEntity;


class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function loginAction()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $user = new AccountEntity();
        $builder = new AnnotationBuilder($em);
        $form = $builder->createForm('Auth\Entity\AccountEntity');
        $form->setHydrator(new DoctrineHydrator($em, 'Auth\Entity\AccountEntity'))->bind($user);
        $form->setValidationGroup('username', 'password');
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $request->getPost();
                $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
                $adapter = $authService->getAdapter();
                $adapter->setIdentityValue($data->username);
                $adapter->setCredentialValue(md5($data->password));
                $authResult = $authService->authenticate();

                if ($authResult->isValid()) {
                    $identity = $authResult->getIdentity();
                    $authService->getStorage()->write($identity);

                    if ($data->remember == 1) {
                        $session = new SessionManager();
                        $session->rememberMe();
                    } else {
                        $session = new SessionManager();
                        $session->forgetMe();
                    }

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
            'test' => 'kur'
        ));
    }

    public function logoutAction()
    {
        if ($this->identity()) {
            $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
            $authService->clearIdentity();
        }
        $session = new SessionManager();
        $session->forgetMe();
        $session->destroy();
        return $this->redirect()->toRoute('auth/login');
    }

    public function registerAction()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $user = new AccountEntity();
        $builder = new AnnotationBuilder($em);

        $form = $builder->createForm('Auth\Entity\AccountEntity');
        $form->setHydrator(new DoctrineHydrator($em, 'Auth\Entity\AccountEntity'))->bind($user);
        $form->setValidationGroup('email', 'username', 'password', 'confirmPassword');
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            $data = $request->getPost();

            if ($form->isValid()) {

                if ($em->getRepository('Auth\Entity\AccountEntity')->findOneBy(array('username' => $data->username)) !== null) {
                    return new ViewModel(array(
                        'form' => $form,
                        'message' => 'Username already exists',
                        'hideForm' => false,
                    ));
                }

                if ($data->password != $data->confirmPassword) {
                    return new ViewModel(array(
                        'form' => $form,
                        'message' => 'Passwords do not match',
                        'hideForm' => false,
                    ));
                }
                $em->persist($user);
                $em->flush();

                return new ViewModel(array(
                    'form' => $form,
                    'hideForm' => true,
                    'message' => 'Registration successful',
                ));
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'hideForm' => false,
        ));
    }
}
