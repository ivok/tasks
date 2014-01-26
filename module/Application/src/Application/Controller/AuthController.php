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
        $message = null;

        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $user = new User();

        $builder = new AnnotationBuilder($em);

        $form = $builder->createForm('Application\Entity\User');
        $form->setHydrator(new DoctrineHydrator($em, 'Application\Entity\User'))->bind($user);
        $form->get('confirmPassword')->setValue("default_value");

        $request = $this->getRequest();


        if ($request->isPost()) {

            $request->setContent('confirmPassword', 'sadasad');

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

    public function registerAction()
    {
        $message = null;

        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $user = new User();

        $builder = new AnnotationBuilder($em);

        $form = $builder->createForm('Application\Entity\User');
        $form->setHydrator(new DoctrineHydrator($em, 'Application\Entity\User'))->bind($user);

        $request = $this->getRequest();

        if($request->isPost())
        {
            $form->setData($request->getPost());

            if ($form->isValid())
            {
                echo "validation successful";
            }
            else
            {
                return new ViewModel(array(
                    'form' => $form,
                    'message' => 'Invalid fields',
                ));
            }
        }

        return new ViewModel(array(
            'form'=>$form,
        ));
    }
} 