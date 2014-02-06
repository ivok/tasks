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
        return new ViewModel();
    }

    public function loginAction()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $user = new User();
        $builder = new AnnotationBuilder($em);
        $form = $builder->createForm('Application\Entity\User');
        $form->setHydrator(new DoctrineHydrator($em, 'Application\Entity\User'))->bind($user);
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
        return $this->redirect()->toRoute('login');
    }

    public function registerAction()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $user = new User();
        $builder = new AnnotationBuilder($em);

        $form = $builder->createForm('Application\Entity\User');
        $form->setHydrator(new DoctrineHydrator($em, 'Application\Entity\User'))->bind($user);
        $form->setValidationGroup('username', 'password', 'confirmPassword');
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            $data = $request->getPost();

            if ($form->isValid()) {
                if ($em->getRepository('Application\Entity\User')->findOneBy(array('username' => $data->username)) !== null) {
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