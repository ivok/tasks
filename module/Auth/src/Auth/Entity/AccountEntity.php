<?php
/**
 * Created by PhpStorm.
 * User: vis
 * Date: 1/22/14
 * Time: 3:46 PM
 */

namespace Auth\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Class AccountEntity
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @Annotation\Name("user")
 * @Annotation\Attributes({"class":"form-horizontal"})
 */
class AccountEntity extends Account
{
    /**
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Attributes({"class":"form-control input-sm"})
     */
    protected $confirmPassword;

    /**
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     */
    protected $remember;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Submit", "class":"btn btn-primary btn-sm"})
     */
    protected $submit;
}