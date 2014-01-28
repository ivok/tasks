<?php
/**
 * Created by PhpStorm.
 * User: vis
 * Date: 1/22/14
 * Time: 3:46 PM
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * class User
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @Annotation\Name("user")
 * @Annotation\Attributes({"class":"form-horizontal"})
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Annotation\Exclude
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"1"}})
     * @Annotation\Options({"class":"Username:"})
     * @Annotation\Attributes({"class":"form-control"})
     */
    protected $username;

    /**
     * @ORM\Column(type="string")
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"6"}})
     * @Annotation\Attributes({"class":"form-control"})
     */
    protected $password;

    /**
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Attributes({"class":"form-control"})
     */
    protected $confirmPassword;

    /**
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     */
    protected $remember;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Submit", "class":"btn btn-primary"})
     */
    protected $submit;

    /**
     * @ORM\OneToMany(targetEntity="Ticket", mappedBy="user")
     */
    protected $tickets;


    function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = md5($password);
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }


}