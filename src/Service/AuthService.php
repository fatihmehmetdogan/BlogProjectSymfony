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
    public function signUp($validatemail, $validatepassword, $validateconfirm)
    {
//        var_dump($registerInfo);exit();
        $user = new User();
        $user->setEmail($validatemail);
        $user->setRoles(['ROLE_ADMIN']);
//        var_dump($mail);exit();
        if($validatepassword !== $validateconfirm)
        {
          echo 'Girdiğiniz parola uyuşmuyor';
        }
        $user->setPassword($this->passwordEncoder->encodePassword($user, $validatepassword));
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


}