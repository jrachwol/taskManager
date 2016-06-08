<?php

namespace AppBundle\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface as Templating;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use AppBundle\Mailer\UserMailer;
use AppBundle\Entity\User;
use AppBundle\Exception\UserException;


class UserManager {

    /**
     * @var Doctrine
     */
    protected $doctrine;
        
    /**
     * @var Router
     */
    protected $router; 
    
    /**
     * @var Templating 
     */
    protected $templating;

    /**
     * @var EncoderFactory
     */
    protected $encoderFactory;
    
    /**
     * @var UserMailer
     */
    protected $userMailer;
    
    
    function __construct(Doctrine $doctrine, Router $router, Templating $templating, EncoderFactory $encoderFactory, UserMailer $userMailer) {
        $this->doctrine = $doctrine;
        $this->router = $router;
        $this->templating = $templating;
        $this->encoderFactory = $encoderFactory;
        $this->userMailer = $userMailer;
    }

// Generate Action Token

    protected function generateActionToken() {
        return substr(md5(uniqid(NULL, TRUE)), 0, 20);
    }

// Generate new password

protected function getRandomPassword($length = 8){
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}


// Send link reset password

    public function sendResetPasswordLink($userEmail) {

        $user = $this->doctrine->getRepository('AppBundle:User')
                               ->findOneByEmail($userEmail);

        if(null === $user){
            throw new UserException('Nie znaleziono takiego użytkownika.');
        }

        $user->setActionToken($this->generateActionToken());

        $em = $this->doctrine->getManager();
        $em->persist($user);
        $em->flush();
        
        $urlParams = array(
            'actionToken' => $user->getActionToken()
        );

        $resetUrl = $this->router->generate('user_reset_password', $urlParams, UrlGeneratorInterface::ABSOLUTE_URL);

        $emailBody = $this->templating->render('AppBundle:Email:passwordResetLink.html.twig', array(
            'resetUrl' => $resetUrl
        ));

        $this->userMailer->send($user, 'Link resetujący hasło', $emailBody);
        
        return true;
    }


// Reset Password

    public function resetPassword($actionToken) {

        $user = $this->doctrine->getRepository('AppBundle:User')
                        ->findOneByActionToken($actionToken);

        if(null === $user){
            throw new UserException('Podano błędne parametry akcji');
        }
        
        $plainPassword = $this->getRandomPassword();

        $encoder = $this->encoderFactory->getEncoder($user);
        $encodedPassword = $encoder->encodePassword($plainPassword, $user->getSalt());

        $user->setPassword($encodedPassword);
  
        $user->setActionToken(null);

        $em = $this->doctrine->getManager();
        $em->persist($user);
        $em->flush();

        $emailBody = $this->templating->render('AppBundle:Email:newPassword.html.twig', array(
            'plainPassword' => $plainPassword
        ));
        
        $this->userMailer->send($user, 'Nowe hasło do konta', $emailBody);
        
        return true;
    }


// Send link activate account

    public function registerUser(User $user) {

        if(null !== $user->getId()){
            throw new UserException('Użytkownik jest już zarejestrowany');
        }
        
        $encoder = $this->encoderFactory->getEncoder($user);
        $encodedPassword = $encoder->encodePassword($user->getPlainPassword(), $user->getSalt());
        
        $user->setPassword($encodedPassword);
        $user->setActionToken($this->generateActionToken());
        $user->setEnabled(false); 
        
        $em = $this->doctrine->getManager();
        $em->persist($user);
        $em->flush();
        
        $urlParams = array(
            'actionToken' => $user->getActionToken()
        );
    
        $activationUrl = $this->router->generate('user_activate_account', $urlParams, UrlGeneratorInterface::ABSOLUTE_URL);

        $emaiBody = $this->templating->render('AppBundle:Email:accountActivation.html.twig', array(
            'activationUrl' => $activationUrl
        ));
     
        $this->userMailer->send($user, 'Aktywacja konta', $emaiBody);
        
        return true;
    }

// Activate account

    public function activateAccount($actionToken){
        $user = $this->doctrine->getRepository('AppBundle:User')
                        ->findOneByActionToken($actionToken);

        if(null === $user){
            throw new UserException('Podano błędnę parametry akcji.');
        }

        $user->setEnabled(true);

        $user->setActionToken(null);
        
        $em = $this->doctrine->getManager();
        $em->persist($user);
        $em->flush();
        
        return true;
    }

// Change password

    public function changePassword(User $user){

        if(null == $user->getPlainPassword()){
            throw new UserException('Nie ustawiono nowego hasła!');
        }

        $encoder = $this->encoderFactory->getEncoder($user);
        $encoderPassword = $encoder->encodePassword($user->getPlainPassword(), $user->getSalt());
        $user->setPassword($encoderPassword);

        $em = $this->doctrine->getManager();
        $em->persist($user);
        $em->flush();

        return true;
    }
    
}
