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

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;


class TicketsController extends AbstractActionController
{
    public function indexAction()
    {
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

//        $repository = $entityManager->getRepository('Application\Entity\Ticket');
//        $adapter = new DoctrineAdapter(new ORMPaginator($repository->createQueryBuilder('ticket')));
//        $paginator = new Paginator($adapter);
//        $paginator->setDefaultItemCountPerPage(1);

        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('item')
            ->from('Application\Entity\Ticket', 'item')
            ->orderBy('item.date', 'ASC');
        $adapter = new DoctrineAdapter(new ORMPaginator($queryBuilder));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(1);

        $page = (int)$this->params()->fromRoute('page');

        if($page) $paginator->setCurrentPageNumber($page);

        return new ViewModel(array(
            'paginator' => $paginator,
        ));
    }

    public function pendingAction()
    {

    }

    public function resolvedAction()
    {

    }

    public function mytasksAction()
    {

    }
}