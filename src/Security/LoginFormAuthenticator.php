<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // For example:
        // if ($roles[]='ROLE_GESTIONNARE') {
        //     // c'est un aministrateur : on le rediriger vers l'espace admin
        //     return new RedirectResponse($this->urlGenerator->generate('tableau_bord'));
        // } else {
        //     // c'est un utilisaeur lambda : on le rediriger vers l'accueil
        //     return new RedirectResponse($this->urlGenerator->generate('mes_commandes'));
        // }
        // return new RedirectResponse($this->urlGenerator->generate('some_route'));
        // return new RedirectResponse($this->urlGenerator->generate('mes_commandes'));
        $roles = $token->getRoleNames();
        $rolesTab = array_map(function ($role) {
            return $role;
        }, $roles);
        // dump($rolesTab);
        // die('okkk');
        if (in_array('ROLE_GESTIONNAIRE', $rolesTab, true)) {
            // c'est un gestionnaire : on le rediriger vers l'espace gestionnaire
            // dump($rolesTab);
            //     die('okkk');
            $redirection = new RedirectResponse($this->urlGenerator->generate('tableau_bord'));
        } elseif (in_array('ROLE_USER', $rolesTab, true)) {
            // c'est un utilisaeur lambda : on le rediriger vers l'accueil
            $redirection = new RedirectResponse($this->urlGenerator->generate('panier'));
        }
        // dd($roles);

        return $redirection;

    }

        

        
    

    

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
