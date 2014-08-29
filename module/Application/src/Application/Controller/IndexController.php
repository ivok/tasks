<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Controller\CommonController\CommonController;
use Zend\Mvc\Application;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class IndexController extends CommonController
{
    public function indexAction()
    {
//        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
//        $queryBuilder = $entityManager->createQueryBuilder();
//        $queryBuilder->select('item')
//            ->from('Application\Entity\Ticket', 'item')
//            ->orderBy('item.date', 'ASC');
//        $adapter = new DoctrineAdapter(new ORMPaginator($queryBuilder));
//        $paginator = new Paginator($adapter);
//        $paginator->setDefaultItemCountPerPage(1);
//
//        $page = (int)$this->params()->fromRoute('page');
//
//        if($page) $paginator->setCurrentPageNumber($page);
//
//        return new ViewModel(array(
//            'paginator' => $paginator,
//        ));

        $this->getEventManager()->attachAggregate($this->getServiceLocator()->get('SendSms'));
        $this->getEventManager()->attachAggregate($this->getServiceLocator()->get('SendEmail'));

        $parameter = array('id' => 1);
        $this->getEventManager()->trigger('completeRegistration', $this, $parameter);
        $this->getEventManager()->trigger('notification', $this, $parameter);

        return new ViewModel();
    }
}
