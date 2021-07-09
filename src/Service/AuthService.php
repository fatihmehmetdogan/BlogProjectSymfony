<?php


namespace App\Service;

use App\Entity\Blog;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegisterService
 * @package App\Service
 */
class AuthService
{
    protected $passwordEncoder;
    protected $em;
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param $registerInfo
     */
    public function signUp($registerInfo)
    {
//        var_dump($registerInfo);exit();
        $user = new User();
        $user->setEmail($registerInfo['email']);
        $user->setRoles(['ROLE_ADMIN']);
        $password = $registerInfo['password'];
        $confirmPassword = $registerInfo['confirm_password'];
//        var_dump($mail);exit();
        if($password !== $confirmPassword)
        {
          echo 'Girdiğiniz parola uyuşmuyor';
        }
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'engage'));
        try {
            $this->em->persist($user);
            $this->em->flush();
        }catch (ORMException $e){
            echo  $e->getMessage();exit();
        }


    }




}