<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller\CommonController;

use Zend\Mvc\Controller\AbstractActionController;

class CommonController extends AbstractActionController
{
    /**
     * @return array|object
     *
     * Get Doctrine Entity Manager
     */
    protected function getObjectManager()
    {
       return $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    }

    /**
     * @return mixed
     *
     * Get Doctrine Query Builder
     */
    protected function getQueryBuilder()
    {
        return $this->getObjectManager()->createQueryBuilder();
    }
}