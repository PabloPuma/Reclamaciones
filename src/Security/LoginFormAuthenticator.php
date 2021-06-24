<?php

namespace App\Security;

use App\Repository\UsuarioRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private $userRepository;
    private $router;
    private $csrfTokenManager;
    private $passwordEncoder;
    private $login_route;

    public function __construct(UsuarioRepository $userRepository,RouterInterface $router,UserPasswordEncoderInterface $passwordEncoder,CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->userRepository = $userRepository;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }



    public function supports(Request $request)
    {
        $this->login_route = $request->attributes->get('_route');
        return  ($request->attributes->get('_route')==='app_login')
            && $request->isMethod('POST');
    }


    public function getCredentials(Request $request)
    {
        $credentials = [
            'username'=>$request->request->get('username'),
            'password'=>$request->request->get('password'),
            'csrf_token'=>$request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials["username"]
        );
        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate',$credentials["csrf_token"]);
        if (!$this->csrfTokenManager->isTokenValid($token)){
            throw new InvalidCsrfTokenException();
        }

        $user = $this->userRepository->findOneByUsernameOrEmail($credentials["username"]);
        if(is_null($user)){
            throw new CustomUserMessageAuthenticationException("ERROR EN EL USUARIO VERIFIQUELO POR FAVOR.");
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $password= $this->passwordEncoder->isPasswordValid($user,$credentials["password"]);
        if($password==false){
                 throw new CustomUserMessageAuthenticationException("ERROR EN LA CONTRASEÑA VERIFIQUELO POR FAVOR.");
        }
        $user->setLastLogin(new \DateTime());
        $this->userRepository->saveUser($user);
        return $password  ;
    }


    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {

        if ($targetPath = $this->getTargetPath($request->getSession(),$providerKey)){
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->router->generate("app_admin_index"));
    }

    protected function getLoginUrl()
    {
        return $this->router->generate("app_login");
    }

}