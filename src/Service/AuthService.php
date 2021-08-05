<?php


namespace App\Service;

use App\Entity\Blog;
use App\Entity\Member;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Exception;
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
     * @param $validateEmail
     * @param $validatePassword
     * @param $validateConfirm
     * @throws Exception
     */
    public function signUp($validateEmail, $validatePassword, $validateConfirm)
    {
//        var_dump($registerInfo);exit();
        $user = new User();
        $user->setEmail($validateEmail);
        $user->setRoles(['ROLE_ADMIN']);
//        var_dump($validateEmail);exit();
        if($validatePassword !== $validateConfirm)
        {
          throw new Exception("Girdiğiniz Parolalar uyuşmuyor");
        }
        $user->setPassword($this->passwordEncoder->encodePassword($user, $validatePassword));
        try {
            $this->em->persist($user);
            $this->em->flush();
        }catch (ORMException $e){
            echo  $e->getMessage();exit();
        }
    }

    public function login($validateEmail, $validatePassword){
//        var_dump($registerInfo);exit();

        $adminUser =  $this->em->getRepository(User::class);
      /** @var User $user */
      $user = $adminUser->findOneBy(['email' => $validateEmail]);

      if (!$user){
        echo 'hatalı'; exit();
      }


      if (!$this->passwordEncoder->isPasswordValid($user, $validatePassword)){
          echo 'hatalı parola'; exit();
      }
    }

    public function memberLogin($validateEmail, $validatePassword){
//        var_dump($registerInfo);exit();

        $adminUser =  $this->em->getRepository(Member::class);
        /** @var User $user */
        $user = $adminUser->findOneBy(['email' => $validateEmail]);

        if (!$user){
            echo 'hatalı'; exit();
        }


        if (!$this->passwordEncoder->isPasswordValid($user, $validatePassword)){
            echo 'hatalı parola'; exit();
        }
    }


}