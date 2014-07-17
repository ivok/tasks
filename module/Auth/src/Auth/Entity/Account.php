<?php

namespace Auth\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Class Account
 * @package Auth\Entity
 * @ORM\MappedSuperclass
 */
class Account
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
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"2"}})
     * @Annotation\Options({"class":"Username:"})
     * @Annotation\Attributes({"class":"form-control input-sm"})
     */
    protected $username;

    /**
     * @ORM\Column(type="string")
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"6"}})
     * @Annotation\Attributes({"class":"form-control input-sm"})
     */
    protected $password;

    /**
     * @ORM\Column(type="string")
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control input-sm"})
     */
    protected $email;

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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