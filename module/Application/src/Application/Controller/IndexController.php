<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\Tools\Pagination\Paginator;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

        if (!$auth->hasIdentity()) {
            return $this->redirect()->toRoute('login');
        }
        else
        {
            $identity = $auth->getIdentity();
            $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
            $user = $em->find('Application\Entity\User', $identity->getId());

            $tickets = $user->getTickets();
            $pendingTasks = $em->getRepository('Application\Entity\Ticket')->findBy(array('status'=>array('pending', 'opened')));
            $resolvedTasks = $em->getRepository('Application\Entity\Ticket')->findBy(array('status'=>array('resolved')));

            return new ViewModel(array(
                'tickets' => $tickets,
                'pendingTasks' => $pendingTasks,
                'resolvedTasks' => $resolvedTasks,
            ));
        }
    }
}
